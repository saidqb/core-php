<?php

namespace Saidqb\CorePhp;

use Saidqb\CorePhp\Utils\ResponseCode;
use Saidqb\CorePhp\Lib\Str;

/**
 * Class Response
 * @package Saidqb\CorePhp
 * usage:
 * ```php
 * Response::make()->response([], ResponseCode::HTTP_OK, ResponseCode::HTTP_OK_MESSAGE, 0)->send();
 * or
 * Response::make()->response(['items' => $items, 'pagination' => $pagination])->send();
 * or
 * Response::make()->response(['item' => $item])->send();
 * ```
 */
class Response
{

    public $responseFilterConfig = [];

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
        $this->responseFilterConfig['hide'] = $arr;
        return $this;
    }

    public function decode($arr = [])
    {
        $this->responseFilterConfig['decode'] = $arr;
        return $this;
    }

    public function decodeChild($arr = [])
    {
        $this->responseFilterConfig['decode_child'] = $arr;
        return $this;
    }

    public function decodeArray($arr = [])
    {
        $this->responseFilterConfig['decode_array'] = $arr;
        return $this;
    }

    public function addFields($arr = [])
    {
        foreach ($arr as $k => $v) {
            $this->responseFilterConfig['add_field'][$k] = $v;
        }
        return $this;
    }

    public function addField($field, $value = '')
    {
        $this->responseFilterConfig['add_field'][$field] = $value;
        return $this;
    }

    public function hook($name, $callback)
    {
        $this->responseFilterConfig['hook'][$name] = $callback;
        return $this;
    }

    public function responseConfig($arr = [])
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
        $this->responseFilterConfig = $rArr;
    }

    public function responseConfigAdd($config, $value = [])
    {
        $this->responseFilterConfig[$config] = $value;
    }


    public function itemBuilder($data)
    {
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

            return $data['items'] = $items;
        }

        if (isset($data['item'])) {

            $item = $this->filterResponseField($data['item']);
            $data['item'] = $item;
            return $data['item'];
        }

        $item = (object) null;

        if (!empty($data)) {
            if (is_array($data)) {
                $item = $this->filterResponseField($data);
            }
        }

        $resData['item'] = $item;
    }


    public function filterResponseField($arr)
    {
        $nv = [];
        if (is_string($arr)) {
            return $nv;
        }

        if (!empty($arr)) {
            foreach ($arr as $kv => $v) {

                if (!empty($this->responseFilterConfig['hide'])) {
                    if (in_array($kv, $this->responseFilterConfig['hide'])) continue;
                }

                if (!empty($this->responseFilterConfig['decode'])) {

                    if (in_array($kv, $this->responseFilterConfig['decode'])) {
                        if (!empty($v) && Str::isJson($v)) {
                            $nv[$kv] = json_decode($v);

                            if (!empty($this->responseFilterConfig['decode_child'])) {
                                foreach ($this->responseFilterConfig['decode_child'] as $kdc => $vdc) {
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

                if (!empty($this->responseFilterConfig['decode_array'])) {
                    if (in_array($kv, $this->responseFilterConfig['decode_array'])) {
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

                if (is_null($v) || $v === NULL) {
                    $v = '';
                }

                $nv[$kv] = $v;
            }

            if (!empty($this->responseFilterConfig['add_field'])) {
                foreach ($this->responseFilterConfig['add_field'] as $k => $v) {
                    $nv[$k] = $v;
                }
            }

            if (!empty($this->responseFilterConfig['hook'])) {
                foreach ($this->responseFilterConfig['hook'] as $k => $v) {
                    if (is_callable($this->responseFilterConfig['hook'][$k])) {
                        $nv = call_user_func($this->responseFilterConfig['hook'][$k], $nv);
                    }
                }
            }
        }

        return $nv;
    }

    public function defaultHeaders()
    {
        $this->header[] = "Content-Type: application/json";
        $this->header[] = "HTTP/1.1 " . $this->responseData['status'] . " " . $this->responseData['message'];
    }

    public function getHeaders()
    {
        foreach ($this->header as $header) {
            header($header);
        }
    }

    public function getHeaderArray()
    {
        return $this->header;
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

    public function sendJson()
    {
        $this->defaultHeaders();
        $this->getHeaders();

        echo json_encode($this->responseData);
        exit();
    }

    public function send($type = 'json')
    {
        if ($type == 'json') {
            $this->sendJson();
        }
    }
}
