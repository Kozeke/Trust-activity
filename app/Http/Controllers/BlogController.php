<?php namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use App\Modules\Blog\Models\BlogArticles;
use App\Modules\Blog\Models\BlogCategories;
use DB;

 
class BlogController extends \App\Modules\Panel\Controllers\AbstractController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    protected $per_page = 10;
    protected $offset   = 0;
    protected $pagination = false;
    protected $total      = 0;
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $this->total = BlogArticles::count();
        $this->pagenation();
 
        $blog       = BlogArticles::orderBy('created_at', 'DESC')->offset($this->offset)->limit($this->per_page)->orderBy('created_at', 'DESC')->get();
        $categories = BlogCategories::orderBy('created_at', 'ASC')->get();

        return view('blog.index')->with(['articles' => $blog, 'categories' => $categories, 'pagination' => $this->pagination]);
    }

    protected function pagenation()
    {
        if ($this->total > $this->per_page) {
            $pages      = $this->total / $this->per_page;
            $current = (isset($_GET['page']) ? $_GET['page'] : 1);
            $this->pagination = ['total' => $pages, 'current' => $current];
        } 

        if(isset($_GET['page']) && intval($_GET['page']) && isset($pages)) { $this->offset = ($_GET['page'] - 1) * $this->per_page; } else { $this->offset = 0; }
    }

    public function category($category)
    {
        $current_category = BlogCategories::where('url', $category)->first();

        if ($current_category)
        {
            $this->total = BlogArticles::where('category_id', $current_category->id)->count();
            $this->pagenation();

            $blog      = BlogArticles::where('category_id', $current_category->id)->offset($this->offset)->limit($this->per_page)->orderBy('created_at', 'DESC')->get();
            $categories = BlogCategories::orderBy('created_at', 'ASC')->get();
 
            return view('blog.category')->with([
                'articles'         => $blog,
                'categories'       => $categories,
                'pagination'       => $this->pagination,
                'current_category' => $current_category
            ]);

        } else {

            return redirect('/blog');
        }

    }

    public function show($category, $url)
    {
        $blog        = BlogArticles::where('url', $url)->first();
        $categories  = BlogCategories::orderBy('created_at', 'ASC')->get();
        $current_cat = $this->getElementFromListByUrl($categories, $category , 'url');

        if ($current_cat == NULL || $current_cat->id != $blog->category_id) {
            $current_cat = $this->getElementFromListByUrl($categories, $blog->category_id , 'id');
            if ($current_cat == null) { return redirect('blog'); } else {
                return redirect('blog/'.$current_cat->url.'/'.$url);
            }
        }

        return view('blog.item')->with(['article' => $blog, 'categories' => $categories]);
    }

    protected function getElementFromListByUrl($list, $var, $type = 'url') {
        foreach ($list as $key => $value) {
            if ($value->{$type} == $var) { return $value; }
        }   

        return null;
    }


}
