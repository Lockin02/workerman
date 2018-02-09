<?php
/**
 * Created by PhpStorm.
 * User: Lockin
 * Date: 2018/2/9
 * Time: 12:28
 */

use \Workerman\Worker;
use \Workerman\Lib\Timer;
require_once dirname(__DIR__ ).'/Workerman/Autoloader.php';

$task = new Worker();
$task->count = 1;
$task->onWorkerStart = function ($task)
{
    // 每两秒运行一次
    $timer_id = Timer::add(2, function (){
        echo "task run\n";
    });
    // 20秒后运行一个一次性任务,删除2秒一次的定时任务
    Timer::add(20, function ($timer_id){
        Timer::del($timer_id);

    }, array($timer_id), false);
};

// 运行worker
Worker::runAll();