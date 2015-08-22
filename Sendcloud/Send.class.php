<?php

/**
 * SendCloud  send mail  class
 * @author    widuu <admin@widuu.com>
 * @version   0.1
 * @copyright Copyright (c) 2015 http://www.widuu.com
 * @date      2015/08/20
 */

namespace Sendcloud;

class Send extends Sendcloud{

	/**
	 * 发送模板邮件
	 * @param  string $from  				发件人地址. from 和发信域名, 会影响是否显示代发
	 * @param  array  $sub					模板替换变量. 在 use_maillist=false 时使用
	 * @param  array  $to 				    收件人的地址列表. 在 use_maillist=true 时使用
	 * @param  string $subject 				邮件标题
	 * @param  string $template_invoke_name 邮件模板调用名称
	 * @param  string $fromname				发件人名称
	 * @param  string $replyto 				默认的回复邮件地址
	 * @param  string $label  			    本次发送所使用的标签ID
	 * @param  string $headers  			邮件头部信息 JSON格式
	 * @param  string $files 				邮件附件. 发送附件时, 必须使用 multipart/form-data 进行 post 提交 (表单提交)
	 * @param  string $resp_email_id  		(true, false)否	是否返回 emailId. 有多个收件人时, 会返回 emailId 的列表
	 * @param  string $use_maillist 	    string (true, false)	否	参数 to 是否支持地址列表, 默认为 false. 比如: to=users@maillist.sendcloud.org  
	 * @param  string $gzip_compress        string (true, false)	否	邮件内容是否使用gzip压缩. 默认不使用 gzip 压缩正文
	 * @author widuu <admin@widuu.com>
	 */

	public function send_template($from,$sub,$to=array(),$subject='',$template_invoke_name,$fromname='',$replyto='',$label='',$headers=array(),$files='',$resp_email_id=true,$use_maillist=false,$gzip_compress=false){
		
		// 用户权限设置
		$params = self::set_auth();
		// 发送邮件
		$params['from'] 	= $from;

		// 发送地址和变量判断
		if( $use_maillist == false ){
			$sub_json['to']  = $to;
			if( !empty($sub) )  $sub_json['to'] = $sub;
			$params['substitution_vars'] = json_encode($sub_json);
			$params['use_maillist'] = 'false';
		}else{ 
			$params['to'] = $to[0];
			$params['use_maillist']  = 'true';
		}

		// 附件
		if( !empty($files) )  $params['files'] = '@'.$files;
		// 发件模板
		$params['template_invoke_name'] = $template_invoke_name;
	    // 循环添加变量
	    $option_params = array('subject','fromname','replyto','label');
		foreach ($option_params as $key ) {
			if( !empty($$key)) $params[$key] = $$key;			
		}
		// 返回email_id
		$params['resp_email_id'] = $resp_email_id ? 'true' : 'false';
		// 是否开启gzip
		$params['gzip_compress'] = $gzip_compress ? 'true' : 'false';
		// 构建发送URL
		$post_url = self::SOHU_URL."mail.send_template.json";
		// POST数据
		$send_result = self::http_post($post_url,$params);
		// 解析数据
		$send_result = json_decode($send_result,true);
		// 返回错误信息
		if( $send_result['message'] != 'success' ){
			return self::return_info(false,$send_result['errors'][0]);
		}
		// 使用邮件地址列表返回信息
		if( $use_maillist ){
			self::return_info(true,$send_result['mail_list_task_id_list']);
		}
		// 返回邮件地址列表
		return self::return_info(true,$send_result['email_id_list']);
	}

	/**
	 * 发送普通邮件
	 * @param  string $from  				发件人地址. from 和发信域名, 会影响是否显示代发
	 * @param  array  $to 				    收件人的地址列表. 在 use_maillist=true 时使用
	 * @param  string $subject 				邮件标题
	 * @param  string $html 				邮件的内容. 不能为空, 可以是文本格式或者 HTML 格式
	 * @param  string $fromname				发件人名称 显示如: ifaxin客服支持 <support@ifaxin.com>
	 * @param  string $bcc 					密送地址. 多个地址使用';'分隔
	 * @param  string $cc  			    	抄送地址. 多个地址使用';'分隔
	 * @param  string $replyto 				默认的回复邮件地址
	 * @param  string $label  			    本次发送所使用的标签ID
	 * @param  string $headers  			邮件头部信息 JSON格式
	 * @param  string $files 				邮件附件. 发送附件时, 必须使用 multipart/form-data 进行 post 提交 (表单提交)
	 * @param  array  $x_smtpapi            SMTP 扩展字段. 详见 http://sendcloud.sohu.com/doc/email/#x-smtpapi.
	 * @param  string $resp_email_id  		(true, false)否	是否返回 emailId. 有多个收件人时, 会返回 emailId 的列表
	 * @param  string $use_maillist 	    string (true, false)	否	参数 to 是否支持地址列表, 默认为 false. 比如: to=users@maillist.sendcloud.org  
	 * @param  string $gzip_compress        string (true, false)	否	邮件内容是否使用gzip压缩. 默认不使用 gzip 压缩正文
	 * @author widuu <admin@widuu.com>
	 */

	public function send($from,$to=array(),$subject,$html,$fromname='',$bcc='',$cc='',$replyto='',$label='',$headers=array(),$files='',$x_smtpapi=array(),$resp_email_id=true,$use_maillist=false,$gzip_compress=false){
		// 用户权限设置
		$params = self::set_auth();
		// 发送人
		$params['from'] 	= $from;
		// 邮件标题
		$params['subject'] 	= $subject;
		// SMTAPI 参数 array('to'=>array(),'sub'=>array('code'=>array()));
		if ( !empty($x_smtpapi) ) {
			$params['x_smtpapi'] = json_encode($x_smtpapi);
		}else{
			$params['to'] = implode(';', $to);
		}
		// 发送内容模版不能为空
		$params['html'] = $html;
		// 附件
		if( !empty($files) )  $params['files'] = '@'.$files;
		// 可选参数
		$option_params = array('fromname','bcc','cc','replyto','label');
		foreach ($option_params as $key ) {
			if( !empty($$key)) $params[$key] = $$key;			
		}
		// 地址列表
		$params['use_maillist']  = $use_maillist ? 'true' : 'false';
		// 返回email_id
		$params['resp_email_id'] = $resp_email_id ? 'true' : 'false';
		// 是否开启gzip
		$params['gzip_compress'] = $gzip_compress ? 'true' : 'false';
		// 构建发送URL
		$post_url = self::SOHU_URL."mail.send.json";
		// POST数据
		$send_result = self::http_post($post_url,$params);
		// 解析数据
		$send_result = json_decode($send_result,true);
		// 返回错误信息
		if( $send_result['message'] != 'success' ){
			return self::return_info(false,$send_result['errors'][0]);
		}
		// 使用邮件地址列表返回信息
		if( $use_maillist ){
			self::return_info(true,$send_result['mail_list_task_id_list']);
		}
		// 返回邮件地址列表
		return self::return_info(true,$send_result['email_id_list']);
	}

}
