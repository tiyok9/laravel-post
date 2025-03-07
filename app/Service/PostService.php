<?php

namespace App\Service;

interface PostService
{
    public function store(mixed $data,$user);
    public function home($user);
    public function show($post);
    public function index();
    public function update(mixed $data, $id);
    public function destroy($id);
}
