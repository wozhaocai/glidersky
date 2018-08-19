<?php

namespace GliderSky;

use GliderSky\framework\config\ConfigService;

class GliderSky
{
    private $_sConfigPath = "";

    public function __construct($sConfigPath)
    {
        $this->_sConfigPath = $sConfigPath;
    }

    public function start(){
        $this->loadConfig();
    }

    public function loadConfig(){
        ConfigService::loadConfig($this->_sConfigPath);
    }

}