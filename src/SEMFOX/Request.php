<?php
    /**
     * ./Request.php
     * @author   blange <code@wbl-konzept.de>
     * @cateogry vendor
     * @package  SEMFOX
     * @version  $id$
     */

    namespace SEMFOX;

    use SEMFOX\Transport\HTTP\File as SemfoxTransport,
        SEMFOX\Transport\TransportInterface;

    /**
     * Request to SEMFOX.
     * @author   blange <code@wbl-konzept.de>
     * @cateogry vendor
     * @package  SEMFOX
     * @version  $id$
     */
    class Request {
        /**
         * The used transpor instance.
         * @var TransportInterface|void
         */
        protected $oTransport = null;

        /**
         * Process the request with the given transport instance and returns the json_decoded response.
         * @param array $aArguments The request arguments.
         * @return \stdClass|null
         */
        public function __invoke(array $aArguments)
        {
            $oReturn = null;

            if ($sResponse = $this->getTransport()->processRequest($aArguments)) {
                $oReturn = $this->parseRawResponse($sResponse);
            } // if

            return $oReturn;
        } // function

        /**
         * Returns the used transport instance.
         * @return TransportInterface
         */
        public function getTransport()
        {
            if (!$this->oTransport) {
                $this->oTransport = new SemfoxTransport();
            } // if

            return $this->oTransport;
        } // function

        /**
         * Parses the given response of the transporter.
         * @param string $sResponse
         * @return \stdClass
         */
        protected function parseRawResponse($sResponse)
        {
            /**
             * http://de2.php.net/manual/en/function.json-decode.php:
             *
             * PHP implements a superset of JSON - it will also encode and decode scalar types and NULL. The JSON standard
             * only supports these values when they are nested inside an array or an object.
             */
            return json_decode($sResponse);
        } // function

        /**
         * Sets the used transport instance.
         * @param TransportInterface $oTransport
         * @return \SEMFOX\Request
         */
        public function setTransport(TransportInterface $oTransport)
        {
            $this->oTransport = $oTransport;

            return $this;
        } // function
    } // class