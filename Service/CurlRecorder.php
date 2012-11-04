<?php

namespace NicParry\Bundle\CurlBundle\Service;

class CurlRecorder
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
        foreach ($this->mocks as $track => $mocks) {
            if (!is_dir($this->dirName . '/' . $track)) {
                mkdir($this->dirName . '/' . $track);
            }
            foreach ($mocks as $hash => $mock) {
                foreach ($mock as $key => $value) {
                    if (!is_dir($this->dirName . '/' . $track . '/' . $hash)) {
                        mkdir($this->dirName . '/' . $track . '/' . $hash);
                    }
                    $file = fopen($this->dirName . '/' . $track . '/' . $hash . '/' . $key, 'a');
                    fwrite($file, $value);
                    fclose($file);
                }
            }
        }
    }

    public function add($mockTrack, $method, $url, $params, $response)
    {
        $hash = md5($method . $url . $params);
        $this->mocks[$mockTrack][$hash][] = $response;
    }
}