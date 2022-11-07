<?php

// No direct access
defined('_DIACCESS') or die;

// Class to manage the html
class page{
    
    private $id = "";
    private $source = "";
    private $htmlString = "";
    private $dom = null;
    public $json = array();
    private $uniqueLinks = array();
    private $uniqueImages = array();
    private $linksInternal = array();
    private $error = "";
    
    // Constructor to define the Page
    public function __construct($id,$source = "root"){
        $this->id = $id;
        $this->source = $source;
        $json_file = BASE_PATH."data/".$id.".json";
        $html_file = BASE_PATH."data/".$id.".html";
        if(file_exists($json_file) && file_exists($html_file)){
            $this->json = json_decode(file_get_contents(BASE_PATH."data/".$id.".json"),true);
            if(isset($this->json["htmlString"]) && file_exists(BASE_PATH."data/".$this->json["htmlString"])){
                $this->htmlString = file_get_contents(BASE_PATH."data/".$this->json["htmlString"]);
            }else{
                $this->htmlString = "";
            }
            $this->dom = new html($this->htmlString);
        }else{
            $this->error = "Json file not found";
        }
    }
    
    // Get error
    public function getError(){
        return $this->error;
    }
    
    // Process the page to obtain the data
    public function process(){
        // Get title
        $this->getTitle();
        // Get links
        $this->getUniqueLinks();
        // Get images
        $this->getUniqueImages();
        // Get images
        $this->getWords();
    }
    
    // Get title
    public function getTitle(){
        if(isset($this->json["title"])){
            return $this->json["title"];
        }else{
            $titles = $this->dom->getAllByTag("title");
            $title = isset($titles[0]) ? $titles[0] : "";
            $this->json["title"] = strip_tags($title);
            return $title;
        }
    }
    
    // Get links
    public function getUniqueLinks(){
        if(!empty($this->uniqueLinks)){
            return $this->uniqueLinks;
        }else{
            $links = array();
            $tagsLink = $this->dom->getAllByTag("a");
            foreach($tagsLink as $a){
                $link = $this->dom->getAttribute($a,"href");
                $occurrences = isset($links[$link]["occurrences"]) ? $links[$link]["occurrences"] + 1 : 1;
                $links[$link] = array("href" => $link,"type" => $this->getLinkType($link),"occurrences" => $occurrences,"source" => $this->source);
            }
            
            $this->uniqueLinks = $links;
            
            return $links;
        }
    }
    
    // Get Images
    public function getUniqueImages(){
        if(!empty($this->uniqueImages)){
            return $this->uniqueImages;
        }else{
            $images = array();
            $tagsImg = $this->dom->getAllByTag("img");
            foreach($tagsImg as $img){
                $src = $this->dom->getAttribute($img,"src");
                $data_src = "";
                if($src === null){
                    $data_src = $this->dom->getAttribute($img,"data-src");
                    $src = $data_src;
                }
                $occurrences = isset($images[$src]["occurrences"]) ? $images[$src]["occurrences"] + 1 : 1;
                $images[$src] = array("src" => $src,"data_src" => $data_src,"occurrences" => $occurrences,"source" => $this->source);
            }
            $this->uniqueImages = $images;
            
            return $images;
        }
    }
    
    // Follow the internal links
    public function processLinks($crawler,$response_Id){
        $countURLs = 0;
        foreach ($this->getUniqueLinks() as $link){
            // Ignore / and # links
            if(isset($link["href"]) && $link["href"][0] == "#" || $link["href"] == "/"){
                continue;
            }
            // Only scan internal links
            if(isset($link["type"]) && $link["type"] != "internal"){
                continue;
            }
            // Scan only until limit
            if($countURLs >= $crawler->getMaxPagesToScan()){
                break;
            }
            
            // Define the complete URL
            if($link["href"][0] == "/"){
                $internalUrl = $crawler->getBaseURL().$link["href"];
            }else{
                $internalUrl = $crawler->getBaseURL()."/".$link["href"];
            }
            
            // Create the Crawler
            $crawlerInternal = new crawler($internalUrl,0);
            // Create an ID for this request
            $response_Id_internalUrl = $response_Id."_url".$countURLs;
            // Create connection
            $crawlerInternal->connect();
            // Request the URL
            $crawlerInternal->request();
            // Save the data
            $crawlerInternal->saveResponse($response_Id_internalUrl);
            
            if($crawler->getInfo("http_code") === 200){
                // Process the page
                $pageInternal = new page($response_Id_internalUrl,"internal");
                $pageInternal->process();
                $this->linksInternal[$link["href"]]['json'] = $pageInternal->json;
                // Get unique links
                $this->linksInternal[$link["href"]]['links'] = $pageInternal->getUniqueLinks();
                // Get unique images
                $this->linksInternal[$link["href"]]['images'] = $pageInternal->getUniqueImages();
            }
            
            $countURLs++;
        }
    }
    
    // Merge root and internal links to identify uniques links
    public function mergeRootAndInternalLinks(){
        $uniqueLinks = $this->getUniqueLinks();
        $uniqueImages = $this->getUniqueImages();
        foreach ($this->linksInternal as $linkIntList){
            // Check the links to add
            foreach($linkIntList['links'] as $url => $linkInt){
                if(!isset($uniqueLinks[$url])){
                    $uniqueLinks[$url] = $linkInt;
                }else{
                    $uniqueLinks[$url]["occurrences"] = $uniqueLinks[$url]["occurrences"] + $linkInt["occurrences"];
                }
                // Add the page info
                if(!isset($uniqueLinks[$url]["scan"]) && isset($this->linksInternal[$url]['json'])){
                    $uniqueLinks[$url]["scan"] = $this->linksInternal[$url]['json'];
                }
            }
            // Check the images to add
            foreach($linkIntList['images'] as $src => $imgInt){
                if(!isset($uniqueImages[$src])){
                    $uniqueImages[$src] = $imgInt;
                }else{
                    $uniqueImages[$src]["occurrences"] = $uniqueImages[$src]["occurrences"] + $imgInt["occurrences"];
                }
            }
        }
        $this->json["UniqueLinks"] = $uniqueLinks;
        $this->json["uniqueImages"] = $uniqueImages;
    }
    
    // Get internal links
    private function getLinkType($link){
        if(substr($link,0,4) === 'http' || substr($link,0,5) === 'https'
            || substr($link,0,4) === 'tel:' || substr($link,0,7) === 'mailto:'){
            return 'external';
        }else{
            return 'internal';
        }
    }
    
    // Save json file
    public function saveJson(){
        // Save the links in the json file
        $fp = fopen(BASE_PATH."data/".$this->id.".json","w");
        fwrite($fp,json_encode($this->json));
        fclose($fp);
    }
    
    // Get words
    public function getWords(){
        $bodys = $this->dom->getAllByTag("body");
        $body = $bodys[0];
        $domBody = new html($body);
        // Delete JS
        $domBody->deleteTags(array("script"));
        // Delete tags
        $html = preg_replace ('/<[^>]*>/', ' ',$domBody->getHTML());
        // Clean spaces, tabs or newlines
        $html = str_replace(array("\r","\n","\t","  "),array(""," "," "," "),$html);
        // remove multiple spaces
        $html = trim(preg_replace('/ {2,}/', ' ', $html));
        $this->json["words"] = $html;
    }
    
    // Get Stats
    public function getStats(){
        
        $donutChart_HTTPCode = $HTTPCode = $areaCharLink = array();
        
        $numScan = $numInternalLinks = $numExternalLinks = 0;
        $sumLoadTime = isset($this->json["total_time"]) ? $this->json["total_time"] : 0;
        $sumWords = isset($this->json["words"]) ? count(explode(" ",$this->json["words"])) : 0;
        $sumTitle = isset($this->json["title"]) ? count(explode(" ",$this->json["title"])) : 0;
        
        // Root data
        $stats = array();
        $stats["maxPages"] = isset($this->json["maxPages"]) ? $this->json["maxPages"] : 0;
        $stats["numUniqueImages"] = isset($this->json["uniqueImages"]) ? count($this->json["uniqueImages"]) : 0;
        
        // Internal links
        if(isset($this->json["UniqueLinks"])){
            foreach($this->json["UniqueLinks"] as $key => $link){
                if($link["type"] == "internal"){
                    $numInternalLinks++;
                }else{
                    $numExternalLinks++;
                }
                if(isset($link["scan"])){
                    $numScan++;
                    $sumLoadTime = $sumLoadTime + $link["scan"]["total_time"];
                    // Words in content
                    $numWords = count(explode(" ",$link["scan"]["words"]));
                    $sumWords = $sumWords + $numWords;
                    // Words in title
                    $numWordsTitle = count(explode(" ",$link["scan"]["title"]));
                    $sumTitle = $sumTitle + $numWordsTitle;
                    
                    // Add status
                    $HTTPCode[$link["scan"]["http_code"]] = isset($HTTPCode[$link["scan"]["http_code"]]) ? $HTTPCode[$link["scan"]["http_code"]] + 1 : 1;
                    
                    // Add data for area char
                    $areaCharLink[] = array("idx" => $key,"total_time" => $link["scan"]["total_time"],"numWords" => $numWords,"numWordsTitle" => $numWordsTitle);
                }
            }
        }
        
        // Set the stats
        $stats["numScan"] = $numScan;
        $stats["numInternalLinks"] = $numInternalLinks;
        $stats["numExternalLinks"] = $numExternalLinks;
        $stats["avgLoadTime"] = $numScan > 0 ? $sumLoadTime/$numScan : 0;
        $stats["avgWords"] = $numScan > 0 ? $sumWords/$numScan : 0;
        $stats["avgTitle"] = $numScan > 0 ? $sumTitle/$numScan : 0;
        
        // Set donut chart
        foreach($HTTPCode as $key => $value){
            $donutChart_HTTPCode[] = array("label" => "HTTP Code: ".$key,"value" => $value);
        }
        
        return array($stats,$donutChart_HTTPCode,$areaCharLink);
    }
    
}

