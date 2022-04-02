<?php

namespace App\Http\Controllers\Api;

use App\Helper\ResponseBuilder;
use App\Http\Controllers\Controller;
use App\Http\Requests\AssignPromotionRequest;
use App\Models\User;
use App\Services\UserService;
use Exception;
use Illuminate\Http\JsonResponse;

class AssignPromotionController extends Controller
{
    private $user;
    public function __construct(private UserService $userService)
    {
        $this->user = User::find(1);
    }

    public function assignPromotion(AssignPromotionRequest $assignPromotionRequest): JsonResponse
    {
        try{
            $code = $assignPromotionRequest->code;
            $this->userService->setUser($this->user);
            $response = $this->userService->assignPromotion($code);
            if ($response)
                return ResponseBuilder::success();
            return ResponseBuilder::error(message:'The code has already used');
        }catch (Exception $exception){
            return ResponseBuilder::error(message:$exception->getMessage());
        }
    }
}
