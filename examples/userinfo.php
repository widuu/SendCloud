<?php 

// 自动加载命名空间和配置方法，在Config.php中设置
//自己的API_User和API_KEY

include "../Config.php";

Config::autoload('../');

// 获取用户信息
$userinfo = Sendcloud\User::get_userinfo();
print_r($userinfo);

// 获取API User 
// 参数为空默认为1  0(触发), 1(批量)
$api_user = Sendcloud\User::get_apiuser();
print_r($api_user);

// 域名查询
// 0 测试域名 1 正常域名

$domain = Sendcloud\User::get_domain();
print_r($domain);
