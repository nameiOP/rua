<?php


namespace rua\cli;


use rua\base\application;

defined('STDIN') or define('STDIN', fopen('php://stdin', 'r'));
defined('STDOUT') or define('STDOUT', fopen('php://stdout', 'w'));
defined('STDERR') or define('STDERR', fopen('php://stderr', 'w'));


class app extends application{


    /**
     * @var array
     */
    public $server;


    /**
     * @var array
     */
    public $client;


    /**
     * @var string
     */
    public $exec;



    /**
     * 处理终端命令
     * @author liu.bin 2017/10/24 17:12
     */
    public function handleCommand(){
        return $this->getCommand()->run();
    }


}

