<?php
namespace My\CustomFunctions;

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function hschAll ($element) {
	if (!is_array ($element)) {
		$element = htmlspecialchars ($element);
	} else {
		$element = array_map (hschAll, $element);
	}
	return $element;
	
}