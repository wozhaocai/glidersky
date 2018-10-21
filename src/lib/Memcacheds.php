<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/21
 * Time: 21:18
 */

namespace GliderSky\lib;

class Memcacheds
{
    //声明静态成员变量
    private static $m = null;
    private static $cache = null;

    public function __construct() {
        self::$m = new \Memcached();
        self::$m->addServer('127.0.0.1','11211'); //写入缓存地址,port
    }

    //为当前类创建对象
    private static function Men(){
        self::$cache = new Memcacheds();
        return self::$m;
    }

    /*
     * 加入缓存数据
     * @param string $key 获取数据唯一key
     * @param String||Array $value 缓存数据
     * @param $time memcache生存周期(秒)
     */
    public static function set($key,$value,$time=3600){
        self::Men()->set($key,$value,$time);
    }

    /*
     * 获取缓存数据
     * @param string $key
     * @return
     */
    public static function get($key){
        return self::Men()->get($key);
    }
    /*
     * 删除相应缓存数据
     * @param string $key
     * @return
     */
    public static function delMen($key){
        self::Men()->delete($key);
    }
    /*
     * 删除全部缓存数据
     */
    public static function delAllMen(){
        self::Men()->flush();
    }

    /*
     * 删除全部缓存数据
     */
    public static function menStatus(){
        return self::Men()->getStats();
    }
}