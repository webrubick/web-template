<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// api基类，API是一种特殊的controller
class API {

	protected $common_apicode = array(
		90000 => '用户未登录'
	);

	/**
	 * Class constructor
	 *
	 * @return	void
	 */
	public function __construct() {
		log_message('info', 'API Class Initialized');
		// do sth. common
		
	}

	/**
	 * 需要登录状态的API通过此方法判断是否已经登录；
	 * 
	 * 如果没有登录，返回封装好的错误数据；
	 *
	 * 否则，返回FALSE
	 *
	 * @return	array or FALSE
	 */
	public function un_login() {
		// 如果没有登录
		return $this->cex(90000);
	}


	/**
	 * 通用的不正确/非正常的API返回结果，形如：
	 * 
	 * {'code':90000, 'msg':'xxx err', 'data':null}
	 *
	 * @return	array
	 */
	public function cex($code, $data = NULL) {
		if (isset($this->common_apicode[$code])) {
			return common_result($code, $this->common_apicode[$code], $data);
		}
		return common_result($code, '未定义的通用错误码: '.$code, $data);
	}

	/**
	 * 不正确/非正常的API返回结果，形如：
	 * 
	 * {'code':10001, 'msg':'xxx err', 'data':null}
	 *
	 * @return	array
	 */
	public function ex($code, $data = NULL) {
		if (isset($this->apicode)) {
			if (isset($this->apicode[$code])) {
				return common_result($code, $this->apicode[$code], $data);
			}
			return common_result($code, '未定义的错误码: '.$code, $data);
		}
		return common_result($code, '未定义错误码列表', $data);
	}

	/**
	 * 正确的API返回结果，形如：
	 * 
	 * {'code':200, 'msg':'success', 'data':null}
	 *
	 * @return	array
	 */
	public function ok($data = NULL) {
		return common_result_ok($data);
	}

	// --------------------------------------------------------------------

	/**
	 * __get magic
	 *
	 * Allows models to access CI's loaded classes using the same
	 * syntax as controllers.
	 *
	 * @param	string	$key
	 */
	public function __get($key)
	{
		// Debugging note:
		//	If you're here because you're getting an error message
		//	saying 'Undefined Property: system/core/Model.php', it's
		//	most likely a typo in your model code.
		return get_instance()->$key;
	}

}

?>