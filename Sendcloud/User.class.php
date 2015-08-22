<?php

/**
 * SendCloud  user infomation query
 * @author    widuu <admin@widuu.com>
 * @version   0.1
 * @copyright Copyright (c) 2015 http://www.widuu.com
 * @date      2015/08/20
 */

namespace Sendcloud;

class User extends Sendcloud{

	/**
	 * 用户信息查询
	 * @author widuu <admin@widuu.com>
	 */

	public function get_userinfo(){
		// 用户权限设置
		$params = self::set_auth();
		// 构建发送URL
		$post_url = self::SOHU_URL."userinfo.get.json";
		// POST数据
		$send_result = self::http_post($post_url,http_build_query($params));
		// 解析数据
		$send_result = json_decode($send_result,true);
		// 返回错误信息
		if( $send_result['message'] != 'success' ){
			return self::return_info(false,$send_result['errors'][0]);
		}
		// 返回用户信息
		return self::return_info(true,$send_result['userinfo']);
	}

	/**
	 * 获取API User
	 * @param $api_user_type  int API_USER的类型: 0(触发), 1(批量)
	 * @author widuu <admin@widuu.com>
	 */

	public function get_apiuser($api_user_type=1){
		// 用户权限设置
		$params = self::set_auth();
		// api user 类型
		$params['api_user_type'] = $api_user_type;
		// 构建发送URL
		$post_url = self::SOHU_URL."apiUser.list.json";
		// POST数据
		$send_result = self::http_post($post_url,http_build_query($params));
		// 解析数据
		$send_result = json_decode($send_result,true);
		// 返回错误信息
		if( $send_result['message'] != 'success' ){
			return self::return_info(false,$send_result['errors'][0]);
		}
		// 返回API User 信息
		return self::return_info(true,$send_result['apiUserList']);
	}

	/**
	 * 域名查询
	 * @param  $domain_type int  域名类型: 0(测试域名), 1(正常域名)
	 * @author widuu <admin@widuu.com>
	 */

	public function get_domain($domain_type=1){
		// 用户权限设置
		$params = self::set_auth();
		// api user 类型
		$params['domain_type'] = $domain_type;
		// 构建发送URL
		$post_url = self::SOHU_URL."domain.list.json";
		// POST数据
		$send_result = self::http_post($post_url,http_build_query($params));
		// 解析数据
		$send_result = json_decode($send_result,true);
		// 返回错误信息
		if( $send_result['message'] != 'success' ){
			return self::return_info(false,$send_result['errors'][0]);
		}
		// 返回API User 信息
		return self::return_info(true,$send_result['domainList']);
	}
}
