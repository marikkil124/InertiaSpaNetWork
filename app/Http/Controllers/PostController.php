<?php

namespace App\Http\Controllers;

use App\Http\Requests\Post\CommentRequest;
use App\Http\Requests\Post\RepostRequest;
use App\Http\Requests\Post\StoreRequest;
use App\Http\Resources\Post\PostCommentResource;
use App\Http\Resources\Post\PostRepostResource;
use App\Http\Resources\Post\PostResource;
use App\Models\Comment;
use App\Models\LikedPost;
use App\Models\Post;
use App\Models\PostImage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::where('user_id', auth()->id())->latest()->get();
        $Likes = LikedPost::where('user_id', auth()->id())->get('post_id')->pluck('post_id')->toArray();
        foreach ($posts as $post) {

            if (in_array($post->id, $Likes))
                $post->is_liked = true;
        }
        $posts = PostResource::collection($posts);
        return inertia('User/personal',compact('posts') );

    }

    public function store(StoreRequest $request)
    {
        try {
            DB::beginTransaction();
            $data = $request->validated();

            $imageId = $data['image_id'];

            unset($data['image_id']);

            $data['user_id'] = auth()->id();
            $post = Post::create($data);

            if (isset($imageId)) {
                $PI = PostImage::find($imageId);
                $PI->update([
                    'post_id' => $post->id
                ]);

            }
            PostImage::clearStorage();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()]);
        }


// добавлением айди поста к изображению мы указываем на то, что изображения без айди поста нужно очистить из хранилища

    }


    public function toggleLike(Post $post)
    {
        $res = auth()->user()->toggleLikes()->toggle($post->id);
        $data['is_liked'] = count($res['attached']) > 0;
        $data['likes_count'] = $post->likesCount()->count();
        return $data;
    }

    public function repost(RepostRequest $request, Post $post)
    {
        $data = $request->validated();
        $data['reposted_id'] = $post->id;
        $data['user_id'] = auth()->id();
        Post::create($data);
    }

    public function comment(CommentRequest $request, Post $post)
    {
        $data = $request->validated();
        $data['post_id'] = $post->id;
        $data['user_id'] = auth()->id();
        $comments =  Comment::create($data);
        $comments = new PostCommentResource($comments);


    }

    public function getComments(Post $post)

    {
        //$comments = Comment::where('user_id', auth()->id())->where('post_id',$post->id)->get();
        $posts = Post::where('id', $post->id)->get();
        $comments = $post->comments()->get();

        $data = [
            'post'=>  PostResource::collection($posts)->resolve(),
            'comments' =>  PostCommentResource::collection($comments),

        ];

        return inertia('Post/PostWithComments',compact('data') );
    }

    public function deleteComment(Comment $comment)
    {
        $comment->delete();
        return response($comment);
    }

    public function deletePost(Post $post)
    {

        try {
            DB::beginTransaction();
            $comments = Comment::where('post_id', $post->id)->get();
            //удаление комментария связанное с постом
            foreach ($comments as $comment) {
                $comment->delete();
            }
            //удаление изображения свзанное с постом
            $images = PostImage::where('post_id', $post->id)->get();

            foreach ($images as $image) {
                if (isset($image))
                    $image->delete();
            }
            $post->delete();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()]);
        }


    }
}
