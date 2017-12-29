<?php
namespace rua\bricks;

use rua\base\brick;
use rua\able\runnable;

class command extends brick implements runnable{


	/**
	 * 开始命令
	 *
	 */
	public function start(){
		$this->trigger(EVENT_CMD_START);
	}



	/**
	 * 停止
	 *
	 */
	public function stop(){
		$this->trigger(EVENT_CMD_STOP);
   	} 
	

	/**
	 * 重启
	 *
	 */
	public function restart(){
		$this->trigger(EVENT_CMD_RESTART);
	}




    /**
     * run
     * @author liu.bin 2017/10/24 17:54
     */
    public function run(){

        global $argv;
		$event = isset($argv[1]) ? $argv[1] : 'start';
		$this->$event();
    }

}
