<?php

namespace App\Http\Middleware;

use App\Models\Post;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OwnerPost
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $id = $request->route('id');
        $id = decrypt($id);
        $post = Post::findOrFail($id);
        if ($post->user_id !== auth()->id()) {
            return redirect()->route('home')
                ->with(['status' => 'error', 'status_type' => 'unauthorized']);
        }

        return $next($request);
    }
}
