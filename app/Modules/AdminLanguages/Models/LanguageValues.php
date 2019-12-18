<?php

namespace App\Modules\AdminLanguages\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class LanguageValues extends Model
{
    //
    public function getByLang($slug, $language_id)
    {
    	$item = DB::table('language_values')->where('slug', $slug)->where('language_id', $language_id)->first();
    	return ($item ? $item->value : null);
    }
}
