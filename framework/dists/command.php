<?php
namespace rua\dists;

use rua\base\dist;
use rua\able\runnable;

class command extends dist implements runnable{



	/**
	 * 命令类型
	 */
	public $type = 'server';


	/**
	 * 服务端 开始命令
	 *
	 */
	public function server_start(){
		$this->trigger(EVENT_CMD_SERVER_START);
	}



	/**
	 * 服务端 停止
	 *
	 */
	public function server_stop(){
		$this->trigger(EVENT_CMD_SERVER_STOP);
   	} 
	

	/**
	 * 服务端 重启
	 *
	 */
	public function server_restart(){
		$this->trigger(EVENT_CMD_SERVER_RESTART);
	}







	//=====================================================





	/**
	 *  客户端 开始命令
	 *
	 */
	public function client_start(){
		$this->trigger(EVENT_CMD_CLIENT_START);
	}



	/**
	 * 客户端 停止
	 *
	 */
	public function client_stop(){
		$this->trigger(EVENT_CMD_CLIENT_STOP);
	}


	/**
	 * 客户端 重启
	 *
	 */
	public function client_restart(){
		$this->trigger(EVENT_CMD_CLIENT_RESTART);
	}





    /**
     * 终端启动
     * @author liu.bin 2017/10/24 17:54
     */
    public function run(){

        global $argv;
		$event = isset($argv[1]) ? $argv[1] : 'start';
		$event = $this->type .'_'.$event;
		$this->$event();
    }






}
