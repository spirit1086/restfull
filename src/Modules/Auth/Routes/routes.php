<?php

Route::group( ['namespace' => 'Spirit1086\Restfull\Modules\Auth\Controllers','prefix'=> 'api','as' => 'api.','middleware' => ['api']],function()
   {
      Route::post('/user/token', ['uses' => 'UserController@getUserToken','as'=>'user_auth']);
   });
