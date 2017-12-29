<?php

/**
 * CMD 开始事件
 */
defined('EVENT_CMD_START') or define('EVENT_CMD_START','event_cmd_start');


/**
 * CMD 重启事件
 */
defined('EVENT_CMD_RESTART') or define('EVENT_CMD_RESTART','event_cmd_restart');



/**
 * CMD 停止事件
 */
defined('EVENT_CMD_STOP') or define('EVENT_CMD_STOP','event_cmd_stop');







/**
 * APP  开始事件
 */
defined('EVENT_APP_BEGIN') or define('EVENT_APP_BEGIN','event_app_begin');



/**
 * 应用程序初始化
 */
defined('EVENT_APP_INIT') or define('EVENT_APP_INIT','event_app_init');



/**
 * 应用程序运行时
 */
defined('EVENT_APP_RUN') or define('EVENT_APP_RUN','event_app_run');



/**
 * 饮用程序结束
 */
defined('EVENT_APP_END') or define('EVENT_APP_END','event_app_end');