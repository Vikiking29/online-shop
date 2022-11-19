<?php
if(!array_key_exists('type1', $_GET)){
	$type1 = "non";
}else{
	$type1 = $_GET['type1'];
}
if(!array_key_exists('type2', $_GET)){
	$type2 = "non";
}
else{
	$type2 = $_GET['type2'];
}
if(!array_key_exists('type3', $_GET)){
	$type3 = "non";
}
else{
	$type3 = $_GET['type3'];
}

$range = (float)$_GET['range'];

$_SESSION['filters']['range']['end'] = $range;

if($type1 == 'on'){
	$_SESSION['filters']['types']['type1'] = "checked";
}else{
	$_SESSION['filters']['types']['type1'] = "non";
}
if($type2 == 'on'){
	$_SESSION['filters']['types']['type2'] = "checked";
}else{
	$_SESSION['filters']['types']['type2'] = "non";
}
if($type3 == 'on'){
	$_SESSION['filters']['types']['type3'] = "checked";
}else{
	$_SESSION['filters']['types']['type3'] = "non";
}

header("Location: /show-items");
die;
?>