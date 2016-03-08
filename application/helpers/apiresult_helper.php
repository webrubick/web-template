<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 定义生成API的result的一些方法，及相关判断
 */

    function common_result($code, $msg, $data = NULL) {
		$result_data = array(
			'code' => $code,
			'msg' => $msg,
			'data' => $data,
		);
		return $result_data;
	}
	
	function common_result_use_pair($code_msg_pair, $data = NULL) {
		$result_data = array(
			'code' => $code_msg_pair['code'],
			'msg' => $code_msg_pair['msg'],
			'data' => $data,
		);
		return $result_data;
	}
	
	function common_result_ok($data = NULL) {
		return common_result_use_pair(__result_ok_pair(), $data);
	}

	/**
	 * 判断返回值是不是ok的
	 */
	function is_ok_result($result) {
		if (!isset($result)) {
			return FALSE;
		}
		if (!is_array($result)) {
			return isset($result->code) ? ($result_code == 200) : FALSE;
		}
		return $result['code'] == 200;
	}

	/**
	 * 请求成功后的通用返回
	 */
	function __result_ok_pair() {
		if (isset($__result_ok_pair)) {
			return $__result_ok_pair;
		}
		static $__result_ok_pair = array(
			'code' => 200,
			'msg' => 'success'
		);
		return $__result_ok_pair;
	}

?>