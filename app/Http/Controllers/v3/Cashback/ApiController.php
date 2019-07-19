<?php

namespace indiashopps\Http\Controllers\v3\Cashback;

use Illuminate\Http\Request;
use indiashopps\Http\Controllers\v3\BaseController;
use indiashopps\User;

class ApiController extends BaseController
{
    public function getUser(Request $request, $user_id)
    {
        if (empty($user_id)) {
            return $this->jsonResponse('Invalid User ID', 404);
        }

        $user = User::select([
            "name",
            'email',
            'gender',
            'company_id',
            'join_date',
            'pimage',
            'city'
        ])->whereId($user_id)->first();

        if (is_null($user)) {
            return $this->jsonResponse('Invalid User ID', 404);
        }

        return $this->jsonResponse($user->toArray());
    }

    private function jsonResponse($message = [], $status = 200)
    {
        $message = (is_array($message)) ? $message : (array)$message;

        return response()->json($message, $status);
    }
}
