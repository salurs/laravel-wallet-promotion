<?php

namespace App\Services;

use App\Helper\ResponseBuilder;
use App\Models\PromotionCode;
use Illuminate\Http\JsonResponse;

class PromotionCodeService
{
    public function __construct(public PromotionCode $promotionCode)
    {
    }

    public function allValidCodes()
    {
        return ResponseBuilder::success($this->promotionCode::query()->isValidCode()->get());
    }

    public function allCodes()
    {
        return ResponseBuilder::success($this->promotionCode::query()->get());
    }

    public function add(array $data): JsonResponse
    {
        if (!isset($data['code']))
            $data['code'] = $this->generatePromotionCode();
        $isCreated =  $this->promotionCode::create($data);
        if($isCreated){
            return ResponseBuilder::success($isCreated);
        }
        return ResponseBuilder::error(message: 'Promotion Code has not created');
    }

    public function getPromotionCodeById($id)
    {
        $result = $this->promotionCode::query()->with('users.wallet')->whereId($id)->isValidCode()->first();
        return ResponseBuilder::success($result);
    }

    public function generatePromotionCode(int $digit = 12): string
    {
        $chars = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $code = substr(str_shuffle($chars), 0, $digit);
        if ($this->checkCode($code)) {
            $this->generatePromotionCode($digit);
        }
        return $code;
    }

    public function checkCode($code): bool
    {
        return $this->promotionCode::query()->whereCode($code)->exists();
    }

    public function getValidPromotionByCode(string $code): PromotionCode|null
    {
        return $this->promotionCode::query()->whereCode($code)->isValidCode()->first();
    }

    public function decreaseQuota($code): bool
    {
        $promotionCode = $this->getValidPromotionByCode($code);
        $promotionCode->decrement('quota');
        return $promotionCode->save();
    }

    public function getAmountById($id): float
    {
        $promotion = $this->promotionCode::query()->find($id);
        return $promotion->amount;
    }


}
