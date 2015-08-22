<?php

/**
 * SendCloud  Base class
 * @author    widuu <admin@widuu.com>
 * @version   0.1
 * @copyright Copyright (c) 2015 http://www.widuu.com
 * @date      2015/08/20
 */

namespace Sendcloud;

class Sendcloud{

	public static $api_user = API_USER;

	public static $api_key  = API_KEY;

	const   SOHU_URL = "http://sendcloud.sohu.com/webapi/";


	/**
     * POST提交数据
     * @param  $url  		POST的URL地址
     * @param  $post_data   提交的信息
     * @author widuu <admin@widuu.com>
     */

	protected static function http_post($url, $post_data) {
	    $ch = curl_init();
		curl_setopt($ch, CURLOPT_POST, 1);
	    curl_setopt($ch, CURLOPT_URL, $url);
	    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
	    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
	    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
		$return_content =curl_exec($ch);
		$errorCode = curl_error($ch);
		curl_close ($ch); 
		return $return_content;
	}

	/**
     * 公共返回消息信息
     * @param  $status  	状态
     * @param  $info        返回信息或者数据
     * @author widuu <admin@widuu.com>
     */

	protected static function return_info($status,$info){
		return array('status'=>$status,'info'=>$info);
	}

	/**
	 * 设置用户信息参数
	 * @author widuu <admin@widuu.com>
	 */

	protected static function set_auth(){
		$params['api_user'] = self::$api_user;
		$params['api_key']  = self::$api_key;
		return $params;
	}

}