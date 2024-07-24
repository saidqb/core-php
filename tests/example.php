<?php
require_once '../vendor/autoload.php';

use Saidqb\CorePhp\Lib\Str;
use Saidqb\CorePhp\Lib\Generate;
use Saidqb\CorePhp\Response;

$res = [];

$cls = new Str();
$str = $cls->make('Hello World')->append('!')->prepend('Hello ');

$res[] = $str;
$res[] = Generate::token();

echo '<pre>';
print_r($res);
die;

Response::make()
->addFields($res)
->addFields([
    'vv' => 'Hello World',
    'vv2' => 'Hello World',
])
->addFields([
    'cc' => 'Hello World',
    'cc2' => 'Hello World',
])
->hook('test', function ($data) {
    if(isset($data['test']) == 'Hello World') {
        $data['test'] = 'Hello World 2000';
    }
    return $data;
})
->response([
    'test' => 'Hello World',
    'test2' => 'Hello World',
])
->send();

