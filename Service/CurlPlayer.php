<?php

namespace NicParry\Bundle\CurlBundle\Service;

class CurlPlayer
{
    private $dirName;

    private $mocks;

    public function __construct($dirName)
    {
        if (!file_exists($dirName)) {
            mkdir($dirName);
        }
        $this->dirName = $dirName;
        $this->mocks = array();
    }

    public function __destruct()
    {
    }

    public function request($mockTrack, $method, $url, $params)
    {
        $hash = md5($method . $url . $params);
        $this->mocks[$mockTrack][$hash][] = true;

        if (!is_dir($this->dirName . '/' . $mockTrack . '/' . $hash)) {

            return false;
        }

        end($this->mocks[$mockTrack][$hash]);
        $key = key($this->mocks[$mockTrack][$hash]);

        if (!file_exists($this->dirName . '/' . $mockTrack . '/' . $hash . '/' . $key)) {

            return false;
        }

        return file_get_contents($this->dirName . '/' . $mockTrack . '/' . $hash . '/' . $key);

    }
}