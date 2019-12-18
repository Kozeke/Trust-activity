<?php namespace App\Modules\Blog\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use App\Modules\Blog\Models\BlogArticles;
use App\Modules\Blog\Models\BlogCategories;
use App\User;

use Validator, Auth, Hash, Session, Storage, Image;

class BlogController extends \App\Modules\Panel\Controllers\AbstractController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        parent::__construct();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        if (Auth::user()->role === 1) {
            return view('Blog::category.index')->with(['categories' => BlogCategories::orderBy('created_at', 'ASC')->get()]);
        } else {
            return redirect('/admin');
        }
    }

    public function create()
    {
        if (Auth::user()->role === 1) {
            return view('Blog::category.add');
        } else {
            return redirect('/admin');
        }
    }

    public function edit($id)
    {
        $article = BlogArticles::find($id);
        return view('Blog::edit')->with(['article' => $article]);
    }

    public function store(Request $request)
    {
        return $this->storeCategory($request);
    }

    public function storeCategory(Request $request)
    {
        $data        = $request->all();
        $data['url'] = ($data['url'] == '' ? str_slug($data['h1'], '-') : $data['url']);
        /*
            check if unique 
        */

        $rules = [
            'name'        => 'required|min:3',
            'title'       => 'required|min:3',
            'h1'          => 'required|min:3',
            'url'         => 'required|min:3',  
            'description' => 'required|min:3'    
        ];
 
        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            return redirect('admin/blog/create')
                        ->withErrors($validator)
                        ->withInput();
        } else {

            $category               = new BlogCategories();
            $category->name         = $data['name'];
            $category->title        = $data['title'];
            $category->h1           = $data['h1'];
            $category->url          = $data['url'];
            $category->description  = $data['description'];         
            $category->icon_url     = (isset($data['icon_url']) ? $data['icon_url'] : '/img/chat.svg');
            $category->status       = 1;                  
            $category->save();

            return redirect('admin/blog');
        }
    }

    public function show($category_id)
    {
        $category = BlogCategories::find($category_id);
        $articles = BlogArticles::where('category_id', $category_id)->get();
 
        if (Auth::user()->role === 1) {
            return view('Blog::article.index')->with(['articles' => $articles, 'category' => $category]);
        } else {
            return redirect('/admin');
        }
    }

    public function createArticle($category_id)
    {
        $category = BlogCategories::find($category_id);
 
        if (Auth::user()->role === 1) {
            return view('Blog::article.add')->with(['category' => $category]);
        } else {
            return redirect('/admin');
        }
    }

    public function storeArticle(Request $request)
    {
        $data = $request->all();
        $data['url'] = ($data['url'] == '' ? str_slug($data['h1'], '-') : $data['url']);
 
        $article = BlogArticles::where('url', $data['url'])->first();
        $rules = [
            'title'       => 'required|min:3',
            'h1'          => 'required|min:3',
            'description' => 'required|min:3',
            'content'     => 'required|min:3',     
            'url'         => 'required|min:3',   
            'category_id' => 'required',  
        ];

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            return redirect('admin/blog/create')
                        ->withErrors($validator)
                        ->withInput();
        } else {

            $article              = new BlogArticles();
            $article->title       = $data['title'];
            $article->h1          = $data['h1'];
            $article->description = $data['description'];
            $article->content     = $data['content'];
            $article->url         = $data['url'];
            $article->conversion  = $data['conversion'];    
            $article->category_id = $data['category_id'];     
            $article->status      = 1;       
            $article->save();

            if(Input::file('image'))
            {
                $filename = 'blog-images/'.md5($article->id).'.'.request()->image->getClientOriginalExtension();
                request()->image->move(public_path('blog-images'), $filename);

                /*$article        = BlogArticles::find($article->id);
                $article->image = $filename;  
                $article->save();  

                $img = Image::make('blog-images/'.md5($article->id).'.'.request()->image->getClientOriginalExtension());
                $img->resize(null, 200, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                $img->save('blog-images/thumb_'.md5($article->id).'.'.request()->image->getClientOriginalExtension());*/


            }
 
            return redirect('admin/blog/'.$data['category_id']);
        }
    }

    public function editArticle($category_id, $article_id)
    {
        if (Auth::user()->role === 1) {
            $article = BlogArticles::find($article_id);
            return view('Blog::article.edit')->with(['article' => $article]);
        } else {
            return redirect('/admin');
        }
    }

    public function editCategory($category_id)
    {
        if (Auth::user()->role === 1) {
            $category = BlogCategories::find($category_id);
            return view('Blog::category.edit')->with(['category' => $category]);
        } else {
            return redirect('/admin');
        }
    } 

    public function updateArticle(Request $request, $id)
    {
        $data = $request->all();
        $data['url'] = ($data['url'] == '' ? str_slug($data['h1'], '-') : $data['url']);
        
        /*
            check if unique 
        */

        $article = BlogArticles::where('url', $data['url'])->first();
        $rules = [
            'title'       => 'required|min:3',
            'h1'          => 'required|min:3',
            'description' => 'required|min:3',
            'content'     => 'required|min:3',     
            'url'         => 'required|min:3',    
        ];
        $rules['url'] = (isset($article) && $article->id != $id ? 'required|min:3|unique:blog_articles' : 'required|min:3');
  
        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            return redirect('admin/blog/'.$id.'/edit')
                        ->withErrors($validator)
                        ->withInput();
        } else {

            if(Input::file('image'))
            {
                $filename = 'blog-images/'.md5($article->id).'.'.request()->image->getClientOriginalExtension();
                request()->image->move(public_path('blog-images'), $filename);

                /*$article        = BlogArticles::find($article->id);
                $article->image = $filename;  
                $article->save();  

                $img = Image::make('blog-images/'.md5($article->id).'.'.request()->image->getClientOriginalExtension());
                $img->resize(null, 200, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                $img->save('blog-images/thumb_'.md5($article->id).'.'.request()->image->getClientOriginalExtension());*/


            }
 
            $article              = BlogArticles::find($id);
            $article->title       = $data['title'];
            $article->h1          = $data['h1'];
            $article->description = $data['description'];
            $article->content     = $data['content'];
            $article->url         = $data['url'];
            $article->conversion  = $data['conversion'];  
            if(Input::file('image')) { $article->image = $filename; } 
            $article->status      = 1;       
            $article->save();
 
            return redirect('admin/blog');
        }
    }

    public function update(Request $request, $id)
    {
        $data        = $request->all();
        $data['url'] = ($data['url'] == '' ? str_slug($data['h1'], '-') : $data['url']);

        $rules = [
            'name'        => 'required|min:3',
            'title'       => 'required|min:3',
            'h1'          => 'required|min:3',
            'url'         => 'required|min:3',  
            'description' => 'required|min:3', 
        ];
 
        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            return redirect('admin/blog/edit/'.$id)
                        ->withErrors($validator)
                        ->withInput();
        } else {

            $category               = BlogCategories::find($id);
            $category->name         = $data['name'];
            $category->title        = $data['title'];
            $category->h1           = $data['h1'];
            $category->url          = $data['url'];
            $category->description  = $data['description'];         
            $category->icon_url     = $data['icon_url'];  
            $category->status       = 1;                  
            $category->save();

            return redirect('admin/blog');
        }
    }  

    public function destroy(Request $request, $id)
    {
        if (Auth::user()->role === 1) {
            $item = BlogCategories::find($id);
            $item->delete();
            return redirect('/admin/blog/');
        } else {
        
        }
    }

    public function destroyArticle($id)
    {
        // delete
        $article = BlogArticles::find($id);
        $article->delete();
        // redirect
        Session::flash('message', 'Successfully deleted the article!');
        return redirect('admin/blog');
    }

    public static function urlWithThumb($url)
    {
        $pieces = explode('/', $url);
        $new_url = $pieces[0].'/'.$pieces[1].'/thumb_'.$pieces[2];

        return $new_url;
    }

}
