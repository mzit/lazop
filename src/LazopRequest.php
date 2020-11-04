<?php

namespace Mzit\Lazop;

use Exception;

class LazopRequest
{
    public $apiName;

    public $headerParams = array();

    public $udfParams = array();

    public $fileParams = array();

    public $httpMethod = 'POST';

    /**
     * LazopRequest constructor.
     * @param $apiName
     * @param string $httpMethod
     * @throws Exception
     */
    public function __construct($apiName, $httpMethod = 'POST')
    {
        $this->apiName = $apiName;
        $this->httpMethod = $httpMethod;

        if ($this->startWith($apiName, "//")) {
            throw new Exception("api name is invalid. It should be start with /");
        }
    }


    /**
     * 添加请求参数
     * @param $key
     * @param $value
     * @throws Exception
     */
    function addApiParam($key, $value)
    {
        if (!is_string($key)) {
            throw new Exception("api param key should be string");
        }

        if (is_object($value)) {
            $this->udfParams[$key] = json_decode($value);
        } else {
            $this->udfParams[$key] = $value;
        }
    }

    /**
     * 添加文件参数
     * @param $key
     * @param $content
     * @param string $mimeType
     * @throws Exception
     */
    function addFileParam($key, $content, $mimeType = 'application/octet-stream')
    {
        if (!is_string($key)) {
            throw new Exception("api file param key should be string");
        }

        $file = array(
            'type'    => $mimeType,
            'content' => $content,
            'name'    => $key
        );
        $this->fileParams[$key] = $file;
    }

    /**
     * 添加Header
     * @param $key
     * @param $value
     * @throws Exception
     */
    function addHttpHeaderParam($key, $value)
    {
        if (!is_string($key)) {
            throw new Exception("http header param key should be string");
        }

        if (!is_string($value)) {
            throw new Exception("http header param value should be string");
        }

        $this->headerParams[$key] = $value;
    }

    /**
     * 是否以xx开始
     * @param $str
     * @param $needle
     * @return bool
     */
    function startWith($str, $needle)
    {
        return strpos($str, $needle) === 0;
    }
}
