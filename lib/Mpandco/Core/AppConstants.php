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

/**
 * Constantes para comunicarse con la api
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class AppConstants {
    const SDK_NAME = 'mPandco-PHP-SDK';
    const SDK_VERSION = '1.0.0';

    /**
     * Approval URL for Payment
     */
    const APPROVAL_URL = 'approval_url';

    const REST_SANDBOX_ENDPOINT = "https://sandbox.mpandco.com";
    const OPENID_REDIRECT_SANDBOX_URL = "https://sandbox.mpandco.com";

    const REST_LIVE_ENDPOINT = "https://app.mpandco.com/";
    const OPENID_REDIRECT_LIVE_URL = "https://app.mpandco.com";
}
