<?php
namespace App\Http\Controllers\superadmin\MessagesTemplates;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Datatables;
use Session;
use DB;

class WhatsAppController extends Controller
{
    public $url="superadmin/message-template/whats-app";

    public function index(){
        return view('Superadmin.MessageTemplate.WhatsApp.Index')->with(['url'=>$this->url]);
    }

    public function create(){
        return view('Superadmin.MessageTemplate.WhatsApp.Form')->with(['id'=>NULL,
                                                            'url'=>$this->url,
                                                            'whats_app'=>NULL]);
    }

    public function edit($id){

        $email=DB::table('master_message_templates')->where('id',$id)->first();

        return view('Superadmin.MessageTemplate.WhatsApp.Form')->with(['id'=>$id,
                                                                        'url'=>$this->url,
                                                                        'whats_app'=>$email]);
    }

    public function store(Request $request){
        $check=DB::table('master_message_templates')
                    ->where('type',"WHATS_APP")
                    ->where('template_name',$request->template_name)->first();
        if($check){
            Session::flash('alert-danger', 'Template Name Already Exists !!!');
            return redirect($this->url."/create");
        }
        $id=DB::table('master_message_templates')->insertGetId([
                                                    'type'=>"WHATS_APP",
                                                    'template_name'=>$request->template_name,
                                                    'description'=>$request->description,
                                                    'is_active'=>$request->is_active,
                                                    'remark'=>$request->remark ? $request->remark : NULL,
                                                    'created_at'=>now()
                                                ]);

        if($id > 0)
        {
            Session::flash('alert-success', 'Template Added Successfully !!!');
            if($request->button_type && $request->button_type=="SAVE_AND_ADD_ANOTHER"){
                return redirect($this->url."/create");
            }
            return redirect($this->url);
        }else{
            Session::flash('alert-danger', 'Template Not Added !!!');
            return redirect($this->url."/create");
        }
    }

    public function update(Request $request,$id)
    {
        $is_updated=DB::table('master_message_templates')->where('id',$id)
                                        ->update([
                                            'template_name'=>$request->template_name,
                                            'description'=>$request->description,
                                            'is_active'=>$request->is_active,
                                            'remark'=>$request->remark ? $request->remark : NULL,
                                            'updated_at'=>now()
                                        ]);
        if($is_updated > 0){
            Session::flash('alert-success', 'Template Updated Successfully !!!');
            return redirect($this->url);
        }else{
            Session::flash('alert-danger', 'Template Not Updated !!!');
            return redirect("$this->url/$id/edit");
        }
    }

    public function destroy($id)
    {
        $is_destroyed=DB::table('master_message_templates')->where('id',$id)->update([
                                                                    'is_active'=>0,
                                                                    'updated_at'=>now()
                                                                    ]);
        if($is_destroyed > 0){
            Session::flash('alert-success', 'Template Deleted Successfully !!!');
            return redirect($this->url);
        }else{
            Session::flash('alert-danger', 'Template Not Deleted !!!');
            return redirect("$this->url/$id/edit");
        }
    }

    public function show(Request $request)
    {
        $query = DB::table('master_message_templates')->where('type',"WHATS_APP");

        $data = $query
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
            ->rawColumns(['select_checkbox','is_active','action'])
            ->make(true);
    }

}
