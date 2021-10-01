<?php

namespace App\Http\Controllers;

use App\Post;
use App\PostMedia;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PostController extends Controller
{

    public function __construct()
    {
        return $this->middleware('auth');
    }

    public function create()
    {
        return view('post');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate(
            [
                'title' => 'required|min:2|max:255',
                'body' => 'required|min:2|max:255',
                'post_media' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ],
            [
                'title.required' => 'Please enter post title',
                'body.required' => 'Please enter post description',
            ]
        );
        $post =  new Post;
        $post->title = $request->get('title');
        $post->body = $request->get('body');
        $post->created_at = Carbon::now();

        if ($post->save()) {
            // Post Media save
            $post_media = $request->file('post_media');
            if ($post_media) {
                foreach ($post_media as $multiImg) {
                    $name_gen = hexdec(uniqid());
                    $img_ext = strtolower($multiImg->getClientOriginalExtension());
                    $img_name = $name_gen . '.' . $img_ext;
                    $up_location = 'image/posts/';
                    $last_img = $up_location . $img_name;
                    $multiImg->move($up_location, $img_name);

                    $postMedia = new PostMedia();
                    $postMedia->post_id = $post->id;
                    $postMedia->media_name = $last_img;
                    $postMedia->created_at = Carbon::now();
                    $postMedia->save();
                }
            }
            return Redirect()->route('posts')->with('success', 'Post inserted successfully.');
        } else {
            return Redirect()->back()->with('error', 'Somthing went to wrong!');
        }
    }

    public function index()
    {
        $posts = Post::select('id', 'title')->get();

        return view('index', compact('posts'));
    }

    public function show($id)
    {
        $post = Post::find($id);
        return view('show', compact('post'));
    }

    public function edit($id)
    {
        $post = Post::find($id);
        return view('post', compact('post'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate(
            [
                'title' => 'required|min:2|max:255',
                'body' => 'required|min:2|max:255',
                'post_media' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ],
            [
                'title.required' => 'Please enter post title',
                'body.required' => 'Please enter post description',
            ]
        );

        $old_image = $request->old_image;
        $post_media = $request->file('post_media');

        if ($post_media) {

            $name_gen = hexdec(uniqid());
            $img_ext = strtolower($post_media->getClientOriginalExtension());
            $img_name = $name_gen . '.' . $img_ext;
            $up_location = 'image/posts/';
            $last_img = $up_location . $img_name;
            $post_media->move($up_location, $img_name);

            unlink($old_image);
            $mediaModel = PostMedia::find($id);
            // $model->brand_name = $request->brand_name;
            $mediaModel->media_name = $last_img;
            $mediaModel->updated_at = Carbon::now();
            $mediaModel->save();
        } else {
            $post =  Post::find($id);
            $post->title = $request->get('title');
            $post->body = $request->get('body');
            $post->created_at = Carbon::now();
        }
        if ($post->save()) {
            return Redirect()->route('posts')->with('success', 'Post inserted successfully.');
        } else {
            return Redirect()->back()->with('error', 'Somthing went to wrong!');
        }
    }
}
