<?php

namespace App\Services;

use App\Models\Wallet;

class WalletService
{
    public function __construct(public Wallet $wallet)
    {
    }

    public function getWalletByUserId($user_id)
    {
        return $this->wallet::query()->whereUserId($user_id)->first();
    }


}
