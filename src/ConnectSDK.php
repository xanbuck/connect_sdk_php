<?php
/**
 * Connect SDK by Getty Images.
 * Provides an interface to Getty Images connect api.
 *
 * The goal of the SDK is to simplify credential management and provide a reusable library
 * for developers.
 *
 * @link https://php.net//manual/en/book.curl.php
 * @link https://php.net/manual/en/function.curl-errno.php
 * @link http://en.wikipedia.org/wiki/PHPDoc
 *
 */

namespace GettyImages\Connect {
    require_once("Request/FluentRequest.php");
    require_once("Credentials.php");
    require_once("Request/Collections.php");
    require_once("Request/Countries.php");
    require_once("Request/WebHelper.php");
    require_once("Request/Download.php");
    require_once("Request/Images.php");
    require_once("Request/Search/Search.php");

    use GettyImages\Connect\Request\Search\Search;
    use GettyImages\Connect\Request\Download;
    use GettyImages\Connect\Request\Images;

    /**
     * ConnectSDK
     *
     * Provides a code api for interacting with Getty Images REST services @ http://api.gettyimages.com.
     */
    class ConnectSDK {

        /** @ignore */
        private $credentials = null;

        /** @ignore */
        private $connectBaseUri = "https://connect.gettyimages.com/v3";

        private $authEndpoint = "https://connect.gettyimages.com/oauth2/token";

        /**
         * Constructor for ConnectSDK
         *
         * @param null $apiKey
         * @param null $apiSecret
         * @param null $username
         * @param null $password
         * @example UsageExamples.php Examples
         */
        public function __construct($apiKey, $apiSecret = null, $username = null, $password = null, $refreshToken = null) {

            $credentials = array(
                "client_key" => $apiKey,
                "client_secret" => $apiSecret,
                "username" => $username,
                "password" => $password,
                "refresh_token" => $refreshToken);

            $this->credentials = new Credentials($this->authEndpoint ,$credentials);
        }

        /**
         * Retrieves a authentication token for configured credentials
         */
        public function getAccessToken() {
            $authenticationResponse = $this->credentials->getAuthenticationDetails();
            return $authenticationResponse;
        }

        /**
         *  Search
         *
         * @return Search A search request object initially configured with credentials
         */
        public function Search() {
            $searchObj = new Search($this->credentials,$this->connectBaseUri);

            return $searchObj;
        }

        /**
         * Images
         *
         * Provides the start of the Images Request. Use this for getting details
         * for known image id's
         *
         * @return Images
         */
        public function Images() {
            $imagesObj = new Images($this->credentials,$this->connectBaseUri);

            return $imagesObj;
        }

        /**
         * Download
         *
         * Provides the start of the Images endpoint. Use this for getting details
         * for known image id's
         *
         * @return Download
         */
        public function Download() {
            $downloadObj = new Download($this->credentials,$this->connectBaseUri);

            return $downloadObj;
        }

        private function Collections() {
            $collectionsObj = new Collections($this->credentials,$this->connectBaseUri);
            return $collectionsObj;
        }

        private function Countries() {
            $countriesObj = new Countries($this->credentials,$this->connectBaseUri);
            return $countriesObj;
        }


    }
}
