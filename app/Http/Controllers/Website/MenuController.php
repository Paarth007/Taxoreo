<?php
namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use Redirect;
use DB;
use Validator;

class MenuController extends Controller
{
    public function show_menu($menu_name)
    {
        $menu=DB::table('website_submenu_services as ss')
                        ->leftJoin('website_menu_services as s','s.id','=','ss.website_menu_service_id')
                        ->select('ss.*','s.menu_service_name')
                        ->where('ss.redirection_url',$menu_name)
                        ->first();

        $company_types=DB::table('master_company_types')
                            ->where('is_active',1)
                            ->pluck('company_type_name','id')
                            ->toArray();
        $company_and_documents=[];
        foreach($company_types as $id=>$name){
            $docs=DB::table('master_services_documents as d')
                            ->leftJoin('master_documents as md','md.id','d.master_document_id')
                            ->where('d.master_service_id',$menu->master_service_id)
                            ->where('d.master_company_type_id',$id)
                            ->where('d.is_active',1)
                            ->select('md.id','md.document_name')
                            ->get();
            $docArray=[];
            if(count($docs)){
                foreach($docs as $d){
                    $docArray[]=['id'=>$d->id,'document_name'=>$d->document_name];
                }
            }
            $temp=[];
            $temp['id']=$id;
            $temp['name']=$name;
            $temp['documents']=$docArray;
            $company_and_documents[]=$temp;
        }
        $faqs=DB::table('webiste_submenu_service_faqs')->where('website_submenu_service_id',$menu->id)
                                                        ->where('is_active',1)
                                                        ->get();

        $reviews=DB::table('website_submenu_service_reviews')->where('website_submenu_service_id',$menu->id)
                                                         ->where('is_active',1)
                                                         ->get();

        return view('Website.ServicePage',compact('menu','company_and_documents','faqs','reviews'));
    }
}
