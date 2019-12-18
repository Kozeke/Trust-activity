<?php namespace App\Modules\Faq\Controllers\StoreProvider;

use Illuminate\Http\Request;
use App\Modules\Faq\Models\FaqValues;
use Validator;

class StoreArticleController extends StoreController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    private $data, $next_id;
    private $rules = [];
    
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

    public function save(Request $request)
    {
        $this->data    = $request->all();
        $this->next_id = $this->nextId();

        unset($this->data['_token']);
        unset($this->data['submit']);

        $this->build(); 

        return $this->validate('add');
    }

    public function update(Request $request, $id)
    {
        $this->data    = $request->all();
        $this->next_id = $this->nextId();

        unset($this->data['_token']);
        unset($this->data['submit']);
        unset($this->data['_method']);
 
        $this->data['id'] = $id;

        $this->build(); 

        return $this->validate('update');
    }    
 
    protected function validate($type)
    {
        $validator = Validator::make($this->data, $this->rules);
 
        if ($validator->fails()) {

            return redirect('/admin/questions/'.$this->data['categoryid'].'\edit/'.$this->data['id'])
                        ->withErrors($validator)
                        ->withInput();
        } else { 

            if ($type == 'add') {
                $this->add('new');
            } else {
                $this->add('update');
            }
            
            return 'admin/questions/'.$this->data['categoryid'];
           // return redirect('admin/questions/'.$this->data['categoryid']);
        }
    }

    protected function add($type)
    {
        foreach ($this->data as $key => $value)
        {
            $pieces = explode('_', $key);

            if (count($pieces) == 2)
            {
                $field  = $pieces[0];
                $lang   = $pieces[1];
            } else if ($pieces[0] == 'categoryid') {
                $field  = $pieces[0];
                $lang   = '';
            } else if ($pieces[0] == 'id') {
                continue;
            }

            if ($type == 'new') {

                $category           = new FaqValues();
                $category->item_id  = $this->next_id;
                $category->type     = 'article';
                $category->lang     = $lang;
                $category->name     = $field;
                $category->value    = $value;
                $category->save();                 
            }

            if ($type == 'update') {

                $category = FaqValues::where(['name' => $field, 'item_id' => $this->data['id'], 'lang' => $lang])
                ->update([
                    'type' => 'article',
                    'lang' => $lang,
                    'name' => $field,
                    'value' => $value,      
                ]);   
            }
     
        }    
    }

    protected function build()
    {
        foreach ($this->data as $key => $value)
        {
            $pieces = explode('_', $key);

            if (count($pieces) != 2) {
                continue;
            }  

            $field  = $pieces[0];
            $lang   = $pieces[1];

            if ($field == 'url') {
                $this->data[$key] = ($this->data[$key] == '' ? str_slug($this->data['h1_'.$lang], '-') : str_slug($this->data[$key], '-'));
            }

            if ($field == 'externalurl') {
                continue;
            }   

            if ($field == 'h1') {
                $this->rules[$key] = 'required|min:3';
            } else {
                $this->rules[$key] = 'required|min:3';
            }   
        }
    }

    protected function nextId()
    {
        $item = FaqValues::latest()->first();
        return ($item ? $item->item_id + 1 : 1);
    }

 }
