<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// [ 应用入口文件 ]

// 定义应用目录
define('APP_PATH', __DIR__ . '/../application/');

//require  __DIR__ . '/../vendor/predis/predis/autoload.php';
// 加载框架引导文件
require __DIR__ . '/../thinkphp/start.php';
//
/*$servers = config('cache.cluster_list');
		$a= new Predis\Client($servers, array('cluster' => 'redis'));
		
		$a->set("name1", "11");
$a->set("name2", "22");
$a->set("name3", "33");
  
$name1 = $a->get('name1');
$name2 = $a->get('name2');
$name3 = $a->get('name3');
var_dump($name1, $name2, $name3);*/