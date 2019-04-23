<?php

namespace JeacCorp\Mpandco\Log;

/**
 * Constructor del logger
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class DefaultLogFactory implements LogFactoryInterface
{
    /**
     * Returns logger instance implementing LoggerInterface.
     *
     * @param string $className
     * @return LoggerInterface instance of logger object implementing LoggerInterface
     */
    public function getLogger($className)
    {
        return new DefaultLogger($className);
    }
}
