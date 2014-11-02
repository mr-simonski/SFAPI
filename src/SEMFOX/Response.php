<?php
    /**
     * ./Response.php
     * @author   blange <code@wbl-konzept.de>
     * @cateogry vendor
     * @package  SEMFOX
     * @version  $id$
     */

    namespace SEMFOX;

    use SEMFOX\Request;

    /**
     * Response of SEMFOX.
     * @author   blange <code@wbl-konzept.de>
     * @cateogry vendor
     * @package  SEMFOX
     * @version  $id$
     */
    class Response
    {
        /**
         * The callback to decode the response.
         * @var Callable
         */
        protected $mDecodeCallback = null;

        /**
         * The response as object.
         * @var stdClass
         */
        protected $oDataObject = null;

        /**
         * The used request class.
         * @var Request
         */
        protected $oRequest = null;

        /**
         * The raw response.
         * @var string
         */
        protected $sRawResponse = '';

        /**
         * The construct.
         * @param string $sRawResponse
         */
        public function __construct($sRawResponse)
        {
            $this->sRawResponse = $sRawResponse;
        } // function

        /**
         * Magical getter for the response data.
         * @param string $sName The name of the value.
         * @return mixed
         */
        public function __get($sName)
        {
            return $this->getDataObject()->$sName;
        } // function

        /**
         * Is the given value set?
         * @param string $sName
         * @return bool
         */
        public function __isset($sName)
        {
            $oObject = $this->getDataObject();

            return isset($oObject->$sName);
        } // function

        /**
         * Returns the raw response.
         * @return string
         */
        public function __toString()
        {
            return $this->sRawResponse;
        } // function

        /**
         * Returns the response as an object.
         * @return \stdClass
         */
        protected function getDataObject()
        {
            if (!$this->oDataObject) {
                $this->setDataObject(
                    ($mTmp = call_user_func($this->getDecodeCallback(), $this->sRawResponse))
                        ? $mTmp
                        : new \stdClass()
                );
            } // if

            return $this->oDataObject;
        } // function

        /**
         * Returns the callback to decode the raw response.
         * @return Callable
         */
        protected function getDecodeCallback()
        {
            if (!$this->mDecodeCallback) {
                /**
                 * http://de2.php.net/manual/en/function.json-decode.php:
                 *
                 * PHP implements a superset of JSON - it will also encode and decode scalar types and NULL. The JSON standard
                 * only supports these values when they are nested inside an array or an object.
                 */
                $this->setDecodeCallback('json_decode');
            } // if

            return $this->mDecodeCallback;
        } // function

        /**
         * Returns the request class.
         * @return Request
         */
        public function getRequest()
        {
            return $this->oRequest;
        } // function

        /**
         * Setter for the data object.
         * @param \stdClass $oData
         * @return Response
         */
        public function setDataObject(\stdClass $oData)
        {
            $this->oDataObject = $oData;

            return $this;
        } // function

        /**
         * Sets the decode callback.
         * @param Callable $mCallback
         * @return Response
         */
        public function setDecodeCallback($mCallback)
        {
            $this->mDecodeCallback = $mCallback;

            return $this;
        } // function

        /**
         * Sets the used request class.
         * @param Request $oRequest
         * @return Response
         */
        public function setRequest(Request $oRequest)
        {
            $this->oRequest = $oRequest;

            return $this;
        } // function
    } // class