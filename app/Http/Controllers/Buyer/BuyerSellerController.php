<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\ApiController;
use App\Models\Buyer;

class BuyerSellerController extends ApiController
{
    public function __construct()
    {
        parent::__construct();

    }
    public function index(Buyer $buyer)
    {
        $this->allowedAdminAction();

        $seller = $buyer->transactions()->with('product.seller')
            ->get()
            ->pluck('product.seller')
            ->unique('id')
            ->values();

        return $this->showAll($seller);
    }
}
