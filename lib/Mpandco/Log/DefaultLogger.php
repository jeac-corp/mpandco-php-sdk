<?php

namespace JeacCorp\Mpandco\Log;

use JeacCorp\Mpandco\Core\ConfigManager;
use Psr\Log\AbstractLogger;
use Psr\Log\LogLevel;

/**
 * Loger estandar
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class DefaultLogger extends AbstractLogger
{
    /**
     * @var array Indexed list of all log levels.
     */
    private $loggingLevels = array(
        LogLevel::EMERGENCY,
        LogLevel::ALERT,
        LogLevel::CRITICAL,
        LogLevel::ERROR,
        LogLevel::WARNING,
        LogLevel::NOTICE,
        LogLevel::INFO,
        LogLevel::DEBUG
    );

    /**
     * Configured Logging Level
     *
     * @var LogLevel $loggingLevel
     */
    private $loggingLevel;

    /**
     * Configured Logging File
     *
     * @var string
     */
    private $loggerFile;

    /**
     * Log Enabled
     *
     * @var bool
     */
    private $isLoggingEnabled;

    /**
     * Logger Name. Generally corresponds to class name
     *
     * @var string
     */
    private $loggerName;

    public function __construct($className)
    {
        $this->loggerName = $className;
        $this->initialize();
    }

    public function initialize()
    {
        $config = ConfigManager::getInstance()->getConfigHashmap();
        if (!empty($config)) {
            $this->isLoggingEnabled = (array_key_exists('log.log_enabled', $config) && $config['log.log_enabled'] == '1');
            if ($this->isLoggingEnabled) {
                $this->loggerFile = ($config['log.file_name']) ? $config['log.file_name'] : ini_get('error_log');
                $loggingLevel = strtoupper($config['log.log_level']);
                $this->loggingLevel = (isset($loggingLevel) && defined("\\Psr\\Log\\LogLevel::$loggingLevel")) ?
                    constant("\\Psr\\Log\\LogLevel::$loggingLevel") :
                    LogLevel::INFO;
            }
        }
    }

    public function log($level, $message, array $context = array())
    {
        if ($this->isLoggingEnabled) {
            // Checks if the message is at level below configured logging level
            if (array_search($level, $this->loggingLevels) <= array_search($this->loggingLevel, $this->loggingLevels)) {
                error_log("[" . date('d-m-Y H:i:s') . "] " . $this->loggerName . " : " . strtoupper($level) . ": $message\n", 3, $this->loggerFile);
            }
        }
    }
}
