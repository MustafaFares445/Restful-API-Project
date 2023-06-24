<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\ApiController;
use App\Models\Category;

class CategoryTransactionController extends ApiController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index(Category $category)
    {
        $transactions = $category->products()
            ->whereHas('transactions')
            ->get()
            ->pluck('transactions')
            ->unique('id')->values();

        return $this->showAll($transactions);
    }
}
