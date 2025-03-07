<?php

namespace App\Service\ServiceImpl;

use App\Repository\PostRepository;
use App\Service\PostService;
use Exception;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Log;

class PostServiceImpl implements PostService
{
    protected $post;

    /**
     * @param $post
     */
    public function __construct(PostRepository $post)
    {
        $this->post = $post;
    }

    public function store(mixed $data,$user)
    {
        try {
            $data['user_id'] = $user;
            return $this->post->store($data);
        }catch (Exception $exception){
            Log::debug($exception->getMessage());
            return false;
        }
    }

    public function home($user)
    {
        try {
            return $this->post->home($user);
        }catch (Exception $exception){
            Log::debug($exception->getMessage());
            return [];
        }
    }

    public function show($post)
    {
        try {
            return $this->post->show($post);
        }catch (Exception $exception){
            Log::debug($exception->getMessage());
            return [];
        }
    }

    public function index()
    {
        try {
            return $this->post->index();
        }catch (Exception $exception){
            Log::debug($exception->getMessage());
            return [];
        }
    }

    public function update(mixed $data, $id)
    {
        try {
            if (!isset($data['is_draft'])){
                $data['is_draft']=false;
            }
            return $this->post->update($data,$id);
        }catch (Exception $exception){
            Log::debug($exception->getMessage());
            return false;
        }
    }

    public function destroy($id)
    {
        try {
            return $this->post->destroy($id);
        }catch (Exception $exception){
            Log::debug($exception->getMessage());
            return false;
        }
    }
}
