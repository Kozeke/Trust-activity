<?php

namespace App\Modules\Services\Controllers;

use DB;
use Illuminate\Http\Request;

class FakeServiceController extends \App\Modules\Panel\Controllers\AbstractController
{
    //

    public function FillAllFakesWithName() {

        ini_set("memory_limit", "8096M");
        $fakes = DB::table('hot_streak_fakes')->where(['name' => NULL, 'surname' => NULL])->get();//->offset(1000)->limit(1000)->get();
        echo count($fakes);
        $current_gender = 'm';
        foreach ($fakes as $key => $value) {
            //print_r($value);
            $streak = DB::table('hot_streaks')->where('id', $value->hot_streak_id)->orderBy('id')->first();
            if($streak) {
                $domain = DB::table('domains')->where('id', $streak->domain_id)->first();
                if($domain) {
                    switch ($streak->locale) {
                        case 'en':
                            $country = 'United States';
                            break;
                        case 'ru':
                            $country = 'Russia';
                            break;
                        case 'el':
                            $country = 'Greece';
                            break;
                        case 'it':
                            $country = 'Italy';
                            break;    
                        case 'de':
                            $country = 'germany';
                            break;                          
                        case 'tr':
                            $country = 'turkey';
                            break;                          
                        default:            
                            $country = 'United States';
                            break;
                    }

                    if ($value->name == NULL && $value->surname == NULL) {
                        $name_m = \App\FakeNames::where(['type' => 'name', 'gender' => 'male', 'country' => $country])->limit(1)->inRandomOrder()->first();
                        $name_f = \App\FakeNames::where(['type' => 'name', 'gender' => 'female', 'country' => $country])->limit(1)->inRandomOrder()->first();

                        $surname_m = \App\FakeNames::where(['type' => 'surname', 'gender' => 'male', 'country' => $country])->limit(1)->inRandomOrder()->first();
                        $surname_f = \App\FakeNames::where(['type' => 'surname', 'gender' => 'female', 'country' => $country])->limit(1)->inRandomOrder()->first();

                        $name    = ${'name_'.$current_gender}->value;
                        $surname = ${'surname_'.$current_gender}->value;

                        $current_gender = ($current_gender == 'm' ? 'f' : 'm');
           
                        DB::table('hot_streak_fakes')
                            ->where('id', $value->id)
                            ->update(['name' => $name, 'surname' => $surname]);        

                         echo 'updated<br>';
                    }
      
                    echo 'got domain<br>';
                } else {
                    DB::table('hot_streak_fakes')->where('id', $value->id)->delete();
                    echo 'no domain<br>';
                }
                echo 'got company<br>';
            } else {
                DB::table('hot_streak_fakes')->where('id', $value->id)->delete();
                echo $value->id.'no company<br>';
            }

        }
    }

    public function ParseNameFromApi() {
 
        // russia / united states / italy / greece
        //&ext=photo
        $arr = ['turkey'];//'russia', 'united+states', 'greece', 'italy', 'germany'];

        foreach ($arr as $key) {
            $country = $key;
            $male = file_get_contents('https://uinames.com/api/?amount=400&region=' . $country . '&gender=male');
            $test = json_decode($male);

            foreach ($test as $key => $index) {

                $item = $index;

                $exist = \App\FakeNames::where('value', $item->name)->first();
                if (!$exist) {
                    $person          = new \App\FakeNames;
                    $person->type    = 'name';
                    $person->value   = $item->name;
                    $person->gender  = $item->gender;
                    $person->country = $item->region;
                    $person->save();                
                }
 
                $exist = \App\FakeNames::where('value', $item->surname)->first();
                if (!$exist) {
                    $person          = new \App\FakeNames;
                    $person->type    = 'surname';
                    $person->value   = $item->surname;
                    $person->gender  = $item->gender;
                    $person->country = $item->region;
                    $person->save();
                }
            }
 
            $female = file_get_contents('https://uinames.com/api/?amount=400&region=' . $country . '&gender=female');
            $test = json_decode($female);

            foreach ($test as $key => $index) {
     
                $item = $index;

                $exist = \App\FakeNames::where('value', $item->name)->first();
                if (!$exist) {
                    $person          = new \App\FakeNames;
                    $person->type    = 'name';
                    $person->value   = $item->name;
                    $person->gender  = $item->gender;
                    $person->country = $item->region;
                    $person->save();                
                }


                $exist = \App\FakeNames::where('value', $item->surname)->first();
                if (!$exist) {
                    $person          = new \App\FakeNames;
                    $person->type    = 'surname';
                    $person->value   = $item->surname;
                    $person->gender  = $item->gender;
                    $person->country = $item->region;
                    $person->save();
                }
            }

        }
 
    }

}
