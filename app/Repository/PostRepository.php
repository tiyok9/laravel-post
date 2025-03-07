<?php

namespace App\Repository;

use App\Models\Post;

class PostRepository
{
    protected $post;

    /**
     * @param $post
     */
    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    public function store(mixed $data)
    {
        return $this->post->create($data);
    }

    public function home($user)
    {
        return $this->post->where('user_id',$user)->with('user')->orderByDesc('updated_at')->paginate(10);
    }

    public function show($post)
    {
        return $this->post->where('slug',$post)->with('user')->firstOrFail();
    }

    public function index()
    {
        return $this->post->where('is_draft',false)->where('published_at', '<=', now())->orderByDesc('published_at')->with('user')->paginate(10);
    }

    public function update(mixed $data, $id)
    {
        $id = decrypt($id);
        return $this->post->where('id',$id)->update($data);
    }

    public function destroy($id)
    {
        $id = decrypt($id);
        return $this->post->where('id',$id)->delete();
    }
}
