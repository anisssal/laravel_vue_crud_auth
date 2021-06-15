<?php


namespace App\Http\Controllers\API;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;
use Illuminate\Http\Response;


class BaseController extends Controller
{
    /**
     * success response method.
     *
     */
    public function sendSuccessResponse($result, $message)
    {
        $response = [
            'success' => true,
            'data'    => $result,
            'message' => $message,
        ];


        return response()->json($response, Response::HTTP_OK);
    }


    /**
     * return error response.
     *
     */
    public function sendErrorResponse($error, $errorMessages = [], $code = Response::HTTP_NOT_FOUND)
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];


        if(!empty($errorMessages)){
            $response['data'] = $errorMessages;
        }


        return response()->json($response, $code);
    }

    public function sendErrorValidationResponse($error, $errorMessages = [])
    {

        return $this->sendErrorResponse($error , $errorMessages ,Response::HTTP_UNPROCESSABLE_ENTITY);
    }


}
