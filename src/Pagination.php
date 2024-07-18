<?php

namespace Saidqb\CorePhp;

/**
 * Class Pagination
 * @package Saidqb\CorePhp
 * usage:
 * ```php
 * $pagination = new Pagination();
 * $pagination->totalItems(100)->itemPerPage(10)->currentPage(1)->get();
 * or
 * $pagination = Pagination::make()->totalItems(100)->itemPerPage(10)->currentPage(1)->get();
 * ```
 */
class Pagination
{
    private $totalItems = 0;
    private $itemsPerPage = 10;
    private $currentPage = 1;
    private $totalPages = 0;
    private $noLimit = 999999999;

    /**
     * @return Pagination
     */
    public static function make()
    {
        return new self();
    }

    public function totalItems(int $totalItems)
    {
        $this->totalItems = $totalItems;
        return $this;
    }

    public function itemPerPage(int $itemsPerPage)
    {
        $this->itemsPerPage = $itemsPerPage;
        return $this;
    }

    public function currentPage(int $currentPage)
    {
        $this->currentPage = $currentPage;
        return $this;
    }

    public function showAll()
    {
        $this->itemsPerPage = $this->noLimit;
        return $this;
    }

    public function getNoLimit(): int
    {
        return $this->noLimit;
    }

    public function getTotalItems(): int
    {
        return $this->totalItems;
    }

    public function getItemsPerPage(): int
    {
        return $this->itemsPerPage;
    }

    public function getCurrentPage(): int
    {
        return $this->currentPage;
    }

    public function getTotalPages(): int
    {
        $this->totalPages = $this->calculateTotalPages();
        return $this->totalPages;
    }

    private function calculateTotalPages(): int
    {
        return (int) ceil($this->totalItems / $this->itemsPerPage);
    }

    /**
     * @return array
     */
    public function get(): array
    {
        $total = $this->totalItems;
        $pagenum = $this->currentPage;
        $limit = $this->itemsPerPage;

        $total_page = ceil($total / $limit);

        $prev = $pagenum - 1;
        if ($prev < 1) {
            $prev = 0;
        }

        $next = $pagenum + 1;
        if ($next > $total_page) {
            $next = 0;
        }

        $from = 1;
        $to = $total_page;

        $to_page = $pagenum - 2;
        if ($to_page > 0) {
            $from = $to_page;
        }

        if ($total_page >= 5) {
            if ($total_page > 0) {
                $to = 5 + $to_page;
                if ($to > $total_page) {
                    $to = $total_page;
                }
            } else {
                $to = 5;
            }
        }

        #looping kotak pagination
        $firstpage_istrue = false;
        $lastpage_istrue = false;
        $detail = [];
        if ($total_page <= 1) {
            $detail = [];
        } else {
            for ($i = $from; $i <= $to; $i++) {
                $detail[] = $i;
            }
            if ($from != 1) {
                $firstpage_istrue = true;
            }
            if ($to != $total_page) {
                $lastpage_istrue = true;
            }
        }

        $total_display = 0;
        if ($pagenum < $total_page) {
            $total_display = $limit;
        }
        if ($pagenum == $total_page) {
            if (($total % $limit) != 0) {
                $total_display = $total % $limit;
            } else {
                $total_display = $limit;
            }
        }
        if ($limit == $this->noLimit) {
            $limit = $total;
        }
        $pagination = array(
            'total_data' => $total,
            'total_page' => $total_page,
            'total_display' => $total_display,
            'first_page' => $firstpage_istrue,
            'last_page' => $lastpage_istrue,
            'prev' => $prev,
            'current' => $pagenum,
            'limit' => (int)$limit,
            'next' => $next,
            'detail' => $detail
        );

        return $pagination;
    }
}
