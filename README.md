# core-php

A dependency for php project

## Description

progress build...

## Requirments

PHP >= 8.1

## Installation

```
composer require saidqb/core-php
```

## Package include

- **Array Collection**  [doctrine/collection](https://www.doctrine-project.org/projects/collections.html)
- **String Manipulation**  [str/str](https://github.com/fe3dback/str?tab=readme-ov-file#functions-index)
- **Generator String**  [phlak/strgen](https://github.com/PHLAK/StrGen)

### Arr

```php
use Saidqb\CorePhp\Lib\Arr;

$arr = [1, 2, 3];
Arr::collection($arr)->filter(function($element) {
    return $element > 1;
}); // [2, 3]

Arr::collection($arr)->contains(1); // true

Arr::collection($arr)->filter(function($element) {
    return $element > 1;
}); // [2, 3]
```

Detail [Documentation](https://www.doctrine-project.org/projects/doctrine-collections/en/stable/index.html#collection-methods)

### Str

```php
use Saidqb\CorePhp\Lib\Str;

$str = 'string';
Str::make($str)->startsWith($substring);
Str::make($str)->endsWith($substring);
```
Detail [Documentation](https://github.com/fe3dback/str?tab=readme-ov-file#functions-index)


### Generate

```php
use Saidqb\CorePhp\Lib\Generate;


Generate::str()->lowerAlpha($length);
Generate::str()->upperAlpha($length);
Generate::str()->mixedAlpha($length);
Generate::str()->numeric($length);
Generate::str()->alphaNumeric($length);
Generate::str()->special($length);
Generate::str()->all($length);
Generate::str()->custom($length, $charset);
```

### Pagination

```php
use Saidqb\CorePhp\Pagination;

$pagination = Pagination::make()->totalItems(100)->itemPerPage(10)->currentPage(1)->get();

```

### Response

```php
use Saidqb\CorePhp\Response;

Response::make()->response([], ResponseCode::HTTP_OK, ResponseCode::HTTP_OK_MESSAGE, 0)->send();

// list item
Response::make()->response(['items' => $items, 'pagination' => $pagination])->send();

// single item
Response::make()->response(['item' => $item])->send();
```

**used in controller**

BaseController
```php
use Saidqb\CorePhp\Response;
use Saidqb\CorePhp\ResponseCode;

public $res;

public function __construct()
{
    $this->initResponse();
}

public function initResponse()
{
    $this->res = new Response();
    return $this->res;
}

public function response($data, $code = ResponseCode::HTTP_OK, $message = ResponseCode::HTTP_OK_MESSAGE, $errorCode = 0)
{
    $this->res->response($data, $code, $message, $errorCode)->send();
}
```

Extends to BaseController
```php
use Saidqb\CorePhp\ResponseCode;

public function __construct()
{
    parent::__construct();

    $this->initResponse()->hide(['password']);

}

public function index()
{
    $this->response($data, ResponseCode::HTTP_OK);
}
```

Avilable Manipulate data:
```php
->hide(['password'])
->decode(['extra'])
->decodeChild(['extra.user'])
->decodeArray(['extra_list'])
->addFields(['field1' => '1', 'field2' => '2'])
->addField('field1', '1')
->hook('item', function($data){ return $data})
```





## COFFEE FOR BEST PERFORMANCE

**[COFFEE HERE](https://saidqb.github.io/coffee)** for more inovation

OR

<a href="https://trakteer.id/saidqb/tip" target="_blank"><img id="wse-buttons-preview" src="https://cdn.trakteer.id/images/embed/trbtn-red-1.png?date=18-11-2023" height="40" style="border:0px;height:40px;" alt="Trakteer Saya"></a>
