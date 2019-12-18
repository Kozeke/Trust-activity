<?php namespace App\Modules\Faq\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use App\User;
use App\Modules\Faq\Models\FaqCategory;
use App\Modules\Faq\Models\Faq;

use Validator, Auth, Hash, Session;

class FaqGuestController extends \App\Modules\Panel\Controllers\AbstractController
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
            return view('Faq::category.index')->with(['categories' => FaqCategory::all()]);
        } else {
            return redirect('/admin');
        }
    }

    public function create()
    {
        if (Auth::user()->role === 1) {
            return view('Faq::category.add');
        } else {
            return redirect('/admin');
        }
    }

    public function createArticle($category_id)
    {
        $category = FaqCategory::find($category_id);
 
        if (Auth::user()->role === 1) {
            return view('Faq::article.add')->with(['category' => $category]);
        } else {
            return redirect('/admin');
        }
    }

    public function storeCategory(Request $request)
    {
        $data        = $request->all();
        $data['url'] = ($data['url'] == '' ? str_slug($data['h1'], '-') : $data['url']);
 
        /*
            check if unique 
        */

        $rules = [
            'name'        => 'required|min:3|unique:faq_categories',
            'title'       => 'required|min:3',
            'h1'          => 'required|min:3',
            'url'         => 'required|min:3',  
            'description' => 'required|min:3'    
        ];
 
        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            return redirect('admin/questions/create')
                        ->withErrors($validator)
                        ->withInput();
        } else {

            $category               = new FaqCategory();
            $category->name         = $data['name'];
            $category->title        = $data['title'];
            $category->h1           = $data['h1'];
            $category->url          = $data['url'];
            $category->description  = $data['description'];         
            $category->icon_url     = $data['icon_url'];  
            $category->status       = 1;                  
            $category->save();

            return redirect('admin/questions');
        }
    }

    public function show($category_id)
    {
        $category = FaqCategory::find($category_id);
        $articles = Faq::where('category_id', $category_id)->get();
 
        if (Auth::user()->role === 1) {
            return view('Faq::article.index')->with(['articles' => $articles, 'category' => $category]);
        } else {
            return redirect('/admin');
        }
    }

    public function storeArticle(Request $request) 
    {
        $data = $request->all();
        $data['url'] = ($data['url'] == '' ? str_slug($data['h1'], '-') : $data['url']);
 
        /*
            check if unique 
        */

        $rules = [
            'title'       => 'required|min:3|unique:faqs',
            'h1'          => 'required|min:3',
            'description' => 'required|min:3',
            'content'     => 'required|min:3',     
            'url'         => 'required|min:3',    
            'category_id' => 'required',
        ];

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            return redirect('admin/questions/'.$data['category_id'].'/create-article')
                        ->withErrors($validator)
                        ->withInput();
        } else {
 
            $article              = new Faq();
            $article->title       = $data['title'];
            $article->h1          = $data['h1'];
            $article->description = $data['description'];
            $article->content     = $data['content'];
            $article->url         = $data['url'];
            $article->category_id = $data['category_id'];     
            $article->status      = 1;       
            $article->save();

            return redirect('admin/questions/'.$data['category_id']);
        } 
    }


}
