<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/3
 * Time: 0:08
 */

namespace GliderSky\lib;


class ArrayUtil
{
    public static function oneArrayToString($aData){
        $aLine = array();
        foreach($aData as $sKey => $sVal){
            $aLine = $sKey.":".$sVal;
        }
        return implode(";",$aLine);
    }
}