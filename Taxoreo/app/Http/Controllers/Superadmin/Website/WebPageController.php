<?php
namespace App\Http\Controllers\Superadmin\Website;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Datatables;
use Session;
use DB;


class WebPageController extends Controller
{
    public $url="superadmin/website/web-page";
    public $blog_attachment_path="website/web-page/";

    public function index(){

        // $filename=""
        // $file = fopen($filename, "c");
        // fseek($file, -3, SEEK_END);
        // fwrite($file, "whatever you want to write");
        // fclose($file);

        return view('Superadmin.Website.WebPage.Index')->with(['url'=>$this->url]);
    }

    public function create(){
        $menu_services=DB::table('website_menu_services')->where('is_active',1)->get();
        $services=DB::table('master_services')->where('is_active',1)->get();
        return view('Superadmin.Website.WebPage.Form')->with(['id'=>NULL,
                                                              'url'=>$this->url,
                                                              'page'=>NULL,
                                                              'menu_services'=>$menu_services,
                                                              'services'=>$services
                                                            ]);
    }

    public function edit(Request $request,$id){
        $menu_services=DB::table('website_menu_services')->where('is_active',1)->get();
        $services=DB::table('master_services')->where('is_active',1)->get();
        $page=DB::table('website_submenu_services')->where('id',$id)->first();

        return view('Superadmin.Website.WebPage.Form')->with(['id'=>$id,
                                                            'url'=>$this->url,
                                                            'page'=>$page,
                                                            'menu_services'=>$menu_services,
                                                            'services'=>$services
                                                        ]);
    }

    public function store(Request $request)
    {
        $dataArray=[];
        if($request->hasFile('attachment_url')){
            $file = $request->file('attachment_url');
            $filename=date('Ymdhis').".".$file->getClientOriginalExtension();
            $file->move($this->blog_attachment_path,$filename);
            $dataArray['attachment_url']=$this->blog_attachment_path."/".$filename;
        }
        $dataArray=array_merge($dataArray,[
            'website_menu_service_id'=>$request->website_menu_service_id,
            'master_service_id'=>$request->master_service_id,
            'redirection_url'=>$request->redirection_url,
            'meta_keywords'=>$request->meta_keywords,
            'meta_description'=>$request->meta_description,
            'main_content'=>$request->main_content,
            'is_active'=>$request->is_active,
            'remark'=>$request->remark ? $request->remark : NULL,
            'updated_at'=>now()
        ]);
        $update=DB::table('website_submenu_services')->insertGetId($dataArray);
        if($update > 0){
            Session::flash('alert-success', 'Page Added Successfully !!!');
            return redirect($this->url);
        }else{
            Session::flash('alert-danger', 'Page Not Updated !!!');
            return redirect($this->url."/".$id."/edit");
        }
    }


    public function update(Request $request,$id)
    {
        $dataArray=[];
        if($request->hasFile('attachment_url')){
            $file = $request->file('attachment_url');
            $filename=date('Ymdhis').".".$file->getClientOriginalExtension();
            $file->move($this->blog_attachment_path,$filename);
            $dataArray['attachment_url']=$this->blog_attachment_path."/".$filename;
        }
        $dataArray=array_merge($dataArray,[
            'website_menu_service_id'=>$request->website_menu_service_id,
            'master_service_id'=>$request->master_service_id,
            'redirection_url'=>$request->redirection_url,
            'meta_keywords'=>$request->meta_keywords,
            'meta_description'=>$request->meta_description,
            'main_content'=>$request->main_content,
            'is_active'=>$request->is_active,
            'remark'=>$request->remark ? $request->remark : NULL,
            'updated_at'=>now()
        ]);
        $update=DB::table('website_pages')->where('id',$id)->update($dataArray);
        if($update > 0){
            Session::flash('alert-success', 'Blog Updated Successfully !!!');
            return redirect($this->url);
        }else{
            Session::flash('alert-danger', 'Blog Not Updated !!!');
            return redirect($this->url."/".$id."/edit");
        }
    }


    public function show(){

        $data=DB::table('website_submenu_services as ss')
                    ->leftJoin('website_menu_services as s','s.id','=','ss.website_menu_service_id')
                    ->leftJoin('master_services as m','m.id','=','ss.master_service_id')
                    ->select('ss.*','s.menu_service_name','m.service_name')
                    ->where('ss.is_active',1)
                    ->get();

        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('meta_description', function($row){
                    $text=strip_tags($row->meta_description);
                    $add="";
                    if($row->id){
                        $add='<i class="fas fa-arrow-circle-right" onclick="get_description('.$row->id.')">';
                    }
                    return mb_convert_encoding($text,'UTF-8', 'UTF-8') .' '.$add;
            })
            ->addColumn('select_checkbox', function($row){
                return '<input type="checkbox" class="select_all_individual_checkbox" name="id[]" value="'.$row->id.'">';
            })
            ->addColumn('is_active', function($row){
                    return $row->is_active==1 ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Deactive</span>';
            })
            ->addColumn('action',function($row){
                $ret='<a href="'.url($this->url.'/'.$row->id.'/edit').'"
                        class="btn btn-icon btn-2 btn-sm btn-success px-1 py-0">
                            <i class="fas fa-pencil-alt"></i>
                        </a>';
                return $ret;
             })
            ->rawColumns(['select_checkbox','meta_description','is_active','action'])
            ->make(true);
    }

}
