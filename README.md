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


## COFFEE FOR BEST PERFORMANCE

**[COFFEE HERE](https://saidqb.github.io/coffee)** for more inovation

OR

<a href="https://trakteer.id/saidqb/tip" target="_blank"><img id="wse-buttons-preview" src="https://cdn.trakteer.id/images/embed/trbtn-red-1.png?date=18-11-2023" height="40" style="border:0px;height:40px;" alt="Trakteer Saya"></a>
