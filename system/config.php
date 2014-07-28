<?php

require_once SYSTEM.'utils.php';

class Config {

	private static $configValues = array();

	private $file = 'nope';
	private $values = array();

	public function __construct($file) {
		if(file_exists($file))
			$this->file = $file;
	}

	public function parseFile() {
		if($this->file == 'nope')
			return;

		try {
			$data = file_get_contents($this->file);
			$json = json_decode($data);

			$this->values = $json;
		}
		catch(Exception $e) {

		}
	}

	public function getValue($key) {
		$values = Utils::objectToArray($this->values);
		return isset($values[$key]) ? $values[$key] : false;
	}

	public function getValues() {
		return $this->values;
	}

	// static
	public static function addValue($key, $value) {
		self::$configValues[$key] = $value;
	}

	public static function getValue_($key) {
		return isset(self::$configValues[$key]) ? self::$configValues[$key] : false;
	}

}