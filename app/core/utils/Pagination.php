<?php

namespace app\core\utils;

class PaginationHelper
{
    private $totalItems;
    private $itemsPerPage;
    private $currentPage;

    public function __construct($totalItems, $itemsPerPage, $currentPage)
    {
        $this->totalItems = $totalItems;
        $this->itemsPerPage = $itemsPerPage;
        $this->currentPage = $currentPage;
    }

    public function getTotalPages()
    {
        return ceil($this->totalItems / $this->itemsPerPage);
    }

    public function getOffset()
    {
        return ($this->currentPage - 1) * $this->itemsPerPage;
    }

    public function getCurrentPage()
    {
        return $this->currentPage;
    }

    public function hasPreviousPage()
    {
        return $this->currentPage > 1;
    }

    public function getPreviousPage()
    {
        if ($this->hasPreviousPage()) {
            return $this->currentPage - 1;
        }
        return false;
    }

    public function hasNextPage()
    {
        return $this->currentPage < $this->getTotalPages();
    }

    public function getNextPage()
    {
        if ($this->hasNextPage()) {
            return $this->currentPage + 1;
        }
        return false;
    }
}

// // Define the total number of items and items per page
// $totalItems = 100;
// $itemsPerPage = 10;

// // Get the current page from the request (e.g., from the query parameter)
// $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// // Create a PaginationHelper instance
// $pagination = new PaginationHelper($totalItems, $itemsPerPage, $currentPage);

// // You can then use the methods to generate pagination links or to calculate the offset for database queries
