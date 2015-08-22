SendCloud PHP SDK
===

![sendcloud](http://sendcloud.sohu.com/img/home/logo-.png)

##使用方法

### 获取用户信息( 在examples 文件夹中)

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

> 如果你使用的ThinkPHP,你可以直接将，Sendcloud文件夹放到Thinkphp\Library下使用。

##TODO

1. 因为开发时间特别紧就3个小时，所以BUG会不少，需要修复BUG。
2. 完善examples中的使用方法，都针对各个类库使用。
3. 优化代码，还是开发速度时间太紧造成大量的代码堆积状况出现，所以需要优化。
4. 完善整个SDK

## Contributing

1. 登录 <https://coding.net> 或 <https://github.com>
2. 创建您的特性分支 (`git checkout -b my-new-feature`)
3. 提交您的改动 (`git commit -am 'Added some feature'`)
4. 将您的改动记录提交到远程 git 仓库 (`git push origin my-new-feature`)
5. 然后到 coding 网站的该 git 远程仓库的 `my-new-feature` 分支下发起 Pull Request

##其他信息

blog地址：[http://www.widuu.com](http://www.widuu.com)

新浪微博：[http://weibo.com/widuu](http://weibo.com/widuu)



