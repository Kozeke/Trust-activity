<?php namespace App\Modules\Faq\Models;

use Illuminate\Database\Eloquent\Model;
use App\Modules\Faq\Controllers\ServiceProvider\StoreCategoryService as StoreCategoryService;
use App\Modules\Faq\Controllers\ServiceProvider\StoreArticleService as StoreArticleService;
 
class FaqValues extends Model
{
    public static function getCategories()
    {   
        $service = new StoreCategoryService;
        return $service->sortCollection(FaqValues::where('type', 'category')->get(), 1);	
    }

    public static function getCategory($id)
    {
        $service = new StoreCategoryService;
        return $service->sortCollection(FaqValues::where('type', 'category')->where('item_id', $id)->get(), 0);
    }

    public static function getCategoryBySlug($url)
    {
        $service  = new StoreCategoryService;
        $category = FaqValues::where('type', 'category')
                    ->whereIN('item_id', function($query) use ($url) {
                    $query->select('item_id')
                    ->from(with(new FaqValues)->getTable())
                    ->where('name', 'url')
                    ->where('value', $url);
                })->get();

        return $service->sortCollection($category, 0);
    }

    public static function getArticles($category_id)
    {
        $service  = new StoreArticleService;
        $articles = FaqValues::where('type', 'article')
                    ->whereIN('item_id', function($query) use ($category_id) {
                    $query->select('item_id')
                    ->from(with(new FaqValues)->getTable())
                    ->where('name', 'categoryid')
                    ->where('value', $category_id);
                })->get();

        return $service->sortCollection($articles, 1);
    }    

    public static function getArticle($id)
    {
        $service = new StoreArticleService;
        return $service->sortCollection(FaqValues::where('type', 'article')->where('item_id', $id)->get(), 0);
    }  

    public static function getArticleBySlug($url)
    {
        $service = new StoreArticleService;
        $articles = FaqValues::where('type', 'article')
                    ->whereIN('item_id', function($query) use ($url) {
                    $query->select('item_id')
                    ->from(with(new FaqValues)->getTable())
                    ->where('name', 'url')
                    ->where('value', $url);
                })->get();

        return $service->sortCollection($articles, 0);
    }  

}
