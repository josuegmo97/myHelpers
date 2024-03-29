<?php

namespace Josuegmo\Helpers\Traits;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Validator;

trait ApiResponser{

    private function successResponse($data, $code){
        return response()->json($data, $code);
    }

    protected function errorResponse($message, $code = 422){
        return response()->json(['errors'=>$message, 'code' => $code], $code);
    }

    protected function showAll(Collection $collection, $code = 200){
        return response()->json(['data' => $collection], $code);
    }

    protected function showOne(Model $instance, $code = 200){
        return response()->json(['data' => $instance], $code);
    }

    protected function showMessage($message, $code = 200)
	{
		return $this->successResponse(['data' => $message], $code);
    }

    protected function request_rules($request, $rules, $resp = 422)
    {
        $validator = Validator::make($request->all(),$rules);

        $switch = false;
        $return = '';

        if($validator->fails()){
            $messages=$validator->messages();
            $errors=$messages->all();

            $switch = true;

            $return = response()->json([
            'errors' => $errors,
            'sucess' => false
            ], $resp);
        }

        if($switch == true)
        {
            return $return;
        }else{
            return false;
        }
    }
}

?>