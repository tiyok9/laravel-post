<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Database\Seeders\PostSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;

class GetTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(UserSeeder::class);
        $this->seed(PostSeeder::class);
    }

    public function testGetPost(): void
    {
        $response = $this->get('/posts');

        $response->assertStatus(200);
    }

    public function testGetPostCount(): void
    {
        $this->assertDatabaseCount('posts',30);
    }

    public function testGetHome(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function testGetHomeUser(): void
    {
        $postCount = Post::count();

        $this->assertEquals(30, $postCount);
    }

    public function testGetPostBySlug(): void
    {
        $user = User::where('email', 'test@example.com')->first();
        $this->actingAs($user);

        $post = Post::firstOrFail();
        $response = $this->get(route('posts.show', ['post' => $post->slug]));
        $response->assertStatus(200);
    }

    public function testGetPostEdit(): void
    {
        $user = User::where('email', 'test@example.com')->first();
        $this->actingAs($user);

        $post = Post::firstOrFail();
        $response = $this->get(route('posts.edit', ['post' => $post->slug]));
        $response->assertStatus(200);
    }

}
