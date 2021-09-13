<?php

namespace App\Modules\Post\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable=[
        'title',
        'description',
        'active'
    ];

    /**
     * @param int $id
     * @param array $data
     * @return object
     */
    public static function updateItem(int $id,array $data):?object
    {
        Post::where('id','=',$id)->update($data);
        return static::getItem($id);
    }

    /**
     * @param int $id
     * @return object
     */
    public static function getItem(int $id):?object
    {
        return Post::find($id);
    }


    public static function deleteItem(int $id)
    {
       Post::where('id','=',$id)->delete();
    }
}
