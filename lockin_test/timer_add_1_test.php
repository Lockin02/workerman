<?php
/**
 * Created by PhpStorm.
 * User: Lockin
 * Date: 2018/2/7
 * Time: 20:24
 */

use \Workerman\Worker;
use \Workerman\Lib\Timer;
require_once dirname(__DIR__ ). '/Workerman/Autoloader.php';

$ws_worker = new Worker('websocket://192.168.17.129:8085');
$ws_worker->count = 8;
// 连接建立时给对应连接设置定时器
$ws_worker->onConnect = function($connection)
{
    // 每10秒执行一次
    $time_interval = 10;
    $connect_time = time();
    // 给connection对象临时添加一个timer_id属性保存定时器id
    $connection->timer_id = Timer::add($time_interval, function($connection, $connect_time)
    {
        $connection->send($connect_time);
    }, array($connection, $connect_time));
};
// 连接关闭时，删除对应连接的定时器
$ws_worker->onClose = function($connection)
{
    // 删除定时器
    Timer::del($connection->timer_id);
};

// 运行worker
Worker::runAll();