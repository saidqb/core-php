<?php
namespace Saidqb\CorePhp\Lib;

use Doctrine\Common\Collections\ArrayCollection;

class Arr
{
    private $arr;

    static function collection(array $arr): ArrayCollection
    {
        $collection = new ArrayCollection($arr);
        return $collection;
    }

    public function add($item)
    {
        $this->arr[] = $item;
        return $this;
    }

    public function remove($item)
    {
        $key = array_search($item, $this->arr);
        if ($key !== false) {
            unset($this->arr[$key]);
        }
        return $this;
    }

    public function get(): array
    {
        return $this->arr;
    }

    public function count(): int
    {
        return count($this->arr);
    }

    public function exists($item): bool
    {
        return in_array($item, $this->arr);
    }

    public function first()
    {
        return reset($this->arr);
    }
}
