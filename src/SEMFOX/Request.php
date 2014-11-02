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
    class Request
    {
        /**
         * The arguments for the request.
         * @var array
         */
        protected $aRequestArguments = array();

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
            $oResponse = $this->getTransport()->processRequest($aArguments);

            return $oResponse->setRequest($this);
        } // function

        /**
         * Returns the request arguments.
         * @return array
         */
        public function getRequestArguments()
        {
            return $this->aRequestArguments;
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
         * Sets the request arguments.
         * @param array $aArgs
         * @return Request
         */
        protected function setRequestArguments(array $aArgs)
        {
            return $this->aRequestArguments = $aArgs;

            return $this;
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