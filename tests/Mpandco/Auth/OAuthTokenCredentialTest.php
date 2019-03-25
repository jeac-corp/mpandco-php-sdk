<?php

/*
 * This file is part of the Witty Growth C.A. - J406095737 package.
 * 
 * (c) www.mpandco.com
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JeacCorp\Test\Mpandco\Auth;

use JeacCorp\Test\Mpandco\BaseTest;
use JeacCorp\Mpandco\Auth\OAuthTokenCredential;
use JeacCorp\Test\Mpandco\Constants;
use JeacCorp\Mpandco\Core\ConfigManager;
use JeacCorp\Mpandco\Cache\AuthorizationCache;

/**
 * Test de manejador de token
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class OAuthTokenCredentialTest extends BaseTest
{
    public function testGetAccessToken()
    {
        $config = ConfigManager::getInstance()->getConfigHashmap();
        $cachePath = AuthorizationCache::cachePath($config);
        if(file_exists($cachePath)){
            unlink($cachePath);
        }
        $cred = new OAuthTokenCredential(Constants::CLIENT_ID, Constants::CLIENT_SECRET);
        $this->assertEquals(Constants::CLIENT_ID, $cred->getClientId());
        $this->assertEquals(Constants::CLIENT_SECRET, $cred->getClientSecret());
        $token = $cred->getAccessToken($config);
        $this->assertNotNull($token);

        // Check that we get the same token when issuing a new call before token expiry
        $newToken = $cred->getAccessToken($config);
        $this->assertNotNull($newToken);
        $this->assertEquals($token, $newToken);
    }
}
