<?php
/**
 * Borrowed from official Paypal PHP IPN samples to ensure all is working.
 * Slavi: updated it a bit & the cert file
 * @see https://github.com/paypal/ipn-code-samples/blob/master/php/PaypalIPN.php
 */
class Orbisius_CyberStore_Paypal_IPN {
	/**
	 * I've downloaded the file from: https://curl.haxx.se/docs/caextract.html
	 * @var string
	 */
	private $cert_file = 'cacert-2018-03-07.pem';

    /** @var bool Indicates if the sandbox endpoint is used. */
    private $use_sandbox = false;

    /** @var bool Indicates if the local certificates are used. */
    private $use_local_certs = true;

    /** Production Postback URL */
    const VERIFY_URI = 'https://ipnpb.paypal.com/cgi-bin/webscr';

    /** Sandbox Postback URL */
    const SANDBOX_VERIFY_URI = 'https://ipnpb.sandbox.paypal.com/cgi-bin/webscr';

    /** Response from PayPal indicating validation was successful */
    const VALID = 'VERIFIED';

    /** Response from PayPal indicating validation failed */
    const INVALID = 'INVALID';

    /**
     * Sets the IPN verification to sandbox mode (for use when testing,
     * should not be enabled in production).
     * @return void
     */
    public function useSandbox()
    {
        $this->use_sandbox = true;
    }

    /**
     * Sets curl to use php curl's built in certs (may be required in some
     * environments).
     * @return void
     */
    public function usePHPCerts()
    {
        $this->use_local_certs = false;
    }

    /**
     * Determine endpoint to post the verification data to.
     *
     * @return string
     */
    public function getPaypalUri()
    {
        if ($this->use_sandbox) {
            return self::SANDBOX_VERIFY_URI;
        } else {
            return self::VERIFY_URI;
        }
    }

    /**
     * Verification Function
     * Sends the incoming post data back to PayPal using the cURL library.
     *
     * @param array $data optional
     * @param array $exclude_params optional
     * @return bool
     * @throws Exception
     */
    public function verifyIPN($data = array(), $exclude_params = array())
    {
    	if (!function_exists('curl_init')) {
    		trigger_error(__METHOD__ . " php curl extension doesn't exist.", E_USER_NOTICE);
		    throw new Exception(" php curl extension doesn't exist.");
	    }

        if ( ! count($_POST)) {
            throw new Exception("Missing POST Data");
        }

        if (!empty($data)) {
	        $raw_post_array = (array) $data;
        } else {
	        $raw_post_data  = file_get_contents( 'php://input' );
	        $raw_post_array = explode( '&', $raw_post_data );
        }

        $myPost = array();

        foreach ($raw_post_array as $keyval) {
            $keyval = explode('=', $keyval);

            if (count($keyval) == 2) {
            	// CyberStore may have some vars that shouldn't be part of the validation request.
            	if (!empty($exclude_params) && in_array($keyval[0], $exclude_params)) {
            		continue;
	            }

                // Since we do not want the plus in the datetime string to be encoded to a space, we manually encode it.
                if ($keyval[0] === 'payment_date') {
                    if (substr_count($keyval[1], '+') === 1) {
                        $keyval[1] = str_replace('+', '%2B', $keyval[1]);
                    }
                }

                $myPost[$keyval[0]] = urldecode($keyval[1]);
            }
        }

        // Build the body of the verification post request, adding the _notify-validate command.
        $req = 'cmd=_notify-validate';
        $get_magic_quotes_exists = false;

        if (function_exists('get_magic_quotes_gpc')) {
            $get_magic_quotes_exists = true;
        }

        foreach ($myPost as $key => $value) {
            if ($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1) {
                $value = urlencode(stripslashes($value));
            } else {
                $value = urlencode($value);
            }

            $req .= "&$key=$value";
        }

        // Post the data back to PayPal, using curl. Throw exceptions if errors occur.
        $ch = curl_init($this->getPaypalUri());

        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
        curl_setopt($ch, CURLOPT_SSLVERSION, 6);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);

        // This is often required if the server is missing a global cert bundle, or is using an outdated one.
        if ($this->use_local_certs) {
            curl_setopt($ch, CURLOPT_CAINFO, dirname(__FILE__) . "/cert/" . $this->cert_file);
        }

        curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'User-Agent: PHP-IPN-Verification-Script',
            'Connection: Close',
        ));

        $res = curl_exec($ch);

        if (empty($res)) {
            $errno = curl_errno($ch);
            $errstr = curl_error($ch);
            curl_close($ch);
            throw new Exception("cURL error: [$errno] $errstr");
        }

        $info = curl_getinfo($ch);
        $http_code = $info['http_code'];

        if ($http_code != 200) {
            throw new Exception("PayPal responded with http code $http_code");
        }

        curl_close($ch);

        // Check if PayPal verifies the IPN data, and if so, return true.
        if ($res == self::VALID
            || ( ! empty( $myPost['test_ipn'] ) && ! empty( $myPost['payment_status'] ) && $myPost['payment_status'] == 'Pending' )
        ) {
            return true;
        } else {
            return false;
        }
    }
}
