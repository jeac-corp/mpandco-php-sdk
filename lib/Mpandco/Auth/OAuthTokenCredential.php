<?php

/*
 * This file is part of the Jeac Corporation SAS - 901221207-4 package.
 * 
 * (c) www.mpandco.com
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JeacCorp\Mpandco\Auth;

use JeacCorp\Mpandco\Security\Cipher;
use JeacCorp\Mpandco\Cache\AuthorizationCache;
use JeacCorp\Mpandco\Core\AppConstants;
use JeacCorp\Mpandco\Handler\Exception\ConfigurationException;
use JeacCorp\Mpandco\Core\LoggingManager;
use JeacCorp\Mpandco\Exception\ConnectionException;

/**
 * Manejador de token de acceso
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class OAuthTokenCredential
{
    const TOKEN_ENDPOINT = "oauth/v2/token";
    
    public static $CACHE_PATH = '/../../../var/auth.cache';

    /**
     * Private Variable
     *
     * @var int $expiryBufferTime
     */
    public static $expiryBufferTime = 120;

    /**
     * Client ID as obtained from the developer portal
     *
     * @var string $clientId
     */
    private $clientId;

    /**
     * Client secret as obtained from the developer portal
     *
     * @var string $clientSecret
     */
    private $clientSecret;

    /**
     * Generated Access Token
     *
     * @var string $accessToken
     */
    private $accessToken;

    /**
     * Seconds for with access token is valid
     *
     * @var $tokenExpiresIn
     */
    private $tokenExpiresIn;

    /**
     * Last time (in milliseconds) when access token was generated
     *
     * @var $tokenCreateTime
     */
    private $tokenCreateTime;

    /**
     * Instance of cipher used to encrypt/decrypt data while storing in cache.
     *
     * @var Cipher
     */
    private $cipher;

    /**
     * Construct
     *
     * @param string $clientId     client id obtained from the developer portal
     * @param string $clientSecret client secret obtained from the developer portal
     */
    public function __construct($clientId, $clientSecret)
    {
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->cipher = new Cipher($this->clientSecret);
    }

    /**
     * Get Client ID
     *
     * @return string
     */
    public function getClientId()
    {
        return $this->clientId;
    }

    /**
     * Get Client Secret
     *
     * @return string
     */
    public function getClientSecret()
    {
        return $this->clientSecret;
    }

    /**
     * Get AccessToken
     *
     * @param $config
     *
     * @return null|string
     */
    public function getAccessToken($config)
    {
        // Check if we already have accessToken in Cache
        if ($this->accessToken && (($this->tokenExpiresIn - self::$expiryBufferTime) < time()) ) {
            return $this->accessToken;
        }
        // Check for persisted data first
        $token = AuthorizationCache::pull($config, $this->clientId);
        if ($token) {

            $this->tokenCreateTime = $token['tokenCreateTime'];
            $this->tokenExpiresIn = $token['tokenExpiresIn'];

            // Case where we have an old unencrypted cache file
            if (!array_key_exists('accessTokenEncrypted', $token)) {
                AuthorizationCache::push($config, $this->clientId, $this->encrypt($this->accessToken), $this->tokenCreateTime, $this->tokenExpiresIn);
            } else {
                $this->accessToken = $this->decrypt($token['accessTokenEncrypted']);
            }
        }

        // Check if Access Token is not null and has not expired.
        // The API returns expiry time as a relative time unit
        // We use a buffer time when checking for token expiry to account
        // for API call delays and any delay between the time the token is
        // retrieved and subsequently used
        if (
                $this->accessToken != null &&
                ( ($this->tokenExpiresIn - self::$expiryBufferTime) < time() )
        ) {
            $this->accessToken = null;
        }


        // If accessToken is Null, obtain a new token
        if ($this->accessToken == null) {
            // Get a new one by making calls to API
            $this->updateAccessToken($config);
            AuthorizationCache::push($config, $this->clientId, $this->encrypt($this->accessToken), $this->tokenCreateTime, $this->tokenExpiresIn);
        }

        return $this->accessToken;
    }

    /**
     * Retrieves the token based on the input configuration
     *
     * @param array $config
     * @param string $clientId
     * @param string $clientSecret
     * @param string $payload
     * @return mixed
     * @throws PayPalConfigurationException
     */
    protected function getToken($config, $clientId, $clientSecret, $payload)
    {
        $provider = new \League\OAuth2\Client\Provider\GenericProvider([
            'clientId' => $clientId, // The client ID assigned to you by the provider
            'clientSecret' => $clientSecret, // The client password assigned to you by the provider
            'urlAuthorize' => '',
            'urlAccessToken' => self::getEndPoint($config),
            'urlResourceOwnerDetails' => ''
        ]);
        $clientApps = new Grant\ClientApps();
        $provider->getGrantFactory()->setGrant("urn:client_apps", $clientApps);
        $response = null;
        try {
            // Try to get an access token using the client credentials grant.
            $response = $provider->getAccessToken('urn:client_apps');
        } catch (\League\OAuth2\Client\Provider\Exception\IdentityProviderException $e) {
            // Failed to get the access token
            throw $e;
        }
        return $response;
    }

    /**
     * Updates Access Token based on given input
     *
     * @param array $config
     * @param string|null $refreshToken
     * @return string
     */
    public function updateAccessToken($config, $refreshToken = null)
    {
        $this->generateAccessToken($config, $refreshToken);
        return $this->accessToken;
    }

    /**
     * Get HttpConfiguration object for OAuth API
     *
     * @param array $config
     *
     * @return string
     * @throws ConfigurationException
     */
    private static function getEndPoint($config)
    {
//        $baseEndpoint = rtrim(trim(), '/') . self::TOKEN_ENDPOINT;
        $baseEndpoint = self::getBaseUri($config) . self::TOKEN_ENDPOINT;
        return $baseEndpoint;
    }
    public static function getBaseUri($config)
    {
        if (isset($config['oauth.base_uri'])) {
            $baseEndpoint = $config['oauth.base_uri'];
        } elseif (isset($config['mode'])) {
            switch (strtoupper($config['mode'])) {
                case 'SANDBOX':
                    $baseEndpoint = AppConstants::REST_SANDBOX_ENDPOINT;
                    break;
                case 'LIVE':
                    $baseEndpoint = AppConstants::REST_LIVE_ENDPOINT;
                    break;
                default:
                    throw new ConfigurationException('The mode config parameter must be set to either sandbox/live');
            }
        } else {
            // Defaulting to Sandbox
            $baseEndpoint = AppConstants::REST_SANDBOX_ENDPOINT;
        }

        return $baseEndpoint;
    }

    /**
     * Generates a new access token
     *
     * @param array $config
     * @param null|string $refreshToken
     * @return null
     * @throws ConnectionException
     */
    private function generateAccessToken($config, $refreshToken = null)
    {
        $params = array('grant_type' => 'urn:client_apps');
        if ($refreshToken != null) {
            // If the refresh token is provided, it would get access token using refresh token
            // Used for Future Payments
            $params['grant_type'] = 'refresh_token';
            $params['refresh_token'] = $refreshToken;
        }
        $payload = http_build_query($params);
        $response = $this->getToken($config, $this->clientId, $this->clientSecret, $payload);

        if ($response == null || empty($response->getToken()) || empty($response->getExpires())) {
            $this->accessToken = null;
            $this->tokenExpiresIn = null;
            LoggingManager::getInstance(__CLASS__)->warning("Could not generate new Access token. Invalid response from server: ");
            throw new ConnectionException("Could not generate new Access token. Invalid response from server: ");
        } else {
            $this->accessToken = $response->getToken();
            $this->tokenExpiresIn = $response->getExpires();
        }
        $this->tokenCreateTime = time();

        return $this->accessToken;
    }
    
    /**
     * Forzar a expirar el token en cache.
     * @param type $config
     */
    public function expire($config)
    {
        $this->tokenExpiresIn = time() + self::$expiryBufferTime;
        $this->accessToken = null;
        AuthorizationCache::push($config, $this->clientId, $this->encrypt($this->accessToken), $this->tokenCreateTime, $this->tokenExpiresIn);
    }
    
    private function encrypt($input)
    {
        return $this->cipher->encrypt($input);
    }
    private function decrypt($input)
    {
        return $this->cipher->decrypt($input);
    }
}
