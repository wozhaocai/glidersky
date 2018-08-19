<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/15
 * Time: 14:33
 */
require_once dirname(__DIR__ ). '/vendor/autoload.php';

use GliderSky\GliderSky;

define("APPLICATION_PATH",dirname(dirname(__FILE__)));

$glidersky = new GliderSky(APPLICATION_PATH."/test/config");
$glidersky->start();

spl_autoload_register(array('Config',"loader"));

function debugVar($var){
    echo "<pre>";
    var_dump($var);
    echo "</pre>";
}


