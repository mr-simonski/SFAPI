<?php
    /**
     * ./Transport/TransportInterface.php
     * @author     blange <code@wbl-konzept.de>
     * @cateogry   vendor
     * @package    SEMFOX
     * @subpackage Transport
     * @version    $id$
     */

    namespace SEMFOX\Transport;

    /**
     * The basic API for a transport class.
     * @author     blange <code@wbl-konzept.de>
     * @cateogry   vendor
     * @package    SEMFOX
     * @subpackage Transport
     * @version    $id$
     */
    interface TransportInterface
    {
        /**
         * HTTP-Method.
         * @var string
         */
        const TYPE_DELETE = 'DELETE';

        /**
         * HTTP-Method.
         * @var string
         */
        const TYPE_GET = 'GET';

        /**
         * HTTP-Method.
         * @var string
         */
        const TYPE_PUT = 'PUT';

        /**
         * HTTP-Method.
         * @var string
         */
        const TYPE_POST = 'POST';

        /**
         * Requests the data and returns the response as a string.
         * @param array $aArguments The request arguments.
         * @return string
         * @throws \SEMFOX\Transport\Exception
         */
        public function processRequest(array $aArguments = array()); // function
    } // interface