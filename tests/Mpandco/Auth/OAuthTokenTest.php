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
use JeacCorp\Test\Mpandco\Constants;
use JeacCorp\Mpandco\Core\ConfigManager;

/**
 * Prueba la conectividad oAuth2
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class OAuthTokenTest extends BaseTest {

    const URL_END_POINT = "/oauth/v2/token";

    public function testGetAccessTokenClientCredentials() {
        $endPoint = ConfigManager::getInstance()->get("oauth.base_uri") . self::URL_END_POINT;
        $provider = new \League\OAuth2\Client\Provider\GenericProvider([
            'clientId' => Constants::CLIENT_ID, // The client ID assigned to you by the provider
            'clientSecret' => Constants::CLIENT_SECRET, // The client password assigned to you by the provider
            'urlAuthorize' => '',
            'urlAccessToken' => $endPoint,
            'urlResourceOwnerDetails' => ''
        ]);
        try {

            // Try to get an access token using the client credentials grant.
            $accessToken = $provider->getAccessToken('client_credentials');
            $this->assertNotNull($accessToken->getToken());
            $this->assertFalse($accessToken->hasExpired());
        } catch (\League\OAuth2\Client\Provider\Exception\IdentityProviderException $e) {

            // Failed to get the access token
            exit($e->getMessage());
        }
    }
    
    public function testGetAccessTokenPassword() {
        $endPoint = ConfigManager::getInstance()->get("oauth.base_uri") . self::URL_END_POINT;
        $provider = new \League\OAuth2\Client\Provider\GenericProvider([
            'clientId' => Constants::CLIENT_ID, // The client ID assigned to you by the provider
            'clientSecret' => Constants::CLIENT_SECRET, // The client password assigned to you by the provider
            'urlAuthorize' => '',
            'urlAccessToken' => $endPoint,
            'urlResourceOwnerDetails' => ''
        ]);
        try {

            // Try to get an access token using the client credentials grant.
            $accessToken = $provider->getAccessToken('password',[
                'username' => '04140000010',
                'password' => 'abc.12345'
            ]);
            $this->assertNotNull($accessToken->getToken());
            $this->assertFalse($accessToken->hasExpired());
            $this->assertNotNull($accessToken->getRefreshToken());
            
            $newAccessToken = $provider->getAccessToken('refresh_token', [
                'refresh_token' => $accessToken->getRefreshToken(),
            ]);
            $this->assertNotNull($newAccessToken->getToken());
            $this->assertFalse($newAccessToken->hasExpired());
            
        } catch (\League\OAuth2\Client\Provider\Exception\IdentityProviderException $e) {

            // Failed to get the access token
            exit($e->getMessage());
        }
    }

    public function testInvalidCredentials() {
        $endPoint = ConfigManager::getInstance()->get("oauth.base_uri") . self::URL_END_POINT;
        $provider = new \League\OAuth2\Client\Provider\GenericProvider([
            'clientId' => "invalid", // The client ID assigned to you by the provider
            'clientSecret' => "invalid", // The client password assigned to you by the provider
            'urlAuthorize' => 'http://service.example.com/authorize',
            'urlAccessToken' => $endPoint,
            'urlResourceOwnerDetails' => 'http://service.example.com/resource'
        ]);

        $this->expectException(\League\OAuth2\Client\Provider\Exception\IdentityProviderException::class);
        $this->expectExceptionMessage("invalid_client");
        // Try to get an access token using the client credentials grant.
        $accessToken = $provider->getAccessToken('client_credentials');
    }

}
