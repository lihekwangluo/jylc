<?php
return array(
		//数据库配置信息
        'DB_TYPE'   => 'mysql', // 数据库类型
        'DB_HOST'   => 'localhost', // 服务器地址
        'DB_NAME'   => 'jianzhu', // 数据库名
        'DB_USER'   => 'root', // 用户名
        'DB_PWD'    => 'root', // 密码
        'DB_PORT'   => 3306, // 端口
        'DB_PREFIX' => 'zj_', // 数据库表前缀
        'URL_MODEL' =>0,		//URL模式
        'URL_CASE_INSENSITIVE' =>false, //不区分大小写
        //'DEFAULT_FILTER'       =>  'strip_tags,stripslashes,htmlspecialchars',

        //'配置项'=>'配置值'
        'APP_GROUP_LIST'        => 'Home,Member,Api',
        'DEFAULT_GROUP'         =>'Home',//默认分组
        'TMPL_TEMPLATE_SUFFIX'  => '.php', //模板后缀
        'WEB_HOST'              => $_SERVER['HTTP_HOST'],

        //url设置
        'URL_CASE_INSENSITIVE'  =>true,//关闭大小写为true.忽略地址大小写
        'URL_MODEL'             => 2,  //rewrite模式
        'URL_HTML_SUFFIX'       =>"html",//静态文件后缀
        'URL_404_REDIRECT'      => '', //404跳转页面
);
?>