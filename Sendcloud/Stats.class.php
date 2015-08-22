<?php

/**
 * SendCloud  stats
 * @author    widuu <admin@widuu.com>
 * @version   0.1
 * @copyright Copyright (c) 2015 http://www.widuu.com
 * @date      2015/08/20
 */

namespace Sendcloud;

class Stats extends Sendcloud{

	/**
	 * 发送数据统计
	 * @param  $type           int       1 每天 2 每小时 3 无效邮件
	 * @param  $days   		   int  	 过去 days 天内的统计数据
	 * @param  $start_date     string    开始日期, 格式为yyyy-MM-dd
	 * @param  $end_date       string    结束日期, 格式为yyyy-MM-dd
	 * @param  $api_user_list  string    获取指定 API_USER 的统计数据, 多个 API_USER 用;分开, 如:api_user_list=a;b;c
	 * @param  $label_id_list  string    获取指定标签下的统计数据, 多个标签用;分开, 如:label_id_list=a;b;c
	 * @param  $domain_list    string    获取指定域名下的统计数据, 多个域名用;分开, 如:domain_list=a;b;c
	 * @param  $aggregate      int(1, 0) 默认为0. 如果为1, 则返回聚合数据
	 * @author widuu <admin@widuu.com>
	 */

	public function get_stats($type = 1,$days=0,$start_date,$end_date,$api_user_list='',$label_id_list='',$domain_list='',$aggregate=1){
		// 用户权限设置
		$params = self::set_auth();
		// 时间设置
		if( $days == 0 ){
			$params['start_date'] = $start_date;
			$params['end_date']   = $end_date;
		}else{
			$params['days'] = $days;
		}
		// 聚合显示设置
		$params['aggregate'] = $aggregate;
		// 可选参数设置
		$option_param = array('api_user_list','label_id_list','domain_list');
		foreach ($option_params as $key ) {
			if( !empty($$key)) $params[$key] = $$key;			
		}
		// 查询类型
		switch ( $type ) {
			case 1:
				$get_type = "stats.get.json";      //按天查询
				break;
			case 2:
				$get_type = "statsHour.get.json";  //小时查询
				break;
			case 3:
				$get_type = "invalidStat.get.json"; //无效邮件
				break;
			default:
				$get_type = "stats.get.json";
				break;
		}
		// 构建发送URL
		$post_url = self::SOHU_URL.$get_type;
		// POST数据
		$send_result = self::http_post($post_url,http_build_query($params));
		// 解析数据
		$send_result = json_decode($send_result,true);
		// 返回错误信息
		if( $send_result['message'] != 'success' ){
			return self::return_info(false,$send_result['errors'][0]);
		}
		// 返回邮件地址列表
		return self::return_info(true,$send_result['stats']);
	}

	/**
	 * 队列状态查询
	 * @author widuu <admin@widuu.com>
	 */

	public function queue_status(){
		// 用户权限设置
		$params = self::set_auth();
		// 构建发送URL
		$post_url = self::SOHU_URL."queueStatus.get.json";
		// POST数据
		$send_result = self::http_post($post_url,http_build_query($params));
		// 解析数据
		$send_result = json_decode($send_result,true);
		// 返回错误信息
		if( $send_result['message'] != 'success' ){
			return self::return_info(false,$send_result['errors'][0]);
		}
		// 返回队列列表
		return self::return_info(true,$send_result['queueStatus']);
	}

	/**
	 * 垃圾举报查询
	 * @param  $days   		   int  	 过去 days 天内的统计数据
	 * @param  $start_date     string    开始日期, 格式为yyyy-MM-dd
	 * @param  $end_date       string    结束日期, 格式为yyyy-MM-dd
	 * @param  $email  		   string    查询该地址在举报列表中的详情
	 * @param  $start  		   int       查询起始位置, 取值区间 [0-], 默认为 0
	 * @param  $limit          int       查询个数, 取值区间 [0-100], 默认为 100
	 * @author widuu <admin@widuu.com>
	 */

	public function get_spamReported($days,$start_date,$end_date,$email,$start,$limit){
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
		$post_url = self::SOHU_URL."spamReported.get.json";
		// POST数据
		$send_result = self::http_post($post_url,http_build_query($params));
		// 解析数据
		$send_result = json_decode($send_result,true);
		// 返回错误信息
		if( $send_result['message'] != 'success' ){
			return self::return_info(false,$send_result['errors'][0]);
		}
		// 返回举报退信信息
		return self::return_info(true,$send_result['bounces']);
	}

}