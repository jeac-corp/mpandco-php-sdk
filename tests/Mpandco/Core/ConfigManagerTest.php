<?php

/*
 * This file is part of the Witty Growth C.A. - J406095737 package.
 * 
 * (c) www.mpandco.com
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JeacCorp\Test\Mpandco\Core;

use JeacCorp\Test\Mpandco\BaseTest;
use JeacCorp\Mpandco\Core\ConfigManager;

/**
 * Test de configuracion
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class ConfigManagerTest extends BaseTest
{
    public function testFromIni() {
        $configManager = ConfigManager::getInstance();
        
        $this->assertCount(0, $configManager->get("invalid"));
        $this->assertEquals("sandbox",$configManager->get("mode"));
        $this->assertEquals("http://app.mpandco.local",$configManager->get("oauth.EndPoint"));
    }
    
    public function testFromArray() {
        $configManager = ConfigManager::getInstance();
        $configManager->addConfigs([
            "mode" => "live",
            "log.LogEnabled" => false,
        ]);
        
        $this->assertEquals("live",$configManager->get("mode"));
        $this->assertEquals(false,$configManager->get("log.LogEnabled"));
        $this->assertEquals(30,$configManager->get("http.ConnectionTimeOut"));
        $this->assertEquals("log",$configManager->get("validation.level"));
    }
}
