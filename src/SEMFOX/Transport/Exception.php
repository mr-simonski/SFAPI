<?php
    /**
     * ./Transport/Exception.php
     * @author     blange <code@wbl-konzept.de>
     * @cateogry   vendor
     * @package    SEMFOX
     * @subpackage Transport
     * @version    $id$
     */

    namespace SEMFOX\Transport;

    /**
     * An exception for the SEMFOX transport.
     * @author     blange <code@wbl-konzept.de>
     * @cateogry   vendor
     * @package    SEMFOX
     * @subpackage Transport
     * @version    $id$
     */
    class Exception extends \Exception
    {
        /**
         * A possible request context for the exception.
         * @var mixed
         */
        protected $mRequestContext = null;

        /**
         * Returns the possible request context.
         * @return mixed
         */
        public function getRequestContext()
        {
            return $this->mRequestContext;
        } // function

        /**
         * Sets the context for the request.
         * @param mixed $mContext
         * @return Exception
         */
        public function setRequestContext($mContext)
        {
            $this->mRequestContext = $mContext;

            return $this;
        } // function
    } // class