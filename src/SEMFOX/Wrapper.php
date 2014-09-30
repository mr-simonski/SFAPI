<?php
    /**
     * ./Wrapper.php
     * @author   blange <code@wbl-konzept.de>
     * @cateogry vendor
     * @package  SEMFOX
     * @version  $id$
     */

    namespace SEMFOX;

    use SEMFOX\Transport\HTTP\File as HTTPFile,
        SEMFOX\Transport\TransportInterface;

    /**
     * Basic wrapper for connecting to SEMFOX.
     * @author   blange <code@wbl-konzept.de>
     * @cateogry vendor
     * @package  SEMFOX
     * @version  $id$
     */
    class Wrapper
    {
        /**
         * The used config.
         * @var array
         */
        protected $aConfig = array();

        /**
         * The array of requested path parts, starting with the array key 0.
         * @var string
         */
        protected $aRequestedPath = '';

        /**
         * The transport instances sorted by type (GET,POST,PUT etc).
         * @var TransportInterface[]
         */
        protected $aTransportTypes = array();

        /**
         * Construct.
         * @param array $aConfig
         */
        public function __construct(array $aConfig = array())
        {
            $this->aConfig = $aConfig;
        } // function

        /**
         * Processes a GET/POST/PUT request for the given path.
         * @param string $sName HTTP-Method.
         * @param array $aArgs Request arguments.
         * @return stdClass
         * @todo Check Verbs!
         */
        public function __call($sName, array $aArgs = array())
        {
            $aRequestArguments = array();
            $oRequestType      = new Request($this->getConfig());

            $oRequestType->setTransport($this->getTransportType(strtoupper($sName)));

            if (is_string($aArgs[0])) {
                $aRequestArguments['path'] = array_shift($aArgs);
            } else {
                $aRequestArguments['path'] = $this->aRequestedPath;
            }

            return $oRequestType(array_merge($aArgs[0], $aRequestArguments));
        } // function

        /**
         * Returns a copy of this wrapper for constructing REST-Paths like $this->queries->suggest ....
         * @param string $sName The dir name.
         * @return Wrapper
         */
        public function __get($sName)
        {
            $oReturn = clone $this;

            $oReturn->aRequestedPath[] = $sName;

            return $oReturn;
        } // function

        /**
         * Returns the config array.
         * @return array
         */
        protected function getConfig()
        {
            return $this->aConfig;
        } // function

        /**
         * Returns a transport instance for the given HTTP-Method.
         * @param string $sMethod The HTTP-Method.
         * @return TransportInterface
         */
        protected function getTransportType($sMethod)
        {
            if (!(($oReturn = @$this->aTransportTypes[$sMethod]) instanceof TransportInterface)) {
                $this->aTransportTypes[$sMethod] = new HTTPFile($this->getConfig());

                $this->aTransportTypes[$sMethod]->setType($sMethod);
            } // if

            return $this->aTransportTypes[$sMethod];
        } // function

        /**
         * "Overwrites" a transport instance for the given HTTP-Method.
         * @param TransportInterface $oTransport
         * @param string $sMethod
         * @return $this
         */
        public function setTransportType(TransportInterface $oTransport, $sMethod)
        {
            $this->aTransportTypes[$sMethod] = $oTransport;

            return $this;
        } // function
    } // class