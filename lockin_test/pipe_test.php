<?php
/**
 * Created by PhpStorm.
 * User: Lockin
 * Date: 2018/2/7
 * Time: 12:28
 */

use Workerman\Worker;
use Workerman\Connection\AsyncTcpConnection;
require_once dirname(__DIR__ ). '/Workerman/Autoloader.php';

$worker = new Worker('tcp://192.168.17.129:8483');
$worker->count = 4;

// tcp连接建立后
$worker->onConnect = function($connection)
{
    // 建立本地80端口的异步连接
    $connection_to_80 = new AsyncTcpConnection('tcp://192.168.1.112:8099');
    // 设置将当前客户端连接的数据导向80端口的连接
    $connection->pipe($connection_to_80);
    // 设置80端口连接返回的数据导向客户端连接
    $connection_to_80->pipe($connection);
    // 执行异步连接
    $connection_to_80->connect();
};

// 运行worker
Worker::runAll();