<?php 

//自己的API_User和API_KEY

define('API_USER','ttchina_ses');

define('API_KEY','7Ag7e2JzMp36E9pq');

require 'vendor/autoload.php';

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
