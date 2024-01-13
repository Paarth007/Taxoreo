<?php
namespace App\Http\Controllers\Superadmin\UserList;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Datatables;
use Session;
use DB;

class ClientController extends Controller
{
    private $url="superadmin/user-list/client";
    private $document_url="";

    public function index(){
        return view('Superadmin.UserList.Client.Index')->with(['url'=>$this->url]);
    }

    public function create(Request $request){
        return view('superadmin.UserList.Client.Form')->with(['id'=>NULL,'url'=>$this->url,'document'=>NULL]);
    }

    public function edit(Request $request,$id){
        $document=DB::table('master_documents')->where('id',$id)->first();
        return view('superadmin.UserList.Client.Form')->with(['id'=>$id,'url'=>$this->url,'document'=>$document]);
    }

    public function store(Request $request)
    {
        $check=DB::table('master_documents')->where('document_name',$request->document_name)->first();
        if($check){
            Session::flash('alert-danger', 'Document Already Exists !!!');
            return redirect($this->url."/create");
        }

        $data['document_name']=$request->document_name;
        $data['document_type']=$request->document_type;
        if($request->type=="DOWNLOAD" || $request->type=="DOWNLOAD_UPLOAD")
        {
            $file = $request->file('document');
            $filename=$request->document_name.".".$file->getClientOriginalExtension();
            $filepath=$this->document_url."/".$filename;
            $file->move($this->document_url,$filename);
            $data['download_link']=$filepath;
        }
        $data['accepted_format']=implode(',',$request->accepted_format);
        $data['min_size']=$request->min_size;
        $data['min_size_type']=$request->min_size_type;
        $data['max_size']=$request->max_size;
        $data['max_size_type']=$request->max_size_type;

        $data['is_active']=$request->is_active;
        $data['remark']=$request->remark ? $request->remark : NULL;
        $data['created_at']=NOW();

        $insertGetId=DB::table('master_documents')->insertGetId($data);

        if($insertGetId > 0){
            $request->session()->flash('alert-success', 'Client Details Added Successfully !!! ');
            if($request->button_type && $request->button_type=="SAVE_AND_ADD_ANOTHER"){
                return redirect($this->url."/create");
            }
            return redirect($this->url);
        }else{
            $request->session()->flash('alert-warning', 'Client Details Not Added !!! ');
            return redirect($this->url."/create");
        }
    }

    public function update(Request $request, $id)
    {
        $data['document_name']=$request->document_name;
        $data['document_type']=$request->document_type;
        if($request->type=="DOWNLOAD" || $request->type=="DOWNLOAD_UPLOAD")
        {
            $file = $request->file('document');
            $filename=$request->document_name.".".$file->getClientOriginalExtension();
            $filepath=$this->document_url."/".$filename;
            $file->move($this->document_url,$filename);
            $data['download_link']=$filepath;
        }

        $data['is_active']=$request->is_active;
        $data['remark']=$request->remark ? $request->remark : NULL;
        $data['updated_at']=NOW();

        $is_updated=DB::table('master_documents')->where('id',$id)
                                                  ->update($data);

        if($is_updated > 0){
            $request->session()->flash('alert-success', 'Clients Details Updated Successfully !!! ');
            return redirect($this->url);
        }else{
            $request->session()->flash('alert-warning', 'Clients Details Not Added !!! ');
            return redirect($this->url."/".$id."/edit");
        }
    }

    public function destroy(Request $request,$id)
    {
        $is_destroyed=DB::table('users')->where('user_type','CLIENT')->where('id',$id)->update(['is_active'=>0,'updated_at'=>NOW()]);
        if($is_destroyed > 0){
            $request->session()->flash('alert-success', 'Client deleted !!! ');
        }else{
            $request->session()->flash('alert-warning', 'Client not deleted !!! ');
        }
        return redirect()->back();
    }

    public function show(Request $request)
    {
        $query = DB::table('users as u');

        if(isset($_GET['document_name']) && $_GET['document_name']){
            $document_name=$_GET['document_name'];
            $query->where(function ($q) use ($document_name) {
                    $q->where('document_name','LIKE', '%'.$document_name.'%');
                    });
        }
        $data=$query->where('u.user_type','CLIENT')
                    ->select('u.*',DB::RAW('CONCAT(u.first_name," ",u.last_name) as name'))
                    ->orderby('u.id','desc')->get();

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
