<?php

require_once SYSTEM.'request.php';
require_once SYSTEM.'response.php';

class Utils {

	public static function getPerformedRequest() {
		$requestProtocol = $_SERVER['SERVER_PROTOCOL'];
		$requestMethod = $_SERVER['REQUEST_METHOD'];
		$requestURI = key($_GET);

		if(strpos($requestURI, '_json'))
			$requestURI = str_replace('_json', '.json', $requestURI);

		$requestAcceptedData = $_SERVER['HTTP_ACCEPT'];

		if(strtoupper($requestMethod) == 'POST') {
			if(isset($_POST['_method'])) {
				switch(strtoupper($_POST['_method'])) {
					case Method::PUT:
						$requestMethod = Method::PUT;
						break;

					case Method::DELETE:
						$requestMethod = Method::DELETE;
						break;
					
					default:
						break;
				}
			}
		}

		return new Request($requestProtocol, $requestMethod, $requestURI, $requestAcceptedData);
	}

	public static function tps() {
		$decalage = 0;
		return time() + $decalage*3600;
	}

	public static function relative_time($iTime) {
		$iTimeDifference = time() - $iTime;

		if( $iTimeDifference<0 ) { return; }

		$iSeconds = $iTimeDifference ;
		$iMinutes = round( $iTimeDifference/60 );
		$iHours = round( $iTimeDifference/3600 );
		$iDays = round( $iTimeDifference/86400 );
		$iWeeks = round( $iTimeDifference/604800 );
		$iMonths = round( $iTimeDifference/2419200 );
		$iYears = round( $iTimeDifference/29030400 );
		$return = 'Il y a';

		if( $iSeconds<60 ){
		$return .= " ".'moins d\' une minute';}
		elseif( $iMinutes<60 ){
		$return .= " ".$iMinutes . ' minute' . ( $iMinutes>1 ? 's' : '' );}
		elseif( $iHours<24 ){
		$return .= " ".$iHours . ' heure' . ( $iHours>1 ? 's' : '' );}
		elseif( $iDays<7 ){
		$return .= " ".$iDays . ' jour' . ( $iDays>1 ? 's' : '' );}
		elseif( $iWeeks <4 ){
		$return .= " ".$iWeeks . ' semaine' . ( $iWeeks>1 ? 's' : '' );}
		elseif( $iMonths<12 ){
		$return .= " ".$iMonths . ' mois';}
		else{
		$return .= " ".$iYears . ' an' . ( $iYears>1 ? 's' : '' );}
		return $return;
	}

	public static function secure($str) {
		return htmlentities(strip_tags(stripslashes($str)), ENT_QUOTES, 'UTF-8');
	}

	public static function secureArray($array) {
		$secureArray = array();

		foreach ($array as $key => $value) {
			if(is_string($value)) {
				$secureArray[$key] = Utils::secure($value);
			}
		}

		return $secureArray;
	}

	public static function stringStartsWith($haystack, $needle) {
		return !strncmp($haystack, $needle, strlen($needle));
	}

	public static function stringEndsWith($haystack, $needle) {
		$length = strlen($needle);

		if ($length == 0) {
			return true;
		}

		return substr($haystack, -$length) === $needle ? true : false;
	}

	public static function objectToArray($data) {
		if(is_object($data))
			$data = get_object_vars($data);

		if(is_array($data))
			return $data;
		else
			return false;
	}

	public static function debug($data, $exit = false) {
		if($data) {
			print '<pre>';
			print_r($data);
			print '</pre>';
		}
		if($exit)
			exit();
	}

	public static function getNotFoundResponse() {
		$response = new Response(404);
		$response->setBody('The document that you are looking for does not exists !');

		return $response;
	}

	public static function getForbiddenResponse() {
		$response = new Response(403);
		$response->setBody('Forbidden');

		return $response;
	}

	public static function getUnauthorizedResponse() {
		$response = new Response(401);
		$response->setBody('Unauthorized');

		return $response;
	}

	public static function getInternalServerErrorResponse() {
		$response = new Response(500);
		$response->setBody('Error occurred while trying to treat the request (application error)');

		return $response;
	}

	public static function sendResponse($response) {
		if($response instanceof Response) {
			$response->send();
		}
		else {
			self::getInternalServerErrorResponse()->send();
		}
	}

	public static function validateUsername($string='') {
		if($string != '') {
			if(!preg_match('/[^0-9A-Za-z]/',$string)) return true;
		}

		return false;
	}

	public static function validateMail($string='') {
		if($string != '') {
			if(filter_var($string, FILTER_VALIDATE_EMAIL)) return true;
		}

		return false;
	}

	public static function validateVideoInfo($title, $description, $tags) {
		if(!empty($title) && !empty($description) && !empty($tags)) {
			return true;
		}

		return false;
	}

	public static function isUrlValid($url) {
		$fileHeaders = @get_headers($url);
		return strpos($fileHeaders[0], '200 OK') !== false;
	}

}