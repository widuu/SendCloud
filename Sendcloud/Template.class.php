<?php

/**
 * SendCloud  Template  class
 * @author    widuu <admin@widuu.com>
 * @version   0.1
 * @copyright Copyright (c) 2015 http://www.widuu.com
 * @date      2015/08/20
 */

namespace Sendcloud;

class Template extends Sendcloud{


	/**
	 * 获取模板信息
	 * @param string $invoke_name 邮件模板名称
	 * @param int    $start 	  起始位置
	 * @param int    $limit       查询个数
	 * @return boolean|array 	  成功模板列表，否则返回false
	 */

	public  function get_template($invoke_name='',$start=0,$limit=100){
		// 用户权限设置
		$params = self::set_auth(); 
		if( !empty($invoke_name) ) $params['invoke_name'] = $invoke_name;
		$params['start'] 		= $start;
		$params['limit']		= $limit;
		$post_url = self::SOHU_URL."template.get.json";
		$template_data = self::http_post($post_url,http_build_query($params));
		$template_data = json_decode($template_data,true);
		// 返回错误信息
		if( $template_data['message'] != 'success' ){
			return self::return_info(false,$template_data['errors'][0]);
		}
		// 返回列表
		return self::return_info(true,$template_data['templateList']);
	}

	/**
	 * 添加模板
	 * @param  string $invoke_name 邮件模板调用名称
	 * @param  string $name 	   邮件模板名称
	 * @param  string $html  	   html格式内容
	 * @param  string $text  	   text格式内容
	 * @param  string $subject     模板标题
	 * @param  int    $email_type  模板类型'0'是触发邮件,'1'是批量邮件
	 * @return boolean|int 		   成功返回添加条数，否则返回false
	 * @author widuu <admin@widuu.com>
	 */

	public function add_template($invoke_name,$name,$html,$text='',$subject,$email_type=1){
		$param_key = array('invoke_name','name','html','text','subject','email_type');
		// 用户权限设置
		$params = self::set_auth();
		foreach ($param_key as  $key) {
			$params[$key] = $$key; 
		}
		$post_url = self::SOHU_URL."template.add.json";
		$result_add = self::http_post($post_url,http_build_query($params));
		$result_add = json_decode($result_add,true);
		// 返回错误信息
		if( $result_add['message'] != 'success' ){
			return self::return_info(false,$result_add['errors'][0]);
		}
		// 返回添加条数
		return self::return_info(true,$result_add['addCount']);
	}

	/**
	 * 更改模板
	 * @param  string $invoke_name  邮件模板调用名称
	 * @param  string $name         需要修改的邮件模板名称
	 * @param  string $html 		需要修改的html格式内容
	 * @param  string $subject      需要修改的邮件标题
	 * @param  string $email_type   需要修改的邮件类型
	 * @return boolean|int 		    成功返回更新条数，否则返回false
	 * @author widuu <admin@widuu.com>
	 */

	public function update_template($invoke_name,$name='',$html='',$subject='',$email_type=''){
		$param_key = array('invoke_name','name','html','subject','email_type');
		// 用户权限设置
		$params = self::set_auth();
		foreach ($param_key as  $key) {
			$params[$key] = $$key; 
		}
		$post_url = self::SOHU_URL."template.update.json";
		$result_update = self::http_post($post_url,http_build_query($params));
		$result_update = json_decode($result_update,true);
		// 返回错误信息
		if( $result_update['message'] != 'success' ){
			return self::return_info(false,$result_update['errors'][0]);
		}
		// 返回更新条数
		return self::return_info(true,$result_update['updateCount']);
	}

	/**
	 * 删除模板
	 * @param  string $invoke_name 邮件模板调用名称
	 * @return boolean|int 		   成功返回删除条数，否则返回false
	 * @author widuu <admin@widuu.com>
	 */

	public function delete_template($invoke_name){
		// 用户权限设置
		$params = self::set_auth();
		$params['invoke_name'] = $invoke_name;
		$post_url = self::SOHU_URL."template.delete.json"; 
		$result = self::http_post($post_url,http_build_query($params));
		$result = json_decode($result,true);
		// 返回错误信息
		if( $result['message'] != 'success' ){
			return self::return_info(false,$result['errors'][0]);
		}
		// 返回删除条数
		return self::return_info(true,$result['delCount']);
	}

}


