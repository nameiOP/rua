<?php


namespace rua\cli;
use rua\base\application;

defined('STDIN') or define('STDIN', fopen('php://stdin', 'r'));
defined('STDOUT') or define('STDOUT', fopen('php://stdout', 'w'));
defined('STDERR') or define('STDERR', fopen('php://stderr', 'w'));



class app extends application{


    /**
     * 服务器开启
     */
    const EVENT_START = 'start';


    /**
     * 服务器关闭
     */
    const EVENT_CLOSE = 'stop';


    /**
     * 服务器重启
     */
    const EVENT_RESTART = 'restart';


    /**
     * 服务器状态
     */
    const EVENT_STATUS = 'status';



}

