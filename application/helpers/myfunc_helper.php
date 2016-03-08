<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// 对密码加密
function md5pass($pass, $salt){
	return md5(substr($pass, 0, 10).$salt);
}

// 改进版的show_404
function ishow_404($message=NULL, $page = '', $log_error = TRUE) {
	if (isset($message)) {
		$heading = '404 Page Not Found';
		// By default we log this, but allow a dev to skip it
		if ($log_error)
		{
			log_message('error', $heading.': '.$page);
		}
		$_error =& load_class('Exceptions', 'core');
		echo $_error->show_error($heading, $message, 'error_404', 404);
		exit(4); // EXIT_UNKNOWN_FILE
	} else {
		show_404($page, $log_error);
	}
}

function ishow_error($heading, $message, $code, $page = '', $log_error = TRUE) {
	// By default we log this, but allow a dev to skip it
	if ($log_error)
	{
		log_message('error', $heading.': '.$page);
	}
	$_error =& load_class('Exceptions', 'core');
	echo $_error->show_error($heading, $message, 'error_general', $code);
	exit(EXIT_ERROR); // EXIT_UNKNOWN_FILE
}

function ishow_error_msg($message) {
	$_error =& load_class('Exceptions', 'core');
	echo $_error->show_error('出错啦', $message, 'error_general', 500);
	exit(EXIT_ERROR); // EXIT_UNKNOWN_FILE
}

// 过滤字段
function array_filter_by_key($key_values, $filter_keys) {
	if (empty($key_values)) {
		return array();
	}
	$result = array();
	array_merge_by_key($key_values, $result, $filter_keys);
	return $result;
}

function arrayofmap_to_keymap($arrmap, $key) {
	if (empty($arrmap) || !is_array($arrmap)) {
		return array();
	}
	$result = array();
	foreach ($arrmap as $map) {
		if (is_array($map) && isset($map[$key])) {
			$result[$map[$key]] = $map;
		}
	}
	return $result;
}

function array_merge_by_key($src, &$target, $filter_keys) {
	foreach ($src as $key => $value) {
		if (array_search($key, $filter_keys) === FALSE) {
			continue;
		}
		$target[$key] = $value;
	}
}

?>