<?php

namespace App\Http\Controllers\Api;

use App\Models\Post;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Resources\PostResource;
use App\Http\Resources\PostCollection;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        $posts = Post::latest()->paginate(5);
    
        return new PostCollection($posts);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'age' => 'required',
        ]);
    
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
    
        $post = Post::create([
            'name' => $request->name,
            'age' => $request->age,
        ]);
    
        return response()->json([
            'success' => true,
            'message' => 'Data Post Berhasil Ditambahkan!',
            'data' => new PostResource($post),
        ]);
    }

    public function show($id)
        {
            $post = Post::find($id);

            if (!$post) {
                return response()->json([
                    'success' => false,
                    'message' => 'Post not found!',
                ], 404);
            }
        
            return response()->json([
                'success' => true,
                'message' => 'Detail Data Post!',
                'data' => new PostResource($post),
            ]);
            
        }
        public function update(Request $request, $id)
        {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'age' => 'required|integer',
            ]);
        
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation error',
                    'errors' => $validator->errors(),
                ], 422);
            }
            $post = Post::find($id);
        
            if (!$post) {
                return response()->json([
                    'success' => false,
                    'message' => 'Post not found',
                ], 404);
            }
        
            // Update data
            $post->update([
                'name' => $request->name,
                'age' => $request->age,
            ]);
            return response()->json([
                'success' => true,
                'message' => 'Data Post Berhasil Diubah!',
                'data' => new PostResource($post),
            ]);
        }
    public function destroy($id)
    {
        $post = Post::find($id);
        if (!$post) {
            return response()->json([
                'success' => false,
                'message' => 'Post not found!',
            ], 404);
        }
        $post->delete();
        return response()->json([
            'success' => true,
            'message' => 'Data Post Berhasil Dihapus!',
        ]);
    }

}