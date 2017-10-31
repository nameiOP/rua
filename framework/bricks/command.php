<?php
namespace rua\bricks;



use Builder;
use rua\cli\app;
use rua\base\brick;
use rsk\server\server;
use rua\able\runnable;


class command extends brick implements runnable {










    /**
     *
     * @var
     */
    private $console;


    /**
     * 构造器
     * command constructor.
     * @param console $console
     */
    public function __construct(console $console){
        $this->console = $console;
    }





    /**
     * 批量绑定全局事件
     * @param \rsk\server\server $server
     * @param mixed $data
     * @author liu.bin 2017/10/25 16:00
     */
    private function bindEvents(server $server,$data=null){

        Builder::$app->on(app::EVENT_START,[$server,app::EVENT_START],$data);
        Builder::$app->on(app::EVENT_CLOSE,[$server,app::EVENT_CLOSE],$data);
        Builder::$app->on(app::EVENT_RESTART,[$server,app::EVENT_RESTART],$data);
        Builder::$app->on(app::EVENT_STATUS,[$server,app::EVENT_STATUS],$data);

    }



    /**
     * run
     * @author liu.bin 2017/10/24 17:54
     */
    public function run(){

        global $argv;
        $class = 'app\server\\'.trim($argv[1]);
        $server = Builder::createObject($class);
        $event = isset($argv[2]) ? $argv[2] : 'start';
        $this->bindEvents($server,null);
        $this->trigger($event);
    }

}