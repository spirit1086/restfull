<?php

namespace Spirit1086\Restfull\Modules\Auth\Controllers;

use Spirit1086\Restfull\ApiController;
use Illuminate\Http\Request;
use Spirit1086\Restfull\Modules\Auth\Repositories\GenerateToken;

class UserController extends ApiController
{
    private $generateToken;

    /**
     * @param Request $request
     * @param object|null $response
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function getUserToken(Request $request,?object $response=null)
    {
        $auth_token = $request->input('auth_token');
        if($auth_token)
        {
            $this->generateToken = new GenerateToken($auth_token);
            $response = $this->generateToken->access();
        }
        return $this->access($response);
    }

}
