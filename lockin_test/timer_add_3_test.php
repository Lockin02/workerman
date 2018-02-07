<?php
/**
 * Created by PhpStorm.
 * User: Lockin
 * Date: 2018/2/7
 * Time: 23:08
 */

use \Workerman\Worker;
use \Workerman\Lib\Timer;
require_once dirname(__DIR__ ). '/Workerman/Autoloader.php';

class Mail
{
    // 注意，回调函数属性必须是public
    public function send($to, $content)
    {
        echo "send mail ...\n";
    }

    public function sendLater($to, $content)
    {
        // 回调的方法属于当前的类，则回调数组第一个元素为$this
        Timer::add(10, array($this, 'send'), array($to, $content), false);
    }
}

$task = new Worker();
$task->onWorkerStart = function($task)
{
    // 10秒后发送一次邮件
    $mail = new Mail();
    $to = 'workerman@workerman.net';
    $content = 'hello workerman';
    $mail->sendLater($to, $content);
};

// 运行worker
Worker::runAll();