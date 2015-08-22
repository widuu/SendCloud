<?php

/**
 * SendCloud  bounces class
 * @author    widuu <admin@widuu.com>
 * @version   0.1
 * @copyright Copyright (c) 2015 http://www.widuu.com
 * @date      2015/08/20
 */

namespace Sendcloud;

class Bounces extends Sendcloud{

	/**
	 * 查询退信信息
	 * @param  $days   		   int  	 过去 days 天内的统计数据
	 * @param  $start_date     string    开始日期, 格式为yyyy-MM-dd
	 * @param  $end_date       string    结束日期, 格式为yyyy-MM-dd
	 * @param  $email  		   string    查询该地址在退信列表中的详情
	 * @param  $start  		   int       查询起始位置, 取值区间 [0-], 默认为 0
	 * @param  $limit          int       查询个数, 取值区间 [0-100], 默认为 100
	 * @author widuu <admin@widuu.com>
	 */

	public function get_bounces($days,$start_date,$end_date,$email,$start,$limit){
		// 用户权限设置
		$params = self::set_auth();
		// 时间设置
		if( $days == 0 ){
			$params['start_date'] = $start_date;
			$params['end_date']   = $end_date;
		}else{
			$params['days'] = $days;
		}
		// 可选参数设置
		$option_param = array('email','start','limit');
		foreach ($option_params as $key ) {
			if( !empty($$key)) $params[$key] = $$key;			
		}
		// 构建发送URL
		$post_url = self::SOHU_URL."bounces.get.json";
		// POST数据
		$send_result = self::http_post($post_url,http_build_query($params));
		// 解析数据
		$send_result = json_decode($send_result,true);
		// 返回错误信息
		if( $send_result['message'] != 'success' ){
			return self::return_info(false,$send_result['errors'][0]);
		}
		// 返回退信信息
		return self::return_info(true,$send_result['bounces']);
	}

	/**
	 * 删除退信信息
	 * @param  $start_date     string    开始日期, 格式为yyyy-MM-dd
	 * @param  $end_date       string    结束日期, 格式为yyyy-MM-dd
	 * @param  $email  		   string    要删除的地址
	 * @author widuu <admin@widuu.com>
	 */

	public function delete_bounces($start_date,$end_date,$email){
		// 用户权限设置
		$params = self::set_auth();
		// 可选参数设置
		$option_param = array('start_date','end_date','email');
		foreach ($option_params as $key ) {
			if( !empty($$key)) $params[$key] = $$key;			
		}
		// 构建发送URL
		$post_url = self::SOHU_URL."bounces.delete.json";
		// POST数据
		$send_result = self::http_post($post_url,http_build_query($params));
		// 解析数据
		$send_result = json_decode($send_result,true);
		// 返回错误信息
		if( $send_result['message'] != 'success' ){
			return self::return_info(false,$send_result['errors'][0]);
		}
		// 返回退信信息
		return self::return_info(true,$send_result['del_count']);
	}

	/**
	 * 退信计数查询
	 * @param  $days  		   int       过去 days 天内的统计数据 (days=1表示今天)
	 * @param  $start_date     string    开始日期, 格式为yyyy-MM-dd
	 * @param  $end_date       string    结束日期, 格式为yyyy-MM-dd
	 * @author widuu <admin@widuu.com>
	 */

	public function count_bounces($days,$start_date,$end_date,$email){
		// 用户权限设置
		$params = self::set_auth();
		// 时间设置
		if( $days == 0 ){
			$params['start_date'] = $start_date;
			$params['end_date']   = $end_date;
		}else{
			$params['days'] = $days;
		}
		// 可选参数设置
		if( !empty($email) ) $params['email'] = $email;
		// 构建发送URL
		$post_url = self::SOHU_URL."bounces.count.json";
		// POST数据
		$send_result = self::http_post($post_url,http_build_query($params));
		// 解析数据
		$send_result = json_decode($send_result,true);
		// 返回错误信息
		if( $send_result['message'] != 'success' ){
			return self::return_info(false,$send_result['errors'][0]);
		}
		// 返回退信信息
		return self::return_info(true,$send_result['count']);
	}
}