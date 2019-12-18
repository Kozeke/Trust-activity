<?php namespace App\Modules\Faq\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;

use App\Modules\Faq\Models\FaqValues;
use App\User;

use Validator, Auth, Hash, Session, DB;

class FaqUserController extends \App\Modules\Panel\Controllers\AbstractController
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
        $faq_categories = FaqValues::getCategories(); 

        return view('Faq::faq')->with([
            'domains'        => $this->domains,
            'faq_categories' => $faq_categories,
            'lang'           => $this->translate['lang']
        ]);
    }

    public function show($url)
    {  
        $category     = FaqValues::getCategoryBySlug($url);
        $faq_elements = FaqValues::getArticles($category->id);

        return view('Faq::faq_list')->with([
            'domains'      => $this->domains,
            'faq_elements' => $faq_elements,
            'category'     => $category,
            'lang'         => $this->translate['lang']
        ]);
    }

    public function showArticle($category_url, $article_url)
    {  
        $category = FaqValues::getCategoryBySlug($category_url);
        $article  = FaqValues::getArticleBySlug($article_url);
 
        return view('Faq::faq_detail')->with([
            'domains'    => $this->domains,
            'article'    => $article,
            'category'   => $category,
            'parent_url' => $category_url,
            'lang'       => $this->translate['lang']
        ]);
    }

}
