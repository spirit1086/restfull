<?php

namespace Spirit1086\Restfull\Modules\Auth\Repositories;

use Spirit1086\Restfull\Modules\Auth\Models\User;
use Illuminate\Support\Str;

class GenerateToken
{
   protected $user,$auth_token;

    /**
     * @param string $auth_token
     */
   public function __construct(string $auth_token)
   {
      $this->user = new User();
      $this->auth_token = $auth_token;
   }

    /**
     * @return false|\stdClass
     */
   public function access()
   {
       $is_have_user = $this->user->getItem('auth_token',$this->auth_token);
       if($is_have_user)
       {
               $bearer_token = Str::random(80);
               $expires_in = '86400';
               $expires_date = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . '+ 1 days'));
               $user = $this->createUserBearerToken($bearer_token,$expires_date);

               if($user)
               {
                   $response = new \stdClass();
                   $response->bearer_token = $bearer_token;
                   $response->token_type = 'bearer';
                   $response->expires_in = $expires_in;
                   return $response;
               }
       }
       return false;
   }

    /**
     * @param string $bearer_token
     * @param string $expires_date
     * @param int $expires_in
     * @return object|null
     */
   private function createUserBearerToken(string $bearer_token,string $expires_date,int $expires_in=86400):?object
   {
       $where_condition = ['auth_token' => $this->auth_token];
       $values = [
           'api_token' => $bearer_token,
           'expires_in' => $expires_in,
           'access_token_expires_date' => $expires_date
       ];

       return $this->user->setData($where_condition,$values);
   }

}
