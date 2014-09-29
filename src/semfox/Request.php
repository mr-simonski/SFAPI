<?php
    namespace semfox;

    use semfox\Transport\HTTP\File as SemfoxTransport,
        semfox\Transport\TransportInterface;

    /**
     * Request to semfox.
     * @author   blange <code@wbl-konzept.de>
     * @cateogry vendor
     * @package  semfox
     * @version  $id$
     */
    class Request {
        protected $oTransport = null;

        public function __invoke(array $aArguments)
        {
            $oReturn = null;

            if ($sTransported = $this->getTransport()->processRequest($aArguments)) {
                $oReturn = json_decode($sTransported);
            } // if

            return $oReturn;
        } // function

        public function getTransport()
        {
            if (!$this->oTransport) {
                $this->oTransport = new SemfoxTransport();
            } // if

            return $this->oTransport;
        } // function

        public function setTransport(TransportInterface $oTransport)
        {
            $this->oTransport = $oTransport;

            return $this;
        } // function
    } // class