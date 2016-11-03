<?php
	// error_reporting(0);
	// define("GOLF_SEND_MAX",10);
	// define("GOLF_SEND_TIME",60);
	//开启调试模式
    define("WEB_ROOT",dirname(__FILE__));//最后没斜线
    define("APP_PATH", WEB_ROOT."/App/");
    define("THINK_PATH",WEB_ROOT."/ThinkPHP/");
    define("RUNTIME_PATH",WEB_ROOT."/runtime/");
    define("WEB_HOST","http://".$_SERVER['HTTP_HOST']);
    define('APP_DEBUG', true);
    //加载框架入口文件
    require THINK_PATH."/ThinkPHP.php";