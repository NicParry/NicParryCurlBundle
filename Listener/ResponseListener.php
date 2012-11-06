<?php
namespace NicParry\Bundle\CurlBundle\Listener;

class ResponseListener
{
    private $curlWrapper;

    public function __construct($curlWrapper) {
        $this->curlWrapper = $curlWrapper;
    }

    public function onKernelResponse() {
        $this->curlWrapper->writeMocks();
    }
}