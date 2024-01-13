<?php
namespace App\Http\Controllers\Superadmin\Website;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Datatables;
use Session;
use DB;


class AdvertiseController extends Controller
{
    public $url="superadmin/website/advertise";
    public $attachment_path="website/advertise";

    public function index(){
        return view('Superadmin.Website.Advertise.Index')->with(['url'=>$this->url]);
    }

    public function create(){
        return view('Superadmin.Website.Advertise.Form')->with(['id'=>NULL,
                                                                'url'=>$this->url,
                                                                'advertise'=>NULL,
                                                                'advertise_pages'=>[],
                                                                'advertise_attachments'=>[],
                                                                ]);
    }

    public function edit(Request $request,$id){
        $advertise=DB::table('website_advertises')->where('id',$id)->first();
        $advertise_pages=DB::table('website_advertise_pages')->where('advertise_id',$id)->where('is_active',1)->pluck('page_name')->toArray();
        $advertise_attachments=DB::table('website_advertise_attachments')->where('advertise_id',$id)->where('is_active',1)->pluck('attachment_url','id')->toArray();

        // dd($advertise,$advertise_pages,$advertise_attachments);
        return view('Superadmin.Website.Advertise.Form')->with(['id'=>$id,
                                                                'url'=>$this->url,
                                                                'advertise'=>$advertise,
                                                                'advertise_pages'=>$advertise_pages,
                                                                'advertise_attachments'=>$advertise_attachments,
                                                                ]);
    }

    public function store(Request $request)
    {
        $attachment_urls=[];
        if($request->hasFile('attachment_url')){
            $count=1;
            foreach($request->attachment_url as $a){
                $filename=date('Ymdhis')."_$count.".$a->getClientOriginalExtension();
                $a->move($this->attachment_path,$filename);
                $attachment_urls[]=$this->attachment_path."/".$filename;
                $count++;
            }
        }

        if(count($attachment_urls)!=count($request->attachment_url))
        {
            Session::flash('alert-warning', 'Some Images not uploaded. Try to upload again !!!');
            return redirect($this->url."/create");
        }

        $id=DB::table('website_advertises')->insertGetId([
                                            'advertise_title'=>$request->advertise_title,
                                            'start_date'=>$request->start_date,
                                            'end_date'=>$request->end_date ? $request->end_date : NULL,
                                            'ahref_url'=>$request->ahref_url,
                                            'is_active'=>$request->is_active,
                                            'remark'=>$request->remark ? $request->remark : NULL,
                                            'created_at'=>now()
                                            ]);
        if($id > 0){
            foreach($request->pages  as $p){
                DB::table('website_advertise_pages')->insert(['advertise_id'=>$id,'page_name'=>$p]);
            }

            foreach($attachment_urls  as $a){
                DB::table('website_advertise_attachments')->insert(['advertise_id'=>$id,'attachment_url'=>$a]);
            }

            Session::flash('alert-success', 'Advertise Added Successfully !!!');
            return redirect($this->url);
        }else{
            Session::flash('alert-danger', 'Advertise Not Added !!!');
            return redirect($this->url."/create");
        }
    }


    public function update(Request $request,$id)
    {
        $attachment_urls=[];
        if($request->hasFile('attachment_url')){
            $count=1;
            foreach($request->attachment_url as $a){
                $filename=date('Ymdhis')."_$count.".$a->getClientOriginalExtension();
                $a->move($this->attachment_path,$filename);
                $attachment_urls[]=$this->attachment_path."/".$filename;
                $count++;
            }
        }

        $is_updated=DB::table('website_advertises')->where('id',$id)->update([
                                                        'advertise_title'=>$request->advertise_title,
                                                        'start_date'=>$request->start_date,
                                                        'end_date'=>$request->end_date ? $request->end_date : NULL,
                                                        'ahref_url'=>$request->ahref_url,
                                                        'is_active'=>$request->is_active,
                                                        'remark'=>$request->remark ? $request->remark : NULL,
                                                        'updated_at'=>now()
                                                        ]);
        if($is_updated > 0){

            if(count($request->pages))
            {
                DB::table('website_advertise_pages')->where('advertise_id',$id)->update(['is_active'=>0,'updated_at'=>NOW()]);
                foreach($request->pages  as $p){
                    DB::table('website_advertise_pages')->insert(['advertise_id'=>$id,'page_name'=>$p]);
                }
            }

            if(count($attachment_urls)){
                // DB::table('website_advertise_attachments')->where('advertise_id',$id)->update(['is_active'=>0,'updated_at'=>NOW()]);
                foreach($attachment_urls  as $a){
                    DB::table('website_advertise_attachments')->insert(['advertise_id'=>$id,'attachment_url'=>$a]);
                }
            }

            Session::flash('alert-success', 'Advertise Updated Successfully !!!');
            return redirect($this->url);
        }else{
            Session::flash('alert-danger', 'Advertise Not Updated !!!');
            return redirect($this->url."/".$id."/edit");
        }
    }

    public function delete_images(Request $request){
        $is_updated=DB::table('website_advertise_attachments')->whereIn('id',$request->ids)
                                                             ->update(['is_active'=>0,
                                                                        'updated_at'=>NOW()]);

        if($is_updated>0){
            return response()->json(['status'=>1,'message'=>"Images Removed",'data'=>NULL]);
        }
        return response()->json(['status'=>0,'message'=>"Images Not Removed !!!",'data'=>NULL]);
    }

    public function show(){
        $query = DB::table('website_advertises');
        $data = $query->where('is_active',1)
                      ->orderby('id','desc')
                      ->get();
        return Datatables::of($data)
            ->addIndexColumn()
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
            ->rawColumns(['select_checkbox','blog_slug','description','is_active','action'])
            ->make(true);
    }

}
