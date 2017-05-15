<?php

namespace Corp\Http\Controllers;

use Corp\Article;
use Corp\Comment;
use Gravatar;
use Illuminate\Http\Request;
use Validator;
use Auth;
use Response;

class CommentController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //return Response::json(['success' => true, 'data' => 'got it']);
        $data = $request->except('_token', 'comment_post_ID', 'comment_parent');
        $data['article_id'] = $request->input('comment_post_ID');
        $data['parent_id'] = $request->input('comment_parent');

        $validator = Validator::make($data, [
            'article_id' => 'integer|required',
            'parent_id' => 'integer',
            'text' => 'string|required',
        ]);

        $validator->sometimes('name', 'required|max:255', function ($input) {
            return !Auth::check();
        });
        $validator->sometimes('email', 'required|max:255|email', function ($input) {
            return !Auth::check();
        });

        if ($validator->fails()) {
            return Response::json(['error' => $validator->errors()->all()]);
        }

        $user = Auth::user();

        $comment = new Comment($data);

        if ($user) {
            $comment->user_id = $user->id;
            $data['user_id'] = $user->id;
        }

        $post = Article::find($data['article_id']);
        $post->comments()->save($comment);

        $comment->load('user');
        $data['id'] = $comment->id;

        $data['email'] = (!empty($data['email'])) ? $data['email'] : $comment->user->email;
        $data['name'] = (!empty($data['name'])) ? $data['name'] : $comment->user->name;
        $data['created_at'] = $comment->created_at;
        $data['hash'] = Gravatar::get($data['email'], ['size' => 75]);
        
        
        $view_comment = view(config('settings.theme') . '.comment_one', compact('data'))->render();
        return Response::json([
            'success' => true,
            'html' => $view_comment,
            'data' => $data
        ]);

    }

}