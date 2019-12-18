<?php namespace App\Modules\Faq\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;

use App\Modules\Faq\Controllers\StoreProvider\StoreCategoryController;
use App\Modules\Faq\Controllers\StoreProvider\StoreArticleController;
use App\Modules\Faq\Models\FaqValues;

use App\Modules\AdminLanguages\Models\Languages;
use App\User;
use Validator, Auth, Hash, Session;

class FaqController extends \App\Modules\Panel\Controllers\AbstractController
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
        return (Auth::user()->role === 1 ? view('Faq::category.index')->with(['categories' => FaqValues::getCategories()]) : redirect('/admin'));
    }

    public function create()
    {
        $languages = Languages::all();
        return (Auth::user()->role === 1 ? view('Faq::category.add')->with(['languages' => $languages]) : redirect('/admin'));
    }

    public function createArticle($category_id)
    {
        $languages = Languages::all();
        $category  = FaqValues::getCategory($category_id);
        return (Auth::user()->role === 1 ? view('Faq::article.add')->with(['languages' => $languages, 'category' => $category]) : redirect('/admin'));
    }

    public function storeCategory(Request $request)
    {
        $storeCategory = new StoreCategoryController();
        return $storeCategory->save($request);
    }

    public function update(Request $request, $id)
    {
        $storeCategory = new storeCategoryController();
        return $storeCategory->update($request, $id);
 
        /*$data        = $request->all();
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
            return redirect('admin/questions/edit/'.$id)
                        ->withErrors($validator)
                        ->withInput();
        } else {

            $category               = FaqCategory::find($id);
            $category->name         = $data['name'];
            $category->title        = $data['title'];
            $category->h1           = $data['h1'];
            $category->url          = $data['url'];
            $category->external_url = $data['external_url'];
            $category->description  = $data['description'];         
            $category->icon_url     = $data['icon_url'];  
            $category->status       = 1;                  
            $category->save();

            return redirect('admin/questions');
        }*/
    }

    public function show($category_id)
    {
        $category = FaqValues::getCategory($category_id);
        $articles = FaqValues::getArticles($category_id);
 
        return (Auth::user()->role === 1 ? view('Faq::article.index')->with(['articles' => $articles, 'category' => $category]) : redirect('/admin'));
    }

    public function storeArticle(Request $request) 
    {
        $storeArticle = new StoreArticleController();
        return $storeArticle->save($request);
    }

    public function updateArticle(Request $request, $id)
    {
        $storeArticle = new StoreArticleController();
        $result       = $storeArticle->update($request, $id);
        if (is_string($result)) {
            return redirect($result);
        }
        return $result;
    }

    public function editCategory($category_id)
    {
        $languages = Languages::all();
        $category  = FaqValues::getCategory($category_id);
        return (Auth::user()->role === 1 ? view('Faq::category.edit')->with(['languages' => $languages, 'category' => $category]) : redirect('/admin'));
    }

    public function editArticle($category_id, $article_id)
    {
        $languages = Languages::all();
        return (Auth::user()->role === 1 ? view('Faq::article.edit')->with(['languages' => $languages, 'article' => FaqValues::getArticle($article_id)]) : redirect('/admin'));
    }

    public function destroy(Request $request, $id)
    {
        if (Auth::user()->role === 1) {
            $item = FaqCategory::find($id);
            $item->delete();
            return redirect('/admin/questions/');
        } else {
        
        }
    }

    public function destroyArticle(Request $request, $id)
    {
        if (Auth::user()->role === 1) {
            $parent = FaqValues::where(['item_id' =>$id, 'name' => 'categoryid'])->select('value')->first();
            $item   = FaqValues::where('item_id', $id)->delete();
 
            return redirect('/admin/questions/'.$parent['value']);
        } else {
        
        }
    }
}
