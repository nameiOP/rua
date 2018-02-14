<?php

namespace rua\base;

use Builder;


/**
 * Instance 类
 * 通过类的 Instance方法,可以直接返回该类的实例对象
 * Class instance
 * @package rua\base
 */
abstract class instance extends object
{





    /**
     * 已加载的类
     * @var array
     */
    public $loadedClass = [];


    /**
     * 如果某类在实例化后,通过className::setInstance($obj)注入[保存在$app的loadedClass中];
     * 则可以通过 className::getInstance(),在任何地方获取到$obj.
     *
     *
     *
     * 使用方法：
     * $obj = new objName();
     * objName::setInstance($obj);
     *
     *
     * .. anywhere
     * $obj = objName::getInstance();
     *
     *
     * @see setInstance()
     * @return object|null the currently requested instance of this module class, or `null` if the module class is not requested.
     */
    public static function getInstance()
    {
        $class = get_called_class();
        return isset(Builder::$app->loadedClass[$class]) ? Builder::$app->loadedClass[$class] : null;
    }





    /**
     * 设置实例到一个静态方法中
     *
     * get_class():         获取当前调用方法的类名；在父类中定义，返回父类（如果实例化的是子类，仍然返回父类）
     * get_called_class():  获取静态绑定后的类名；在父类中定义，返回实例化的类（如果实例化的是子类，返回子类）
     *
     * @see getInstance()
     * @param object|null $instance 对象
     */
    public static function setInstance($instance)
    {
        if ($instance === null) {
            unset(Builder::$app->loadedClass[get_called_class()]);
        } else {
            Builder::$app->loadedClass[get_class($instance)] = $instance;
        }
    }


}
