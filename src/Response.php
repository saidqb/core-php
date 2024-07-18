<?php

namespace Saidqb\CorePhp;

use Saidqb\CorePhp\Utils\ResponseCode;
use Saidqb\CorePhp\Lib\Str;

class Response
{

    static $responseJsonDecode = [];
    static $responseFilterConfig = [];

    private $responseData = [];
    private $status = ResponseCode::HTTP_OK;
    private $message = ResponseCode::HTTP_OK_MESSAGE;
    private $errorCode = 0;

    public $header = [];

    static function make()
    {
        return new self();
    }

    public function hide($arr = [])
    {
        static::$responseFilterConfig['hide'] = $arr;
        return $this;
    }

    public function decode($arr = [])
    {
        static::$responseFilterConfig['decode'] = $arr;
        return $this;
    }

    public function decodeChild($arr = [])
    {
        static::$responseFilterConfig['decode_child'] = $arr;
        return $this;
    }

    public function decodeArray($arr = [])
    {
        static::$responseFilterConfig['decode_array'] = $arr;
        return $this;
    }

    public function addFields($arr = [])
    {
        foreach ($arr as $k => $v) {
            static::$responseFilterConfig['add_field'][$k] = $v;
        }
        return $this;
    }

    public function addField($field, $value = '')
    {
        static::$responseFilterConfig['add_field'][$field] = $value;
        return $this;
    }

    public function hook($name, $callback)
    {
        static::$responseFilterConfig['hook'][$name] = $callback;
        return $this;
    }

    static function responseDecodeFor($arr = [])
    {
        static::$responseJsonDecode = $arr;
    }

    static function responseConfig($arr = [])
    {
        $default = [
            'hide' => [],
            'decode' => [],
            'decode_child' => [],
            'decode_array' => [],
            'add_field' => [],
            'hook' => [],
        ];

        $rArr = array_merge($default, $arr);
        static::$responseFilterConfig = $rArr;
    }

    static function responseConfigAdd($config, $value = [])
    {
        static::$responseFilterConfig[$config] = $value;
    }


    public function filterResponseField($arr)
    {
        $nv = [];
        if (is_string($arr)) {
            return $nv;
        }

        if (!empty($arr)) {
            foreach ($arr as $kv => $v) {

                if (!empty(static::$responseFilterConfig['hide'])) {
                    if (in_array($kv, static::$responseFilterConfig['hide'])) continue;
                }

                if (!empty(static::$responseFilterConfig['decode'])) {

                    if (in_array($kv, static::$responseFilterConfig['decode'])) {
                        if (!empty($v) && Str::isJson($v)) {
                            $nv[$kv] = json_decode($v);

                            if (!empty(static::$responseFilterConfig['decode_child'])) {
                                foreach (static::$responseFilterConfig['decode_child'] as $kdc => $vdc) {
                                    if (strpos($vdc, '.') !== false) {
                                        $childv = explode('.', $vdc);
                                        if ($kv == $childv[0]) {
                                            if (isset($nv[$kv]->{$childv[1]})) {
                                                $nv[$kv]->{$childv[1]}  = (empty($nv[$kv]->{$childv[1]})) ? (object)null : $nv[$kv]->{$childv[1]};
                                            }
                                        }
                                    }
                                }
                            }
                        } else if (is_array($v)) {
                            $nv[$kv] = (empty($v)) ? (object)null : $v;
                        } else {
                            $nv[$kv] = (object) null;
                        }
                        continue;
                    }
                }

                if (!empty(static::$responseFilterConfig['decode_array'])) {
                    if (in_array($kv, static::$responseFilterConfig['decode_array'])) {
                        if (!empty($v) && Str::isJson($v)) {
                            $nv[$kv] = json_decode($v);
                        } else if (is_array($v)) {
                            $nv[$kv] = $v;
                        } else {
                            $nv[$kv] = array();
                        }
                        continue;
                    }
                }

                if (in_array($kv, static::$responseJsonDecode)) {
                    $nv[$kv] = json_decode($v);
                    continue;
                }

                if (is_null($v) || $v === NULL) {
                    $v = '';
                }

                $nv[$kv] = $v;
            }

            if (!empty(static::$responseFilterConfig['add_field'])) {
                foreach (static::$responseFilterConfig['add_field'] as $k => $v) {
                    $nv[$k] = $v;
                }
            }

            if (!empty(static::$responseFilterConfig['hook'])) {
                foreach (static::$responseFilterConfig['hook'] as $k => $v) {
                    if (is_callable(static::$responseFilterConfig['hook'][$k])) {
                        $nv = call_user_func(static::$responseFilterConfig['hook'][$k], $nv);
                    }
                }
            }
        }

        return $nv;
    }

    public function getHeader()
    {
        foreach ($this->header as $header) {
            header($header);
        }
    }

    public function appendHeader($key, $value)
    {
        $this->header[] = $key . ': ' . $value;
        return $this;
    }

    public function withHeaders($headers = [])
    {
        foreach ($headers as $key => $value) {
            $this->header[] = $key . ': ' . $value;
        }
        return $this;
    }

    public function responseDefault()
    {
        return [
            'status' => $this->status,
            'success' => $this->status == ResponseCode::HTTP_OK ? true : false, // 'true' or 'false
            'error_code' => $this->errorCode,
            'message' => $this->message,
            'data' => [],
        ];
    }

    /**
     * Response data
     *
     * @param array $data
     * @param int $status
     * @param string $message
     * @param int $errorCode
     * @return \Illuminate\Http\JsonResponse
     */
    public function response($data = [], $status = ResponseCode::HTTP_OK, $message = ResponseCode::HTTP_OK_MESSAGE, $errorCode = 0)
    {
        // rebuild the response data, if the data is not an array
        if (is_string($data) || is_numeric($data)) {
            $this->errorCode = $message == ResponseCode::HTTP_OK_MESSAGE ? $errorCode : $message;
            $this->message = $status == ResponseCode::HTTP_OK ? $errorCode : $status;
            $this->status = $data;
        } else if (is_object($data)) {
            $data = (array)$data;
        }

        $resData = $this->responseDefault();


        if (isset($data['items'])) {
            $items = [];

            if (!empty($data['items'])) {
                $items = $data['items'];
            }

            if (!empty($data['items']) && is_array($data['items'])) {
                foreach ($data['items'] as $k => $v) {
                    $items[$k] = $this->filterResponseField($v);
                }
            }

            $resData['data']['items'] = $items;

            if (!isset($data['pagination'])) {
                $resData['data']['pagination'] = (object) null;
            } else {
                if ($data['pagination'] === false) {
                    unset($resData['data']['pagination']);
                }

                $resData['data']['pagination'] = $data['pagination'];
            }

            $this->responseData = $resData;
            return $this;
        }

        if (isset($data['item'])) {

            $data['item'] = $this->filterResponseField($data['item']);
            $resData['data'] = $data;
            $this->responseData = $resData;
            return $this;
        }

        $item = (object) null;

        if (!empty($data)) {
            if (is_array($data)) {
                $item = $this->filterResponseField($data);
            }
        }

        $resData['data']['item'] = $item;
        $this->responseData = $resData;
        return $this;
    }


    public function send()
    {
        header("HTTP/1.1 " . $this->responseData['status'] . " " . $this->responseData['message']);
        header("Content-Type: application/json");

        $this->getHeader();

        echo json_encode($this->responseData);
        exit();
    }
}
