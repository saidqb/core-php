<?php

namespace Saidqb\CorePhp;

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

    public $filterConfig = [];

    private $responseData = [];
    private $status = ResponseCode::HTTP_OK;
    private $message = ResponseCode::HTTP_OK_MESSAGE;
    private $errorCode = 0;

    public $header = [];

    static function make()
    {
        return new self();
    }

    /**
     * hide fields, not show in response
     */
    public function hide($arr = [])
    {
        $this->filterConfig['hide'] = $arr;
        return $this;
    }

    /**
     * decode fields, decode json string to array, with default empty object
     */
    public function decode($arr = [])
    {
        $this->filterConfig['decode'] = $arr;
        return $this;
    }

    /**
     * decode child fields, decode json string to array
     */
    public function decodeChild($arr = [])
    {
        $this->filterConfig['decode_child'] = $arr;
        return $this;
    }

    /**
     * decode array fields, decode json string to array, with default empty array
     */
    public function decodeArray($arr = [])
    {
        $this->filterConfig['decode_array'] = $arr;
        return $this;
    }

    /**
     * add fields to response, multiple array fields
     */
    public function addFields($arr = [])
    {
        foreach ($arr as $k => $v) {
            $this->filterConfig['add_field'][$k] = $v;
        }
        return $this;
    }

    /**
     * add field to response, single field
     */
    public function addField($field, $value = '')
    {
        $this->filterConfig['add_field'][$field] = $value;
        return $this;
    }

    /**
     * hook fields, callback function
     */
    public function hook($name, $callback)
    {
        $this->filterConfig['hook'][$name] = $callback;
        return $this;
    }

    /**
     * response config, default config
     */
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
        $this->filterConfig = $rArr;
    }

    public function responseConfigAdd($config, $value = [])
    {
        $this->filterConfig[$config] = $value;
    }

    /**
     * item builder, filter response fields
     */
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

    /**
     * filter response fields, based on config, manipulate the response data
     */
    public function filterResponseField($arr)
    {
        $nv = [];
        if (is_string($arr)) {
            return $nv;
        }

        if (!empty($arr)) {
            foreach ($arr as $kv => $v) {

                if (!empty($this->filterConfig['hide'])) {
                    if (in_array($kv, $this->filterConfig['hide'])) continue;
                }

                if (!empty($this->filterConfig['decode'])) {

                    if (in_array($kv, $this->filterConfig['decode'])) {
                        if (!empty($v) && Str::isJson($v)) {
                            $nv[$kv] = json_decode($v);

                            if (!empty($this->filterConfig['decode_child'])) {
                                foreach ($this->filterConfig['decode_child'] as $kdc => $vdc) {
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

                if (!empty($this->filterConfig['decode_array'])) {
                    if (in_array($kv, $this->filterConfig['decode_array'])) {
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

            if (!empty($this->filterConfig['add_field'])) {
                foreach ($this->filterConfig['add_field'] as $k => $v) {
                    $nv[$k] = $v;
                }
            }

            if (!empty($this->filterConfig['hook'])) {
                foreach ($this->filterConfig['hook'] as $k => $v) {
                    if (is_callable($this->filterConfig['hook'][$k])) {
                        $nv = call_user_func($this->filterConfig['hook'][$k], $nv);
                    }
                }
            }
        }

        return $nv;
    }

    public function httpHeader(){
        $this->header[] = "HTTP/1.1 " . $this->responseData['status'] . " " . $this->responseData['message'];
    }
    public function defaultHeader()
    {
        $this->header[] = "Content-Type: application/json";
    }

    public function getHeaderArray()
    {
        return $this->header;
    }

    public function getHeaders()
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

    /**
     * Default response
     * set default response data, if no data is passed
     * @return array
     */
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

    /**
     * Response data
     * return array data, without response data wrapper
     */
    public function toArray()
    {
        return $this->responseData;
    }

    /**
     * Send response
     * get the response data and send it to the client, with headers and status code
     */
    public function send()
    {

        $header = $this->getHeaderArray();

        $this->httpHeader();

        if (empty($header)) {
            $this->defaultHeader();
        }

        $this->getHeaders();

        echo json_encode($this->responseData);
        exit();
    }
}
