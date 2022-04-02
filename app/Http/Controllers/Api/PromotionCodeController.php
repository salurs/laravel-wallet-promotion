<?php

namespace App\Http\Controllers\Api;

use App\Helper\ResponseBuilder;
use App\Http\Controllers\Controller;
use App\Http\Requests\PromotionCodeRequest;
use App\Services\PromotionCodeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Exception;

class PromotionCodeController extends Controller
{
    public function __construct(private PromotionCodeService $promotionCodeService) {}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->promotionCodeService->allValidCodes();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(PromotionCodeRequest $promotionCodeRequest): JsonResponse
    {

        try{
            $validatedData = $promotionCodeRequest->safe()->only(['amount', 'quota', 'start_date', 'end_date', 'code']);
            return $this->promotionCodeService->add($validatedData);
        }catch (Exception $exception){
            return ResponseBuilder::error(message:$exception->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->promotionCodeService->getPromotionCodeById($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
