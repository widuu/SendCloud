<?php

/**
 * SendCloud  Auth  class
 * @author    widuu <admin@widuu.com>
 * @version   0.1
 * @copyright Copyright (c) 2015 http://www.widuu.com
 * @date      2015/08/20
 */

define('API_USER','your user');

define('API_KEY','your key');

class Config{

    //自动加载方法
    static final public function autoload($path,$namespace=''){
        //查找是否有命名空间
        spl_autoload_register(function($class) use ($path,$namespace){
            if(!empty($namespace)){
                //如果加载命名空间直接去除命名空间
                if (0 == strpos(ltrim($class, '\\'), $namespace . '\\')) {
                        $class = substr(ltrim($class, '\\'), strlen($namespace) + 1);
                }
            }

            $file = $path. str_replace(array('_', '\\'), '/', $class) .'.class.php';
            if(file_exists($file)){
                include_once $file;
            }
        });
    }
}
