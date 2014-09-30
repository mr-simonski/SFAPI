<?php
    /**
     * ./Transport/TransportAbstract.php
     * @author     blange <code@wbl-konzept.de>
     * @cateogry   vendor
     * @package    SEMFOX
     * @subpackage Transport
     * @version    $id$
     */

    namespace SEMFOX\Transport;

    /**
     * Abstract fullfilling the basic API.
     * @author     blange <code@wbl-konzept.de>
     * @cateogry   vendor
     * @package    SEMFOX
     * @subpackage Transport
     * @version    $id$
     */
    abstract class TransportAbstract implements TransportInterface
    {
        /**
         * The used config.
         * @var array
         */
        protected $aConfig = array();

        /**
         * The used HTTP method/request type.
         * @var string
         */
        protected $sType = '';

        /**
         * Construct.
         * @param array $aConfig
         */
        public function __construct(array $aConfig = array())
        {
            $this->aConfig = $aConfig;
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
         * Returns the config value with the given name or the default value.
         * @param string $sName    The config name.
         * @param mixed  $mDefault The default value.
         * @return mixed
         */
        protected function getConfigValue($sName, $mDefault = null)
        {
            return @$this->aConfig[$sName] ?: $mDefault;
        } // function

        /**
         * Returns the request type/HTTP method.
         * @return string
         */
        public function getType()
        {
            return $this->sType;
        } // function

        /**
         * Sets the request type/HTTP method.
         * @param $sType
         * @return \SEMFOX\Transport\TransportAbstract
         */
        public function setType($sType)
        {
            $this->sType = $sType;

            return $this;
        } // function
    } // class