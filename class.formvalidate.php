<?php
/**
 * CLASS FORMVALIDATE
 * 
 * Form validation class
 *
 * @package formvalidate
 * @author Krisztian CSANYI
 * @version  0.0.1
 * @copyright 2015 Krisztian CSANYI
 * @link http://www.sitedesign.hu
 * 
 */

class FormValidateException extends Exception {
	public function __construct(Array $props) {
		$this->field = (isset($props["field"])) ? $props["field"] : false;
		$this->property = (isset($props["property"])) ? $props["property"] : false;
	}

	public function getField() {
		return $this->field;
	}

	public function getProperty() {
		return $this->property;
	}

}

class FormValidate {
	private $in = NULL;
	private $rules = NULL;

	public function __construct($in, $rules) {
		$this->in = $in;
		$this->rules = $rules;
	}

	public function __destruct() { }
	private function validateField($name) {
		$rule = $this->rules[$name];
		$empty = ($this->in[$name] == "") ? true : false;
		$req = (isset($rule["required"]) && ($rule["required"] == true )) ? true : false;
		$val = $this->in[$name];
		$len = strlen($val);

		if ($empty && $req) {
			throw new FormValidateException(array("field" => $name, "property" => "required"));
		}

		if (!$empty) {
			foreach ($rule as $k => $v) {
				switch ($k) {
					case "minlength":
					if ($len < $v)
						throw new FormValidateException(array("field" => $name, "property" => $k));
					break;
					case "maxlength":
					if ($len > $v)
						throw new FormValidateException(array("field" => $name, "property" => $k));
					break;
					case "type":
					switch ($v) {
						case "numeric":
						if (!is_numeric($val))
							throw new FormValidateException(array("field" => $name, "property" => $k));
						break;
						case "email":
						if (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/",$val))
							throw new FormValidateException(array("field" => $name, "property" => $k));
						break;
						case "url":
						if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$val))
						throw new FormValidateException(array("field" => $name, "property" => $k));
						break;
					}
					break;
				}
			}
		}
		unset($rule, $empty, $req, $val, $len);
		return 0;
	}

	public function validate() {
		foreach ($this->rules as $k => $v) {
			$this->validateField($k);
		}
		return true;
	}

}

?>
