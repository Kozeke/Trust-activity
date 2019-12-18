<?php namespace App\Modules\Faq\Controllers\ServiceProvider;

use Illuminate\Database\Eloquent\Collection as Collection;

class StoreCategoryService  
{
    // type 0 = single item
    // type 1 = array 
    // type 2 = false
    public function sortCollection($data, int $type = 2)
    {
        $data_sorted = new \stdClass();

        if ($type != 1 && $type != 0) { return false; }
 
        foreach ($data as $key => $value) {
            
            $data_sorted = ($type == 1 ? $this->sortArray($data_sorted, $value) : $this->sortSingle($data_sorted, $value)); 
        }

        return $data_sorted;
    }

    protected function sortSingle($array, $value)
    {
        if (!property_exists($array, $value->id)) {

            $array->id = $value->item_id;         
        }

        $key = ($value->name != 'categoryid' ? $value->name.'_'.$value->lang : $value->name);
        $array->{$key} = $value->value;

        return $array;
    }

    protected function sortArray($array, $value)
    {
        if (!property_exists($array, $value->item_id)) {

            $array->{$value->item_id} = new \stdClass();
            $array->{$value->item_id}->id = $value->item_id;            
        }  

        $key = ($value->name != 'categoryid' ? $value->name.'_'.$value->lang : $value->name);
        $array->{$value->item_id}->{$key} = $value->value;

        return $array; 
    }
 
}
