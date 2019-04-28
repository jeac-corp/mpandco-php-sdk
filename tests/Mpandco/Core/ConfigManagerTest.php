<?php

/*
 * This file is part of the Jeac Corporation SAS - 901221207-4 package.
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
        $this->assertEquals("http://app.mpandco.local/app_test.php/",$configManager->get("oauth.base_uri"));
    }
    
    public function testFromArray() {
        $configManager = ConfigManager::getInstance();
        $configManager->addConfigs([
            "mode" => "live",
            "log.log_enabled" => false,
        ]);
        
        $this->assertEquals("live",$configManager->get("mode"));
        $this->assertEquals(false,$configManager->get("log.log_enabled"));
        $this->assertEquals(30,$configManager->get("http.connection_time_out"));
        $this->assertEquals("log",$configManager->get("validation.level"));
    }
}
