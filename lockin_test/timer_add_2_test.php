<?php
/**
 * Created by PhpStorm.
 * User: Lockin
 * Date: 2018/2/7
 * Time: 22:54
 */

use \Workerman\Worker;
use \Workerman\Lib\Timer;
require_once dirname(__DIR__ ). '/Workerman/Autoloader.php';

class Mail
{
    // 注意这个是静态方法，回调函数属性也必须是public
    public static function send($to, $content)
    {
        echo "send mail ...\n";
    }
}

$task = new Worker();
$task->onWorkerStart = function($task)
{
    // 10秒后发送一次邮件
    $to = 'workerman@workerman.net';
    $content = 'hello workerman';
    // 定时调用类的静态方法
    Timer::add(10, array('Mail', 'send'), array($to, $content), false);
};

// 运行worker
Worker::runAll();