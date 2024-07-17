<?php
namespace Saidqb\CorePhp\Utils;

class Pagination
{
    private $totalItems;
    private $itemsPerPage;
    private $currentPage;
    private $totalPages;
    private $noLimit = 999999999;

    public function __construct(int $totalItems,  int $currentPage, int $itemsPerPage)
    {
        $this->totalItems = $totalItems;
        $this->itemsPerPage = $itemsPerPage;
        $this->currentPage = $currentPage;
        $this->totalPages = $this->calculateTotalPages();
    }

    public function setNoLimit($noLimit)
    {
        $this->noLimit = $noLimit;
        return $this;
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
        return $this->totalPages;
    }

    private function calculateTotalPages(): int
    {
        return (int) ceil($this->totalItems / $this->itemsPerPage);
    }

    public function get() : array
    {
        $total = $this->totalItems;
        $pagenum = $this->currentPage;
        $limit = $this->itemsPerPage;

        $total_page = ceil($total / $limit);

        //------------- Prev page
        $prev = $pagenum - 1;
        if ($prev < 1) {
            $prev = 0;
        }
        //------------------------

        //------------- Next page
        $next = $pagenum + 1;
        if ($next > $total_page) {
            $next = 0;
        }
        //----------------------

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
