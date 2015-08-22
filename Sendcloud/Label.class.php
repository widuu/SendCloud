<?php

/**
 * SendCloud  label  class
 * @author    widuu <admin@widuu.com>
 * @version   0.1
 * @copyright Copyright (c) 2015 http://www.widuu.com
 * @date      2015/08/20
 */

namespace Sendcloud;

class Label extends Sendcloud{

	/**
	 * Lable 批量查询
	 * @param  $start int 查询起始位置, 取值区间 [0-], 默认为 0
	 * @param  $limit int 查询个数, 取值区间 [0-100], 默认为 100
	 * @author widuu <admin@widuu.com>
	 */

	public function list_label($start=0,$limit=100){
		// 用户权限设置
		$params = self::set_auth();
		// 参数设置
		$params['start'] = $start;
		$params['limit'] = $limit;
		// 构建发送URL
		$post_url = self::SOHU_URL."label.list.json";
		// POST数据
		$result = self::http_post($post_url,http_build_query($params));
		// 解析数据
		$result = json_decode($result,true);
		// 返回错误信息
		if( $result['message'] != 'success' ){
			return self::return_info(false,$result['errors'][0]);
		}
		// 返回列表信息
		return self::return_info(true,$result['list']);
	}

	/**
	 * 单个查询
	 * @param $labelid   string  标签ID
	 * @author widuu <admin@widuu.com>
	 */

	public function get_label($labelid){
		// 用户权限设置
		$params = self::set_auth();
		// 参数设置
		$params['labelId'] = $labelid;
		// 构建发送URL
		$post_url = self::SOHU_URL."label.get.json";
		// POST数据
		$result = self::http_post($post_url,http_build_query($params));
		// 解析数据
		$result = json_decode($result,true);
		// 返回错误信息
		if( $result['message'] != 'success' ){
			return self::return_info(false,$result['errors'][0]);
		}
		// 返回列表信息
		return self::return_info(true,$result['label']);
	}

	/**
	 * 添加Label信息
	 * @param  $label_name string  需要添加的标签名称
	 * @author widuu <admin@widuu.com>
	 */

	public function add_label($label_name){
		// 用户权限设置
		$params = self::set_auth();
		// 参数设置
		$params['labelName'] = $label_name;
		// 构建发送URL
		$post_url = self::SOHU_URL."label.create.json";
		// POST数据
		$result = self::http_post($post_url,http_build_query($params));
		// 解析数据
		$result = json_decode($result,true);
		// 返回错误信息
		if( $result['message'] != 'success' ){
			return self::return_info(false,$result['errors'][0]);
		}
		// 返回标签信息
		return self::return_info(true,$result['label']);
	}

	/**
	 * 删除Label信息
	 * @param  $labelId string  需要添加的标签名称
	 * @author widuu <admin@widuu.com>
	 */

	public function add_label($labelId){
		// 用户权限设置
		$params = self::set_auth();
		// 参数设置
		$params['labelId'] = $labelId;
		// 构建发送URL
		$post_url = self::SOHU_URL."label.delete.json";
		// POST数据
		$result = self::http_post($post_url,http_build_query($params));
		// 解析数据
		$result = json_decode($result,true);
		// 返回错误信息
		if( $result['message'] != 'success' ){
			return self::return_info(false,$result['errors'][0]);
		}
		// 返回删除个数
		return self::return_info(true,$result['deleteCount']);
	}

	/**
	 * 更新Label信息
	 * @param  $labelId   string  需要更新的标签ID
	 * @param  $labelName string  需要更新的标签名称
	 * @author widuu <admin@widuu.com>
	 */

	public function update_label($labelId,$labelName){
		// 用户权限设置
		$params = self::set_auth();
		// 参数设置
		$params['labelId']   = $labelId;
		$params['labelName'] = $labelName;
		// 构建发送URL
		$post_url = self::SOHU_URL."label.update.json";
		// POST数据
		$result = self::http_post($post_url,http_build_query($params));
		// 解析数据
		$result = json_decode($result,true);
		// 返回错误信息
		if( $result['message'] != 'success' ){
			return self::return_info(false,$result['errors'][0]);
		}
		// 返回更新个数
		return self::return_info(true,$result['updateCount']);
	}

}