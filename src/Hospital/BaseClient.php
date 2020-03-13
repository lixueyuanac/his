<?php
namespace Hospital;
use GuzzleHttp\Client;

class  BaseClient
{
    protected $guzzleOptions = [];
    public $url = '';

    public function __construct($url = '')
    {
        $this->url = 'xxxxxxx';
    }

    public function getHttpClient()
    {
        return new Client($this->guzzleOptions);
    }

    public function setGuzzleOptions(array $options)
    {
        $this->guzzleOptions = $options;
    }

    public function requestUrl($url,$params, $format = 'json'){
        $res = $this->getHttpClient()->post($url, $params)->getBody()->getContents();
        return 'json' === $format ? \json_decode($res, true) : $res;
    }
}