<?php
    /**
     * ./Transport/HTTP/File.php
     * @author     blange <code@wbl-konzept.de>
     * @cateogry   vendor
     * @package    SEMFOX
     * @subpackage Transport\HTTP
     * @version    $id$
     */

    namespace SEMFOX\Transport\HTTP;

    use SEMFOX\Transport\TransportAbstract,
        SEMFOX\Transport\Exception as TransportException;

    /**
     * Transport class for opening urls with the fopen-wrapper.
     * @author     blange <code@wbl-konzept.de>
     * @cateogry   vendor
     * @package    SEMFOX
     * @subpackage Transport\HTTP
     * @version    $id$
     */
    class File extends TransportAbstract
    {
        /**
         * The default port.
         * @var string
         */
        const DEFAULT_PORT = '8585';

        /**
         * The default timeout for the connection.
         * @var string
         */
        const DEFAULT_TIMEOUT = 15;

        /**
         * Creates the fopen request for the next request.
         * @param array $aRequestArgs
         * @return array The first value is the context resource and the second value are the remaining request arguments.
         * @throws TransportException If there is an error.
         * @todo   SSL (and Validation!)
         */
        protected function createRequestContext(array $aRequestArgs = array())
        {
            $aOptions = array(
                'http' => array(
                    'method'  => $sMethod = $this->getType(),
                    'timeout' => (int) $this->getConfigValue('requestTimeout', self::DEFAULT_TIMEOUT)
                )
            );

            if ($sMethod === self::TYPE_POST || $sMethod === self::TYPE_PUT) {
                $sRequestContent = json_encode($aRequestArgs);
                $aRequestArgs    = array();

                $aOptions['http']['header'] =
                    "Content-type: application/json\r\n" .
                    'Content-Length: ' . strlen($sRequestContent) . "\r\n";

                $aOptions['http']['content'] = $sRequestContent;
            } // if

            $aNeededValues = array('apiKey', 'customerId');

            foreach ($aNeededValues as $sName) {
                if (!$mValue = $this->getConfigValue($sName, '')) {
                    throw new TransportException('Missing config value: ' . $sName, 503);
                } // if

                $aRequestArgs[$sName] = $mValue;
            } // foreach

            return array(stream_context_create($aOptions), $aRequestArgs);
        } // function

        /**
         * Calls the REST-URL with file_get_contents and sets the needed request context for the given request arguments.
         * @param array $aArguments The request arguments.
         * @return string The raw response.
         * @throws TransportException If there is something wrong.
         */
        public function processRequest(array $aArguments = null)
        {
            $aPath = $aArguments['path'];
            unset($aArguments['path']);

            list($rContext, $aArguments) = $this->createRequestContext($aArguments);

            $mReturn = @file_get_contents(
                'http://semfox.com:' . $this->getConfigValue('restPort', self::DEFAULT_PORT) . '/' . implode('/', $aPath) . '?' .
                    http_build_query($aArguments),
                false,
                $rContext
            );

            if ($mReturn === false) {
                throw new TransportException('Last Request did not return output.', 404);
            } // if

            return $mReturn;
        } // function
    } // class