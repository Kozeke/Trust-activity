<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Modules\Domains\Models\Domains;
use DB;

class JumpOutCompany extends Model
{
    static public function CompaniesToUrl($token, $postFrom) {

        return Domains::where('hash_key', $token)
            ->join('jump_out_companies', 'jump_out_companies.domain_id', '=', 'domains.id')
            ->join('jump_out_displays', 'jump_out_displays.module_id', '=', 'jump_out_companies.id')
            ->where('jump_out_displays.url', $postFrom)
            ->select('jump_out_companies.*')
            ->get(); 
    } 

    static public function showOnMain($domain_id)  {

        return DB::table('jump_out_companies')
            ->where(['domain_id' => $domain_id, 'show_main' => 'yes'])
            ->get();
    }

    static public function showOnAll($domain_id)  {

        return DB::table('jump_out_companies')
            ->where(['domain_id' => $domain_id, 'show_all' => 'yes'])
            ->get();
    }

    static private function CompanyIds($companies) {
        $company_ids    = [];

        if($companies && count($companies) > 0) {
            foreach ($companies as $key => $value) {
                array_push($company_ids, $value->id);
            }
        }

        return $company_ids;
    }
    //
    static private function getCompanyData($companies, $data) {

        $company_ids = JumpOutCompany::CompanyIds($companies);
 
        if (count($company_ids) > 0) {

            $companies = JumpOutCompany::whereIn('jump_out_companies.id', $company_ids)
            ->join('jump_out_templates', 'jump_out_companies.template_id', '=', 'jump_out_templates.id')
            ->where('jump_out_companies.status', 1)
            ->select('jump_out_templates.data', 'jump_out_companies.id', 'jump_out_companies.priority')
            ->orderBy('jump_out_companies.priority', 'DESC')
            ->orderBy('jump_out_companies.id', 'ASC')     
            ->get();

            foreach ($companies as $company) {
                if (JumpOutCompany::ifCompanyAlreadyAdded($company->id, $data) == false) {
                    $arr = unserialize($company->data);
                    $arr['company_id'] = $company->id;
                    array_push($data, $arr);                    
                }
            }
        }  

        return $data;
    }

    static private function ifCompanyAlreadyAdded($id, $data) {

        foreach ($data as $key => $value) {
            if ($value['company_id'] == $id) {
                return true;
            }
        }
        return false;
    }

    static private function sortByPriority($data) {
        return $data;
    }
    
    //
    public static function getCompany($host, $postFrom, $token)
    {
    	$domain = Domains::where('hash_key', $token)->first();

    	if ($host == $domain->url) {
            
            $data = [];
            // no all
            $showOnAll = JumpOutCompany::showOnAll($domain->id);       
            if ($showOnAll) {
                $data = JumpOutCompany::getCompanyData($showOnAll, $data);
            }
 
            // on main
            if ($host.'/' == $postFrom) {
                $showOnMain = JumpOutCompany::showOnMain($domain->id);       
                if ($showOnMain) {
                    $data = JumpOutCompany::getCompanyData($showOnMain, $data);
                }
            }

            //by url
            $companiesToUrl = JumpOutCompany::CompaniesToUrl($token, $postFrom);
            
            if ($companiesToUrl) {
                $data = JumpOutCompany::getCompanyData($companiesToUrl, $data);
            }


            $data = JumpOutCompany::sortByPriority($data);

            return response()->json($data);
            /*$companiesToUrl = JumpOutCompany::CompaniesToUrl($token, $postFrom);
            $company_ids    = [];
            $data           = [];

            if($companiesToUrl && count($companiesToUrl) > 0) {
                foreach ($companiesToUrl as $key => $value) {
                    array_push($company_ids, $value->module_id);
                }
            }

            if (count($company_ids) > 0) {
 
                $companies = JumpOutCompany::whereIn('jump_out_companies.id', $company_ids)
                    ->join('jump_out_templates', 'jump_out_companies.template_id', '=', 'jump_out_templates.id')
                    ->where('jump_out_companies.status', 1)
                    ->select('jump_out_templates.data', 'jump_out_companies.id', 'jump_out_companies.priority')
                    ->orderBy('jump_out_companies.priority', 'DESC')
                    ->orderBy('jump_out_companies.id', 'ASC')     
                    ->get();

                    foreach ($companies as $company) {
                        $arr = unserialize($company->data);
                        $arr['company_id'] = $company->id;
                        array_push($data, $arr);
                    }
            }  
 
            return response()->json($data);*/
			/*$companies = JumpOutCompany::where('domain_id', $domain->id)
			->join('jump_out_templates', 'jump_out_companies.template_id', '=', 'jump_out_templates.id')
            ->where('jump_out_companies.status', 1)
			->select('jump_out_templates.data', 'jump_out_companies.id', 'jump_out_companies.priority')
            ->orderBy('jump_out_companies.priority', 'DESC')
            ->orderBy('jump_out_companies.id', 'ASC')          
			->get();

            $data = [];*/
    	}
    }

    //
    public function getTemplate($id)
    {
        $item = DB::table('jump_out_templates')->where('id', $id)->first();
        if ($item) {
            return unserialize($item->data);
        } else {
            return 0;
        }
    }


    
}
