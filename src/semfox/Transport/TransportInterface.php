<?php
    namespace semfox\Transport;

    interface TransportInterface
    {
        const TYPE_DELETE = 'DELETE';

        const TYPE_GET = 'GET';

        const TYPE_PUT = 'PUT';

        const TYPE_POST = 'POST';

        public function processRequest(array $aArguments = array()); // function
    } // interface