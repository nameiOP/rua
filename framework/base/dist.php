<?php

namespace rua\base;

use Builder;
use Closure;
use rua\traits\eventable;
use rua\traits\macroable;
use rua\exception\InvalidConfigException;


/**
 * 模块 组合 分发类
 *
 *
 * Class house
 * @package rua\base
 */
class dist extends instance
{



    use macroable,eventable;

    /**
     * @var array 模块，可以通过id访问
     */
    private $_dists = [];



    /**
     * @var array 模块定义，可以通过id访问
     */
    private $_definitions = [];




    /**
     * Getter 魔术方法，获取一个不存在的属性的时候调用
     * 当属性不存在的时候，可以通过 $name 获取同名的 dist
     * @param string $name dist or property name
     * @return mixed the named property value
     */
    public function __get($name)
    {
        if ($this->has($name)) {
            return $this->get($name);
        } else {
            return parent::__get($name);
        }
    }




    /**
     * 检查属性是否存在，当调用isset()方法判断对象属性是否存在时调用
     * @param string $name the property name or the event name
     * @return bool whether the property value is null
     */
    public function __isset($name)
    {
        if ($this->has($name)) {
            return true;
        } else {
            return parent::__isset($name);
        }
    }



    /**
     * 检查砖头是否已经定义，$checkInstance如果是真，则验证砖头是否已被实例化
     * @param string $id dist ID (e.g. `db`).
     * @param bool $checkInstance whether the method should check if the dist is shared and instantiated.
     * @return bool whether the locator has the specified dist definition or has instantiated the dist.
     * @see set()
     */
    public function has($id, $checkInstance = false)
    {
        return $checkInstance ? isset($this->_dists[$id]) : isset($this->_definitions[$id]);
    }



    /**
     * 通过 id 获取 dist
     * @param string $id dist ID (e.g. `db`).
     * @param bool $throwException whether to throw an exception if `$id` is not registered with the locator before.
     * @return object|null the dist of the specified ID. If `$throwException` is false and `$id`
     * is not registered before, null will be returned.
     * @throws InvalidConfigException if `$id` refers to a nonexistent dist ID
     * @see has()
     * @see set()
     */
    public function get($id, $throwException = true)
    {
        if (isset($this->_dists[$id])) {
            return $this->_dists[$id];
        }

        if (isset($this->_definitions[$id])) {
            $definition = $this->_definitions[$id];
            if (is_object($definition) && !$definition instanceof Closure) {
                return $this->_dists[$id] = $definition;
            } else {
                return $this->_dists[$id] = Builder::createObject($definition);
            }
        } elseif ($throwException) {
            throw new InvalidConfigException("Unknown dist ID: $id");
        } else {
            return null;
        }
    }





    /**
     * 定义一个砖头
     *
     * For example,
     *
     * ```php
     * // a class name
     * $app->set('cache', 'rua\caching\FileCache');
     *
     * // a configuration array
     * $locator->set('db', [
     *     'class' => 'rua\db\Connection',
     *     'dsn' => 'mysql:host=127.0.0.1;dbname=demo',
     *     'username' => 'root',
     *     'password' => '',
     *     'charset' => 'utf8',
     * ]);
     *
     * // an anonymous function
     * $app->set('cache', function ($params) {
     *     return new \rua\caching\FileCache;
     * });
     *
     * // an instance
     * $app->set('cache', new \rua\caching\FileCache);
     * ```
     *
     * If a dist definition with the same ID already exists, it will be overwritten.
     *
     * @param string $id dist ID (e.g. `db`).
     * @param mixed $definition the dist definition to be registered with this locator.
     * It can be one of the following:
     *
     * - a class name
     * - a configuration array: the array contains name-value pairs that will be used to
     *   initialize the property values of the newly created object when [[get()]] is called.
     *   The `class` element is required and stands for the the class of the object to be created.
     * - a PHP callable: either an anonymous function or an array representing a class method (e.g. `['Foo', 'bar']`).
     *   The callable will be called by [[get()]] to return an object associated with the specified dist ID.
     * - an object: When [[get()]] is called, this object will be returned.
     *
     * @throws InvalidConfigException if the definition is an invalid configuration array
     */
    public function set($id, $definition)
    {
        unset($this->_dists[$id]);

        if ($definition === null) {
            unset($this->_definitions[$id]);
            return;
        }

        if (is_object($definition) || is_callable($definition, true)) {
            // an object, a class name, or a PHP callable
            $this->_definitions[$id] = $definition;
        } elseif (is_array($definition)) {
            // a configuration array
            if (isset($definition['class'])) {
                $this->_definitions[$id] = $definition;
            } else {
                throw new InvalidConfigException("The configuration for the \"$id\" dist must contain a \"class\" element.");
            }
        } else {
            throw new InvalidConfigException("Unexpected configuration type for the \"$id\" dist: " . gettype($definition));
        }
    }

    /**
     * Removes the dist from the locator.
     * @param string $id the dist ID
     */
    public function clear($id)
    {
        unset($this->_definitions[$id], $this->_dists[$id]);
    }

    /**
     * Returns the list of the dist definitions or the loaded dist instances.
     * @param bool $returnDefinitions whether to return dist definitions instead of the loaded dist instances.
     * @return array the list of the dist definitions or the loaded dist instances (ID => definition or instance).
     */
    public function getDists($returnDefinitions = true)
    {
        return $returnDefinitions ? $this->_definitions : $this->_dists;
    }

    /**
     * Registers a set of dist definitions in this locator.
     *
     * This is the bulk version of [[set()]]. The parameter should be an array
     * whose keys are dist IDs and values the corresponding dist definitions.
     *
     * For more details on how to specify dist IDs and definitions, please refer to [[set()]].
     *
     * If a dist definition with the same ID already exists, it will be overwritten.
     *
     * The following is an example for registering two dist definitions:
     *
     * ```php
     * [
     *     'db' => [
     *         'class' => 'rua\db\Connection',
     *         'dsn' => 'sqlite:path/to/file.db',
     *     ],
     *     'cache' => [
     *         'class' => 'rua\caching\DbCache',
     *         'db' => 'db',
     *     ],
     * ]
     * ```
     *
     * @param array $dists dist definitions or instances
     */
    public function setDists($dists)
    {
        foreach ($dists as $id => $dist) {
            $this->set($id, $dist);
        }
    }
}
