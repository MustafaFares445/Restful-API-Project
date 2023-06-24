<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\ApiController;
use App\Models\Category;
use Illuminate\Auth\Access\AuthorizationException;

class CategoryBuyerController extends ApiController
{
    /**
     * @throws AuthorizationException
     */
    public function index(Category $category)
    {
        $this->allowedAdminAction();

        $buyer = $category->products()
            ->whereHas('transactions')
            ->with('transactions.buyer')
            ->get()
            ->pluck('transactions')
            ->collapse()
            ->pluck('buyer')
            ->unique('id')->values();

        return $this->showAll($buyer);
    }
}
