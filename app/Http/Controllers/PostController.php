<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Service\PostService;

class PostController extends Controller
{
    protected $post;

    /**
     * @param $post
     */
    public function __construct(PostService $post)
    {
        $this->post = $post;
    }

    /**
     * Display a listing of the resource.
     */
    public function home()
    {
        $user = auth()->id();
        $data = [];
        if($user){
            $data = $this->post->home($user);
        }
        return view('home',[
            'datas' =>$data
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = $this->post->index();
        return view('posts.index',[
            'datas' =>$data
        ]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('posts.create');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        $data = $request->validated();
        $user = auth()->id();
        $status = $this->post->store($data,$user)
            ? ['status' => 'Success Add post!', 'status_type' => 'success']
            : ['status' => 'Failed Add post!', 'status_type' => 'danger'];

        return redirect()->route('home')
            ->with(['status' => $status['status'], 'status_type' => $status['status_type']]);
    }

    /**
     * Display the specified resource.
     */
    public function show($post)
    {
        $data = $this->post->show($post);
        return view('posts.show',[
            'data' => $data
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($post)
    {
        $data = $this->post->show($post);
        return view('posts.edit',[
            'data' =>$data
        ]);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request,$id)
    {
        $data = $request->validated();
        $status = $this->post->update($data,$id)
        ? ['status' => 'Success Update post!', 'status_type' => 'success']
            : ['status' => 'Failed Update post!', 'status_type' => 'danger'];

        return redirect()->route('home')
            ->with(['status' => $status['status'], 'status_type' => $status['status_type']]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $status = $this->post->destroy($id)
            ? ['status' => 'Success delete post!', 'status_type' => 'success']
            : ['status' => 'Failed delete post!', 'status_type' => 'danger'];

        return redirect()->route('home')
            ->with(['status' => $status['status'], 'status_type' => $status['status_type']]);
    }
}
