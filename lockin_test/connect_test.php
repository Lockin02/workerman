<?php
/**
 * Created by PhpStorm.
 * User: Lockin
 * Date: 2018/1/28
 * Time: 15:25
 */

use Workerman\Worker;
use Workerman\Lib\Timer;
require_once dirname(__DIR__ ). '/Workerman/Autoloader.php';

$worker = new Worker('websocket://192.168.17.129:8484');
// 进程启动时设置一个定时器，定时向所有客户端连接发送数据
$worker->onWorkerStart = function($worker)
{
    // 定时，每10秒一次
    Timer::add(10, function()use($worker)
    {
        // 遍历当前进程所有的客户端连接，发送当前服务器的时间
        foreach($worker->connections as $connection)
        {
            $connection->send(time());
        }
    });
};
// 运行worker
Worker::runAll();