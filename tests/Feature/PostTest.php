<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Database\Seeders\PostSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(UserSeeder::class);
        $this->seed(PostSeeder::class);
    }


    public function testPostCreate(): void
    {
        $user = User::where('email', 'test@example.com')->first();
        $this->actingAs($user);

        $postData = [
            'title' => 'Judul Postingan',
            'content' => 'Isi konten dari postingan.',
            'is_draft' => false,
            'published_at' => now(),
        ];

        $response = $this->post(route('posts.store'), $postData);

        $this->assertDatabaseHas('posts', [
            'title' => 'Judul Postingan',
            'content' => 'Isi konten dari postingan.',
            'user_id' => $user->id,
        ]);

        $response->assertRedirect(route('home'));
    }

    public function testPostCreateFailValidate(): void
    {
        $user = User::where('email', 'test@example.com')->first();
        $this->actingAs($user);

        $postData = [
            'title' => '',
            'content' => '',
            'is_draft' => '',
            'published_at' => '',
        ];

        $response = $this->post(route('posts.store'), $postData);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['title', 'content']);
    }

    public function testPostUpdate(): void
    {
        $user = User::where('email', 'test@example.com')->first();
        $post =  Post::first();
        $this->actingAs($user);

        $postData = [
            'title' => 'Judul Postingan',
            'content' => 'Isi konten dari postingan.',
            'is_draft' => false,
            'published_at' => now(),
        ];

        $response = $this->patch(route('posts.update', ['id' => encrypt($post->id)]), $postData);

        $response->assertRedirect(route('home'));
    }
    public function testPostUpdateFailValidate(): void
    {
        $user = User::where('email', 'test@example.com')->first();
        $post =  Post::first();
        $this->actingAs($user);

        $postData = [
            'title' => '',
            'content' => '',
            'is_draft' => '',
            'published_at' => '',
        ];

        $response = $this->patch(route('posts.update', ['id' => encrypt($post->id)]), $postData);
        $response->assertStatus(302);
        $response->assertSessionHasErrors(['title', 'content']);
    }
    public function testPostDelete(): void
    {
        $user = User::where('email', 'test@example.com')->first();
        $post =  Post::first();
        $this->actingAs($user);

        $response = $this->delete(route('posts.destroy', ['id' => encrypt($post->id)]));
        $response->assertRedirect(route('home'));

    }
}
