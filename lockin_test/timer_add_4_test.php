<?php
/**
 * Created by PhpStorm.
 * User: Lockin
 * Date: 2018/2/9
 * Time: 12:11
 */

use \Workerman\Worker;
use \Workerman\Lib\Timer;
require_once dirname(__DIR__ ). '/Workerman/Autoloader.php';

$task = new Worker();
$task->onWorkerStart = function($task)
{
    // 计数
    $count = 1;
    // 要想$timer_id能正确传递到回调函数内部，$timer_id前面必须加地址符 &
    $timer_id = Timer::add(1, function()use(&$timer_id, &$count)
    {
        echo $timer_id;
        echo "Timer run $count\n";
        // 运行10次后销毁当前定时器
        if($count++ >= 10)
        {
            echo "Timer::del($timer_id)\n";
            Timer::del($timer_id);
        }
    });
};

// 运行worker
Worker::runAll();