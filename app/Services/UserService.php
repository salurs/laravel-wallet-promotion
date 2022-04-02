<?php

namespace App\Services;

use App\Models\User;

class UserService
{
    public function __construct(public User $user, public PromotionCodeService $codeService, public WalletService $walletService)
    {
    }

    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    public function assignPromotion($code): bool
    {
        $promotionCode = $this->getCode($code);
        if (!is_null($promotionCode)) {
            $hasPromotionCode = $this->user->promotionCodes()->isValidCode()->wherePromotionCodeId($promotionCode->id)->exists();
            if (!$hasPromotionCode) {
                $this->user->promotionCodes()->attach($promotionCode->id);
                $this->codeService->decreaseQuota($promotionCode->code);
                $wallet = $this->walletService->getWalletByUserId($this->user->id);
                $wallet->increment('balance', $this->codeService->getAmountById($promotionCode->id));
                $wallet->updated_at = now();
                $wallet->save();
                return true;
            }
        }
        return false;
    }

    public function getCode($code)
    {
        return $this->codeService->getValidPromotionByCode($code);
    }
}
