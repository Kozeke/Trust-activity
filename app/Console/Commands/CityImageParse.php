<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use App\CityImage;
use Location;

class CityImageParse extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'image:city-parse';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parse city image from google';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //$this->getFromActivity();   
        $this->parse();
    }

    public function parse()
    {
        $list = CityImage::where('status', 0)->get();

        foreach ($list as $key => $value)
        {
            //print_r($value);
            //sleep(1);
            $image = file_get_contents('https://maps.googleapis.com/maps/api/staticmap?language=en&center='.$value->latitude.'%20'.$value->longitude.'&zoom=10&size=200x200&key=AIzaSyDgnpsxmx_-Vk9I4Xy7xYbZHLEoW3Dkg4M');
            //$fp  = fopen('/var/www/positron-it/data/www/dev.positron-it.ru/public/img/map/'.str_slug($value->cityName).'-'.$value->id.'.png', 'w+'); 
            $fp  = fopen('/var/www/html/public/img/map/'.str_slug($value->cityName).'-'.$value->id.'.png', 'w+'); 
            fputs($fp, $image); 
            fclose($fp); 
            unset($image);  
            CityImage::where('id', $value->id)->update(['status' => 1]);
            echo 'add city: '.$value->cityName.PHP_EOL;
        }
    }

    public function getFromActivity()
    {
        $list = DB::table('hot_streak_activities')->get();

        foreach ($list as $key => $value) {
            $position = Location::get($value->ip);
            if (!isset($position->cityName) || (isset($position->cityName) && $position->cityName == '')) { $position = $this->getLocationFromOtherApi($value->ip); } 
            $this->addCityImage($position);
        }
    }

    public function addCityImage($position)
    {
        $ifExist = CityImage::where('cityName', $position->cityName)->first();
        if (!$ifExist && $position->cityName != '')  {
            $city_image            = new CityImage();
            $city_image->cityName  = $position->cityName;
            $city_image->latitude  = $position->latitude;
            $city_image->longitude = $position->longitude;
            //$city_image->status    = '0';             
            $city_image->save();              
        } 
    }

    public function getLocationFromOtherApi($ip)
    {
        $json = file_get_contents('http://ip-api.com/json/'.$ip);
        $data = json_decode($json);

        return (object) [
            'countryName' => $data->country,
            'countryCode' => $data->countryCode,
            'regionName'  => $data->regionName,
            'cityName'    => $data->city,
            'latitude'    => $data->lat,          
            'longitude'   => $data->lon,                
        ];
    }

}
