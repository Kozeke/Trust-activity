<?php namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use App\Modules\Blog\Models\BlogArticles;
use App\Modules\Blog\Models\BlogCategories;
use DB;
use App\Modules\Faq\Models\FaqCategory;
use App\Modules\Faq\Models\Faq;

use App\Modules\Faq\Models\FaqValues;
 
class FaqController extends \App\Modules\Panel\Controllers\AbstractController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
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
 
        return view('faq.faq')->with([
            'domains'        => $this->domains,
            'faq_categories' => $faq_categories,
            'lang'           => $this->translate['lang']
        ]);
    }

    public function category($category)
    {  
        $category     = FaqValues::getCategoryBySlug($category);

        if (empty((array) $category) || count($category) == 0) {
            abort(404);
        } 

        $faq_elements = FaqValues::getArticles($category->id);

        return view('faq.faq_list')->with([
            'domains'      => $this->domains,
            'faq_elements' => $faq_elements,
            'category'     => $category,
            'lang'         => $this->translate['lang']
        ]);     
    }
 
    public function showArticle($category_url, $article_url)
    {  
        $category = FaqValues::getCategoryBySlug($category_url);

        if (empty((array) $category) || count($category) == 0) {
            abort(404);
        } 

        $article  = FaqValues::getArticleBySlug($article_url);

        if (count($article) == 0) {
            abort(404);
        }

        return view('faq.faq_detail')->with([
            'domains'    => $this->domains,
            'article'    => $article,
            'category'   => $category,
            'parent_url' => $category_url,
            'lang'       => $this->translate['lang']
        ]);
    }

}
