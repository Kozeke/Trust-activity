<?php

namespace App\Modules\Blog\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class BlogArticles extends Model
{
    //
	public function category($category_id)
	{
		$category = DB::table('blog_categories')->where('id', $category_id)->first();
		return $category;
 	}
}
