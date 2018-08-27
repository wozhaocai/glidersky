<?php
namespace GliderSky\lib;

class DateType {
    
    private static $_aSpicial = array(
        "{date|microtime|concat}"        
    );

    public static function replace($string, $data) {
        preg_match_all('/\{(\w)+\}/', $string, $matches);
        if(empty($matches)) return $string;
        foreach ($matches[0] as $val) {
            $replace_string = '';
            $key = substr($val, 1, -1);
            if (is_object($data) and !empty($data->$key)) {
                $replace_string = $data->$key;
            } elseif (is_array($data) and isset($data[$key]) and $data[$key]) {
                $replace_string = $data[$key];
            }
            if ($replace_string){
                $string = str_replace($val, $replace_string, $string);
            }
        }
        return $string;
    }
    
    public static function special_replace($string) {
        foreach(self::$_aSpicial as $sSpecialStr){
            if(strstr($sSpecialStr,$sSpecialStr)){
                if($sSpecialStr == "{date|microtime|concat}"){
                    $string = str_replace($sSpecialStr, str_replace(' ','',microtime()), $string);
                }
            }
        }        
        return $string;
    }
    
    public static function replaceDate($string) {
        preg_match_all('/\{[\w|:]+}/', $string, $matches);
        if(empty($matches)) return $string;
        foreach ($matches[0] as $val) {
            $replace_string = '';
            $key = substr($val, 1, -1);
            if(strstr($key,"|")){
                list($sType,$sFormat) = explode("|",$key);
            }else{
                $sType = $key;
                $sFormat = "";
            }
            if($sType == "date"){
                if(!empty($sFormat)){
                    $replace_string = date($sFormat);
                }else{
                    $aTime = explode(" ",  microtime());
                    $replace_string = $aTime[1];
                }
            }            
            if ($replace_string){
                $string = str_replace($val, $replace_string, $string);
            }
        }
        return $string;
    }

}
