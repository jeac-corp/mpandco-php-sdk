<?php

/*
 * This file is part of the Witty Growth C.A. - J406095737 package.
 * 
 * (c) www.mpandco.com
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JeacCorp\Mpandco\Core;

use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Manejador de configuracion desde archivo .ini
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class ConfigManager {

    /**
     * Configuration Options
     *
     * @var array
     */
    private $configs = null;

    /**
     * Singleton Object
     *
     * @var $this
     */
    private static $instance;

    /**
     * Private Constructor
     */
    private function __construct(array $configs = null) {
        $useIni = true;
        if($configs !== null){
            if(isset($configs["use_ini"])){
                $useIni = (bool)$configs["use_ini"];
            }
            unset($configs["use_ini"]);
            $this->addConfigs($configs);
        }
        
        if (defined('PP_CONFIG_PATH')) {
            $configFile = constant('PP_CONFIG_PATH') . '/parameters.ini';
        } else {
            $configFile = implode(DIRECTORY_SEPARATOR, array(dirname(__FILE__), "..", "config", "parameters.ini"));
        }
        if ($useIni && file_exists($configFile)) {
            $this->addConfigFromIni($configFile);
        }
    }

    /**
     * If a configuration exists in both arrays,
     * then the element from the first array will be used and
     * the matching key's element from the second array will be ignored.
     *
     * @param array $configs
     * @return $this
     */
    public function addConfigs(array $configs) {
        if ($this->configs === null) {
            $this->configs = [
                'mode' => 'sandbox',
                'http.connection_time_out' => 30,
                'log.log_enabled' => true,
                'log.file_name' => '../api.log',
                'log.log_level' => 'FINE',
                'validation.level' => 'log',
                "oauth.base_uri" => null,
                "cache.enabled" => true,
            ];
        }
        $resolver = new OptionsResolver();
        $resolver->setDefined([
            "clientId",
            "clientSecret"
        ]);
//        $resolver->setDefined($optionNames);
        $resolver->setDefaults($this->configs);
        $resolver->setAllowedValues("mode", ["sandbox", "live"]);

        $this->configs = $resolver->resolve($configs);
        return $this;
    }

    /**
     * Add Configuration from configuration.ini files
     *
     * @param string $fileName
     * @return $this
     */
    public function addConfigFromIni($fileName) {
        if ($configs = parse_ini_file($fileName)) {
            $this->addConfigs($configs);
        }
        return $this;
    }

    /**
     * Returns the singleton object
     *
     * @return ConfigManager
     */
    public static function getInstance(array $configs = null) {
        if (!isset(self::$instance) || $configs !== null) {
            //si $configs es diferente de null se debe reinicializar la instancia
            self::$instance = new self($configs);
        }
        return self::$instance;
    }

    /**
     * Simple getter for configuration params
     * If an exact match for key is not found,
     * does a "contains" search on the key
     *
     * @param string $searchKey
     * @return array
     */
    public function get($searchKey) {
        if (array_key_exists($searchKey, $this->configs)) {
            return $this->configs[$searchKey];
        } else {
            $arr = array();
            if ($searchKey !== '') {
                foreach ($this->configs as $k => $v) {
                    if (strstr($k, $searchKey)) {
                        $arr[$k] = $v;
                    }
                }
            }

            return $arr;
        }
    }

    /**
     * returns the config file hashmap
     */
    public function getConfigHashmap() {
        return $this->configs;
    }

    /**
     * Disabling __clone call
     */
    public function __clone() {
        trigger_error('Clone is not allowed.', E_USER_ERROR);
    }
}
