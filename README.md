# FormValidate
Form validation class written in PHP
## Getting started
### Requirements
PHP5
### Usage
test.php:
```
<?php

include("class.formvalidate.php");

$rules = array(
	"name" => array("required" => true, "minlength" => 2, "maxlength" => 50),
	"email" => array("required" => true, "type" => "email"),
	"url" => array("type" => "url"),
	"comment" => array("required" => true, "minlength" => 10),
	"comment_post_id" => array("type" => "numeric"),
	"comment_parent" => array("type" => "numeric"),
	"captcha" => array("minlength" => 6, "maxlength" => 6)
);

$_POST = array(
	"name" => "Chris",
	"email" => "aaa@bbb.cc",
	"url" => "http://www.foo.com",
	"comment" => "bla bla bla",
	"comment_post_id" => "bla bla bla",		// wrong
	"comment_parent" => 7,
	"captcha" => "aaaaaa"
);

try {
	$fv = new FormValidate($_POST, $rules);
	$fv->validate();
} catch (FormValidateException $e) {
	echo "The ".$e->getField()." variable doesn't match the ".$e->getProperty()." property.";
}

?>
```

The output will be:
```
The comment_post_id variable doesn't match the type property.
```
## License
Copyright (c) 2015 Krisztian CSANYI Licensed under the GPLv2 license.
