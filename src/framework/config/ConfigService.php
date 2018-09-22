<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/19
 * Time: 17:18
 */

namespace GliderSky\framework\config;

class ConfigService
{
    private static $_aConfigFile = array("database","spider","store","application");
    public static $Config = array();

    public function __construct($sConfigPath)
    {
        $this->_sConfigPath = $sConfigPath;
        define("DIRECTORY_SEPARATOR",'/');
    }

    public static function fetchFile($file){
        return require_once($file);
    }

    public static function loadConfig($sConfigPath){
        foreach(self::$_aConfigFile as $sFile){
            if(file_exists($sConfigPath."/".$sFile.".php")){
                self::$Config["{$sFile}"] = self::fetchFile($sConfigPath."/".$sFile.".php");
            }
        }
        class_alias('GliderSky\framework\config\ConfigService', 'Config');
        class_alias('GliderSky\framework\data\DataService', 'Data');
        class_alias('GliderSky\framework\spider\SpiderService', 'Spider');
        class_alias('GliderSky\framework\app\AppService', 'app');
    }

    public static function loader($name){
        $class_path = str_replace('\\',DIRECTORY_SEPARATOR,$name);   //把表示命名空间的分割符号，转换成表示目录结构的斜线
        if(!defined("APPLICATION_PATH")){
            echo "请设置APPLICATION_PATH设置为常量且为根目录";
            exit;
        }
        $file = realpath(APPLICATION_PATH).'/'.$class_path.'.php';
        if(file_exists($file))
        {
            require_once($file);    //引入文件
            if(class_exists($name,false))    //带有命名空间的类名
            {
                return true;
            }
            return false;
        }
        return false;
    }
}