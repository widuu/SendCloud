<?php

/**
 * SendCloud  Address class
 * @author    widuu <admin@widuu.com>
 * @version   0.1
 * @copyright Copyright (c) 2015 http://www.widuu.com
 * @date      2015/08/20
 */

namespace Sendcloud;

class Address extends Sendcloud{

	/**
	 * 邮件地址列表
	 * @param  $address string   列表别名地址
	 * @param  $start   int 	 查询起始位置, 取值区间 [0-], 默认为 0
	 * @param  $limit   int 	 查询个数, 取值区间 [0-100], 默认为 100
	 * @author widuu <admin@widuu.com>
	 */

	public static function get_address($address='',$start=0,$limit=100){
		// 地址名称
		if( !empty($address) ) $params['address'] = $address;
		// 用户权限设置
		$params = self::set_auth();
		// 参数设置
		$params['start'] = $start;
		$params['limit'] = $limit;
		// 构建发送URL
		$post_url = self::SOHU_URL."list.get.json";
		// POST数据
		$result = self::http_post($post_url,http_build_query($params));
		// 解析数据
		$result = json_decode($result,true);
		// 返回错误信息
		if( $result['message'] != 'success' ){
			return self::return_info(false,$result['errors'][0]);
		}
		unset($result['message']);
		// 返回地址列表信息
		return self::return_info(true,$result);
	}

	/**
	 * 创建邮件地址列表
	 * @param  $address 	string  列表别称地址, 使用该别称地址进行调用, 格式为xxx@maillist.sendcloud.org
	 * @param  $name    	string  列表名称
	 * @param  $description string  对列表的描述信息
	 * @author widuu <admin@widuu.com>
	 */

	public function create_address($address,$name,$description=''){
		// 描述信息
		if( !empty($description) ) $params['description'] = $description;
		// 用户权限设置
		$params = self::set_auth();
		// 参数设置
		$params['address'] = $address;
		$params['name']    = $name;
		// 构建发送URL
		$post_url = self::SOHU_URL."list.create.json";
		// POST数据
		$result = self::http_post($post_url,http_build_query($params));
		// 解析数据
		$result = json_decode($result,true);
		// 返回错误信息
		if( $result['message'] != 'success' ){
			return self::return_info(false,$result['errors'][0]);
		}
		// 返回创建信息
		return self::return_info(true,$result['list']);
	}

	/**
	 * 更新邮件地址列表
	 * @param  $address 	string  列表别称地址, 使用该别称地址进行调用, 格式为xxx@maillist.sendcloud.org
	 * @param  $toAddress   string  修改后的别称地址
	 * @param  $name    	string  列表名称
	 * @param  $description string  对列表的描述信息
	 * @author widuu <admin@widuu.com>
	 */

	public function update_address($address,$toAddress='',$name='',$description=''){
		// 描述信息
		if( !empty($description) ) $params['description'] = $description;
		// 用户权限设置
		$params = self::set_auth();
		// 参数设置
		$params['address'] 	 = $address;
		$params['toAddress'] = $toAddress;
		$params['name']      = $name;
		// 构建发送URL
		$post_url = self::SOHU_URL."list.update.json";
		// POST数据
		$result = self::http_post($post_url,http_build_query($params));
		// 解析数据
		$result = json_decode($result,true);
		// 返回错误信息
		if( $result['message'] != 'success' ){
			return self::return_info(false,$result['errors'][0]);
		}
		// 返回更新列表信息
		return self::return_info(true,$result['list']);
	}

	/**
	 * 删除地址列表
	 * @param  $address string 列表别称地址, 使用该别称地址进行调用, 格式为xxx@maillist.sendcloud.org
	 * @author widuu <admin@widuu.com>
	 */

	public function delete_address($address){
		// 用户权限设置
		$params = self::set_auth();
		// 参数设置
		$params['address'] 	 = $address;
		// 构建发送URL
		$post_url = self::SOHU_URL."list.delete.json";
		// POST数据
		$result = self::http_post($post_url,http_build_query($params));
		// 解析数据
		$result = json_decode($result,true);
		// 返回错误信息
		if( $result['message'] != 'success' ){
			return self::return_info(false,$result['errors'][0]);
		}
		// 返回删除个数
		return self::return_info(true,$result['del_count']);
	}

	/**
	 * 地址列表成员查询
	 * @param $mail_list_addr string  地址列表调用名称
	 * @param $member_addr    string  需要查询信息的地址
	 * @param $start          int     查询起始位置, 取值区间 [0-], 默认为 0
	 * @param $limit          int     查询个数, 取值区间 [0-100], 默认为 100 
	 * @author widuu <admin@widuu.com>
	 */

	public function list_member($mail_list_addr,$member_addr='',$start=0,$limit=100){
		// 用户权限设置
		$params = self::set_auth();
		// 参数设置
		$options = array('mail_list_addr','start','limit');
		foreach ( $options as $key ) {
			$params[$key] = $$key; 
		}
		// 查询成员
		if( !empty($member_addr) ) $params['member_addr'] = $member_addr;
		// 构建发送URL
		$post_url = self::SOHU_URL."list_member.get.json";
		// POST数据
		$result = self::http_post($post_url,http_build_query($params));
		// 解析数据
		$result = json_decode($result,true);
		// 返回错误信息
		if( $result['message'] != 'success' ){
			return self::return_info(false,$result['errors'][0]);
		}
		unset($result['message']);
		// 返回查询信息
		return self::return_info(true,$result);
	}

	/**
	 * 地址列表成员添加
	 * @param  $mail_list_addr string  地址列表调用名称
	 * @param  $member_addr    string  需要查询信息的地址
	 * @param  $name           array   地址所属人名称, 与member_addr一一对应, 多个名称用;分隔
	 * @param  $vars           array   模板替换的变量, 与member_addr一一对应, 变量格式为{"money":"1000"}, 多个用;分隔
	 * @param  $upsert         bool    是否更新, 当为true时, 如果该member_addr存在, 则更新; 为false时, 如果成员地址存在, 将报重复地址错误, 默认为false
	 * @author widuu <admin@widuu.com>
	 */

	public function add_member($mail_list_addr,$member_addr,$name=array(),$vars=array(),$upsert=false){
		// 用户权限设置
		$params = self::set_auth();
		// 更新设置
		$params['upsert']   = $upsert ? 'true' : 'false';
		// 地址信息
		$params['mail_list_addr'] = $mail_list_addr;
		// 地址列表
		$params['member_addr'] 	= implode(';', $member_addr);
		// 名称
		if( !empty($name) ) $params['name'] = implode(';', $name);
		// 参数设置
		if( !empty($vars) ){
			foreach ($vars as $key => $value) {
				$vars[$key] = json_encode($value);
			}
			$params['vars'] = implode(';', $vars);
		}
		// 构建发送URL
		$post_url = self::SOHU_URL."list_member.add.json";
		// POST数据
		$result = self::http_post($post_url,http_build_query($params));
		// 解析数据
		$result = json_decode($result,true);
		// 返回错误信息
		if( $result['message'] != 'success' ){
			return self::return_info(false,$result['errors'][0]);
		}
		// 返回增加信息
		return self::return_info(true,$result['total_counts']);
	}

	/**
	 * 更新地址成员列表
	 * @param  $mail_list_addr string  地址列表调用名称
	 * @param  $member_addr    string  需要查询信息的地址
	 * @param  $name           array   地址所属人名称, 与member_addr一一对应, 多个名称用;分隔
	 * @param  $vars           array   模板替换的变量, 与member_addr一一对应, 变量格式为{"money":"1000"}, 多个用;分隔
	 * @author widuu <admin@widuu.com>
	 */

	public function update_member($mail_list_addr,$member_addr,$name=array(),$vars=array()){
		// 用户权限设置
		$params = self::set_auth();
		// 地址信息
		$params['mail_list_addr'] = $mail_list_addr;
		// 地址列表
		$params['member_addr'] 	= implode(';', $member_addr);
		// 名称
		if( !empty($name) ) $params['name'] = implode(';', $name);
		// 参数设置
		if( !empty($vars) ){
			foreach ($vars as $key => $value) {
				$vars[$key] = json_encode($value);
			}
			$params['vars'] = implode(';', $vars);
		}
		// 构建发送URL
		$post_url = self::SOHU_URL."list_member.update.json";
		// POST数据
		$result = self::http_post($post_url,http_build_query($params));
		// 解析数据
		$result = json_decode($result,true);
		// 返回错误信息
		if( $result['message'] != 'success' ){
			return self::return_info(false,$result['errors'][0]);
		}
		// 返回更新个数
		return self::return_info(true,$result['total_counts']);
	}

	/**
	 * 删除地址列表成员
	 * @param  $mail_list_addr string  地址列表调用名称
	 * @param  $member_addr    string  需要查询信息的地址
	 * @author widuu <admin@widuu.com>
	 */

	public function delete_member($mail_list_addr,$member_addr){
		// 用户权限设置
		$params = self::set_auth();
		// 地址信息
		$params['mail_list_addr'] = $mail_list_addr;
		// 成员列表
		$params['member_addr'] 	= implode(';', $member_addr);
		// 构建发送URL
		$post_url = self::SOHU_URL."list_member.delete.json";
		// POST数据
		$result = self::http_post($post_url,http_build_query($params));
		// 解析数据
		$result = json_decode($result,true);
		// 返回错误信息
		if( $result['message'] != 'success' ){
			return self::return_info(false,$result['errors'][0]);
		}
		// 返回删除个数
		return self::return_info(true,$result['del_count']);
	}

}
