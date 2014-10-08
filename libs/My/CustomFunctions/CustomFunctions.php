<?php
namespace My\CustomFunctions;

function trimAll ($element) {
	if (!is_array ($element)) {
		$element = trim ($element);
	} else {
		$element = array_map (trimAll, $element);
	}
	return $element;
	
}

function intAll ($element) {
	if (!is_array ($element)) {
		$element = (int) ($element);
	} else {
		$element = array_map (intAll, $element);
	}
	return $element;
	
}

function floatAll ($element) {
	if (!is_array ($element)) {
		$element = (float) ($element);
	} else {
		$element = array_map (floatAll, $element);
	}
	return $element;
	
}

function hschAll ($element) {
	if (!is_array ($element)) {
		$element = htmlspecialchars ($element);
	} else {
		$element = array_map (hschAll, $element);
	}
	return $element;
	
}

function mresAll ($element) {
	if (!is_array ($element)) {
		$element = mysqli_real_escape_string ($element);
	} else {
		$element = array_map (mresAll, $element);
	}
	return $element;
	
}

