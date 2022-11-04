<?php

// No direct access
defined('_DIACCESS') or die;

class site{
	
	public static function redirect($url = "",$tipo = NULL,$base = true){
		if(strlen(trim($url)) <= 0){
			$url = "";
		}
		
		$base_url = $base == true ? BASE_URL."/" : "";
		
		$url = str_replace("&amp;","&",$url);
		
		if(strpos($url,"/") === 0){
			$url = substr($url,1);
		}
		
		if($tipo == 301){
			header("HTTP/1.1 301 Moved Permanently"); 
		}
		
		header("Location: ".$base_url.$url);
		exit;
	}
	
	public static function codificarJson($datos){
		if(function_exists('json_encode')){
			// found - use built-in json encoding
			$output = json_encode($datos);
			header('Content-Type: text/plain; charset=utf-8');
			echo '('.$output.')';
			die;
		}else{
			// not found - use external JSON library
			require_once(CLASSPATH.'json/PEAR.php');
			require_once(CLASSPATH.'json/Services_JSON.php');
			$json = new Services_JSON();
			$output = $json->encode($datos);
			header('HTTP/1.0 200 OK');
			header('Content-Type: application/javascript; charset=utf-8');
			echo "(".$output.")";
			die;
		}
	}
	
	public static function setSessionMessage($mensaje,$tipo = "ok"){
		if(strlen(trim($mensaje)) > 0){
			
			$nombre_var = $tipo == "ok" || $tipo == "error" || $tipo == "info" ? "session_message_".$tipo : "session_message_ok";
			
			if(isset($_SESSION[$nombre_var]) && count($_SESSION[$nombre_var]) > 0){
				$_SESSION[$nombre_var][] = $mensaje;
			}else{
				$_SESSION[$nombre_var] = array($mensaje);
			}
		}
	}
	
	public static function getSessionMessage($imprimir = true){
		$html = "";
		$resp_mensaje = "";
		if(isset($_SESSION["session_message_ok"]) && count($_SESSION["session_message_ok"]) > 0){
			$resp_mensaje = '';
			$resp_mensaje .= '<div class="alert alert-success alert-dismissable">';
			$resp_mensaje .= '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
			$resp_mensaje .= '<ul>';
			if(count($_SESSION["session_message_ok"]) > 1){
				$resp_mensaje .= "<li>".join("</li><li>",$_SESSION["session_message_ok"])."</li>";
			}else{
				$resp_mensaje .= "<li>".$_SESSION["session_message_ok"][0]."</li>";
			}
			$resp_mensaje .= '</ul>';
			$resp_mensaje .= '</div>';
			unset($_SESSION["session_message_ok"]);
		}
		$html .= $resp_mensaje;
		
		$resp_mensaje = "";
		if(isset($_SESSION["session_message_info"]) && count($_SESSION["session_message_info"]) > 0){
			$resp_mensaje = '';
			$resp_mensaje .= '<div class="alert alert-info alert-dismissable">';
			$resp_mensaje .= '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
			$resp_mensaje .= '<ul>';
			if(count($_SESSION["session_message_info"]) > 1){
				$resp_mensaje .= "<li>".join("</li><li>",$_SESSION["session_message_info"])."</li>";
			}else{
				$resp_mensaje .= "<li>".$_SESSION["session_message_info"][0]."</li>";
			}
			$resp_mensaje .= '</ul>';
			$resp_mensaje .= '</div>';
			unset($_SESSION["session_message_info"]);
		}
		$html .= $resp_mensaje;
		
		$resp_mensaje = "";
		if(isset($_SESSION["session_message_error"]) && count($_SESSION["session_message_error"]) > 0){
			$resp_mensaje = '';
			$resp_mensaje .= '<div class="alert alert-danger alert-dismissable">';
			$resp_mensaje .= '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
			$resp_mensaje .= '<ul>';
			if(count($_SESSION["session_message_error"]) > 1){
				$resp_mensaje .= "<li>".join("</li><li>",$_SESSION["session_message_error"])."</li>";
			}else{
				$resp_mensaje .= "<li>".$_SESSION["session_message_error"][0]."</li>";
			}
			$resp_mensaje .= '</ul>';
			$resp_mensaje .= '</div>';
			unset($_SESSION["session_message_error"]);
		}
		$html .= $resp_mensaje;
		
		if($imprimir){
			echo $html;
		}else{
			return $html;
		}
	}
}
?>