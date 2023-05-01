<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;
/**
 * @OA\Info(title="Testing api", version="1.0")
 */
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;




    /**
     * Format of success json response for all ajax\axios requests
     *
     */
    public function jsonSuccess($msg = '', $data = null): JsonResponse
    {
        $resp = [
            'success' => true,
            'data' => $data,
            'message' => $msg
        ];
        return response()->json($resp);
    }

    /**
     * Format of error json response for all ajax\axios requests
     *
     */
    public function jsonError($msg = 'Server Error', $data = null, $code = 500): JsonResponse
    {
        $res = [
            'success' => false,
            'data' => $data,
            'message' => $msg
        ];
        return response()->json($res, $code);
    }
}
