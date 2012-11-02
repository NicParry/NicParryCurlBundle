<?php

namespace NicParry\Bundle\CurlBundle\Service;

use Symfony\Component\HttpKernel\Bundle\Bundle;

use Symfony\Component\DependencyInjection\ContainerAware;

class Curl extends ContainerAware
{
    private $ch;
    protected $container;

    public function __construct($container)
    {
//        $this->container = $container;
    }

    public function get($url, array $fields = array())
    {
        //url-ify the data for the POST
        $fields_string = $this->array_implode( '=', '&', $fields );

        //intitialise the curl instance
        $ch = curl_init($url.'?'.$fields_string);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($ch);
        if(!$result)
        {
            $curlError = curl_error($ch);
            curl_close($ch);

//            $logger = $this->container->get('logger');
//            $logger->err('Curl error: ' . $curlError . ' -- ' . $url . $fields_string);

            throw new \Exception('Curl error: ' . $curlError . ' -- ' . $url . $fields_string);
        }

        $this->ch = $ch;

        return $result;
    }

    public function post($url, array $fields = array())
    {
        //url-ify the data for the POST
        $fields_string = $this->array_implode( '=', '&', $fields );

        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_POST, count($fields));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($ch);
        if(!$result)
        {
            $curlError = curl_error($ch);
            curl_close($ch);

//            $logger = $this->container->get('logger');
//            $logger->err('Curl error: ' . $curlError . ' -- ' . $url . $fields_string);

            throw new \Exception('Curl error: ' . $curlError);
        }

        $this->ch = $ch;

        return $result;
    }

    public function getHttpStatus()
    {
        return curl_getinfo($this->ch, CURLINFO_HTTP_CODE);
    }

    public function close()
    {
        curl_close($this->ch);
    }

    /**
     * Implode an array with the key and value pair giving
     * a glue, a separator between pairs and the array
     * to implode.
     * @param string $glue The glue between key and value
     * @param string $separator Separator between pairs
     * @param array $array The array to implode
     * @return string The imploded array
     */
    private function array_implode( $glue, $separator, $array ) {
        if ( ! is_array( $array ) ) return $array;
        $string = array();
        foreach ( $array as $key => $val ) {
            if ( is_array( $val ) )
                $val = implode( ',', $val );
            $string[] = "{$key}{$glue}{$val}";

        }
        return implode( $separator, $string );

    }

}