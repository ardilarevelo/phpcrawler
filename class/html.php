<?php

// No direct access
defined('_DIACCESS') or die;

// Class to manage the DOM
class html{
    
    private $html = "";
    
    // Constructor to define the HTML
    public function __construct($html){
        $this->html = $html;
    }
    
    // Get HTML
    public function getHTML(){
        return $this->html;
    }
    
    // Get all tags
    public function getAllByTag($searchTag){
        $openTag = "<".$searchTag;
        $closeTag = $searchTag == "img" ? '/>' : '</'.$searchTag.'>';
        
        
        $tags = array();
        // Separate all possible tags
        $tempTags = explode($openTag,$this->html);
        
        // Clean each tag
        for($i=1;$i<count($tempTags);$i++){
            $tempTag = $openTag.$tempTags[$i];
            $tag = substr($tempTag,0,strpos($tempTag,$closeTag) + strlen($closeTag));
            if($tag != ""){
                $tags[] = $tag;
            }
        }
        return $tags;
    }
    
    // Get attribute
    public function getAttribute($tag,$attribute){
        $parts = explode($attribute."=",$tag);
        
        if(isset($parts[1])){
            $quote_tag = trim($parts[1]);
            $quote_char = $quote_tag[0];
            $quote_tag = substr($parts[1],1);
            $attributeValue = substr($quote_tag,0,strpos($quote_tag,$quote_char));
            return $attributeValue;
        }
        return null;
    }
    
    // Delete tags
    public function deleteTags($tags){
        foreach($tags as $tag){
            $scripts = $this->getAllByTag($tag);
            foreach($scripts as $script){
                $this->html = str_replace($script,"",$this->html);
            }
        }
    }
    
}

