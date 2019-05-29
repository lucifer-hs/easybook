<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Comment;
use App\Zan;

class PostController extends Controller
{
	//列表
   public function index()
   {
      $posts = Post::orderby('created_at','desc')->withCount('comments','zans')->with('user')->paginate(6);
   	return view('post/index',compact('posts'));
   }

	//详情页面
   public function show(Post $post)
   {
    $post->load('comments');
   	return view('post/show',compact('post'));
   }

	//创建页面
   public function create()
   {
   	return view('post/create');
   }

  //创建逻辑
   public function store(Request $request)
   {
   	// $post = new Post();
    //   $post->title=request('title');
    //   $post->content=request('content');
    //   $post->save();
      $this->validate($request, [
            'title' => 'required|max:255|min:4',
            'content' => 'required|min:100',
        ]);
      $user_id=\Auth::id();
      $params = array_merge(request(['title','content']),compact('user_id'));
      $post=Post::create($params);
      return redirect("/posts");
   }

   //编辑页面
   public function edit(Post $post)
   {
   	return view('post/edit',compact('post'));
   }

	//编辑逻辑
   public function update(Request $request,Post $post)
   {
   	$this->validate($request, [
            'title' => 'required|max:255|min:4',
            'content' => 'required|min:100',
        ]);
    //权限
     $this->authorize('update',$post);
      $post->title=request('title');
      $post->content=request('content');
      $post->save();      
       return redirect("/posts/{$post->id}");
   }   

	//删除页面
   public function delete(Post $post)
   {
     $this->authorize('update', $post);
   	$post->delete();
      return redirect("/posts");
   }

  //图片上传
   public function imageUpload(Request $request)
   {
       $path = $request->file('wangEditorH5File')->storePublicly(md5(time()));
       return asset('storage/'. $path);
      // dd(request()->all());
   }

  //评论
   public function comment(Post $post)
   {
     $this->validate(request(),[
      'content'=>'required|min:3',
     ]);
     $comment =new Comment();
     $comment->user_id = \Auth::id();
     $comment->content = request('content');
     $post->comments()->save($comment);

     return back();
   }

  //点赞
    public function zan(Post $post)
    {
     $param = [
       'user_id'=>\Auth::id(),
       'post_id'=>$post->id,
     ];
      Zan::firstOrCreate($param);
      return back();
    }

  //取消点赞
    public function unzan(Post $post)
    {
      $post->zan(\Auth::id())->delete();
      return back();
    }

  //搜索结果页
    public function search(){

      $this->validate(request(),[
        'query' => 'required'
      ]);
      $query = request('query');
      $posts = \App\Post::search($query)->paginate(2);

      return view('post/search',compact('posts','query'));
    }

}
