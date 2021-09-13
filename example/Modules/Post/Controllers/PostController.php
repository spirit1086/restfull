<?php

namespace App\Modules\Post\Controllers;

use Spirit1086\Restfull\ApiController;
use App\Modules\Post\Models\Post;
use App\Modules\Post\Requests\PostRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\{ResourceCollection,JsonResource};

class PostController extends ApiController
{

    /**
     * @param Request $request
     * @return ResourceCollection
     */
    public function collection(Request $request):ResourceCollection
    {
       $per_page = $request->input('per_page');
       $posts = Post::paginate($per_page);
       return $this->resourceCollection($posts);
    }

    /**
     * @param PostRequest $request
     * @return JsonResource
     */
    public function create(PostRequest $request):JsonResource
    {
        $post = Post::create($request->all());
        return $this->resourceItem($post);
    }

    /**
     * @param int $id
     * @return JsonResource
     */
    public function item(int $id):JsonResource
    {
       $post = Post::getItem($id);
       return $this->resourceItem($post);
    }

    /**
     * @param PostRequest $request
     * @param $id
     * @return JsonResource
     */
    public function update(PostRequest $request,$id):JsonResource
    {
        $post = Post::updateItem($id,$request->all());
        return $this->resourceItem($post);
    }

    /**
     * @param int $id
     * @return JsonResource
     */
    public function delete(int $id):JsonResource
    {
        $post = Post::getItem($id);
        return $this->resourceItem($post);
    }
}
