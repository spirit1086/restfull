<?php
use Illuminate\Support\Facades\Route;
Route::group(['namespace' => 'App\Modules\Post\Controllers','prefix'=> 'api','as' => 'api.','middleware' => ['api']],
    function()
    {
        Route::group( ['prefix'=> '/posts','as' => 'posts.','middleware' => ['auth:api','token.expires']],function()
        {
            Route::get('/', ['uses' => 'PostController@collection', 'as' => 'collection']);
            Route::get('/{id}', ['uses' => 'PostController@item', 'as' => 'item']);
            Route::post('/', ['uses' => 'PostController@create', 'as' => 'create']);
            Route::match(['put','patch'],'/{id}', ['uses' => 'PostController@update', 'as' => 'update']);
            Route::delete('/{id}', ['uses' => 'PostController@delete', 'as' => 'delete']);
        });
    }
);
