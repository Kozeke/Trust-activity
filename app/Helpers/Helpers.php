<?php namespace app\Helpers;
 
use Illuminate\Support\Facades\DB;
use Session;
 
class Helpers {
    /**
     * @param int $user_id User-id
     * 
     * @return string
     */
    public static function translate($slug, $text)
    {
        /*if (!Session::has('translate'))
        {
            $translate = \App\Modules\Panel\Controllers\PanelController::getTranslateArray();
            Session::put('translate', $translate);
        } else {
            
           $translate = Session::get('translate');
        }*/
        $translate = \App\Modules\Panel\Controllers\PanelController::getTranslateArray();
        //Session::put('translate', $translate);
        return (isset($translate[$slug]) ? $translate[$slug] : $text);
    }

    public static function JumpOutPreviewPosition($popup_size, $position)
    {
        switch ($popup_size) {
            case 'small':
                $scale = 0.8333;
                $size  = 360;
                break;
            case 'medium':
                $scale = 0.60;
                $size  = 500;
                break;
            case 'large':
                $scale = 0.46;
                $size  = 650;
                break;    
            case 'f_h':
                $scale = 1;
                $size  = 300;
                break;       
            case 'f_w':
                $scale = 1;
                $size  = 300;
                break;   
            default:
                $scale = 1;
                $size  = 300;
                break;                                
        }

        $gap = ($size - 300) / 2;

        $top    = 'auto';
        $bottom = 'auto';
        $left   = 'auto';
        $right  = 'auto';

        switch ($position) {
            case 'left-top':
                $top  = '-'.$gap.'px';
                $left = '-'.$gap.'px';
                break;
            case 'center-top':
                $left   = '0';
                $right  = '0';
                $top    = '-'.$gap.'px';
                break;
            case 'right-top':
                $top = '-'.$gap.'px';
                $right  = '-'.$gap.'px';
                break;      
            case 'left-mid':
                $top    = '0';
                $bottom = '0';
                $left = '-'.$gap.'px';
                break;
            case 'center-mid':
                $top    = '0';
                $bottom = '0';
                $left   = '0';
                $right  = '0';
                break;
            case 'right-mid':
                $top    = '0';
                $bottom = '0';
                $right  = '-'.$gap.'px';
                break;      
            case 'left-bot':
                $bottom = '-'.$gap.'px';
                $left   = '-'.$gap.'px';
                break;
            case 'center-bot':
                $left   = '0';
                $right  = '0';
                $bottom = '-'.$gap.'px';
                break;
            case 'right-bot':
                $bottom = '-'.$gap.'px';
                $right  = '-'.$gap.'px';
                break;      
        }
 
        return ['top' => $top, 'bottom' => $bottom, 'left' => $left, 'right' => $right, 'size' => $size, 'scale' => $scale];
    }
}

