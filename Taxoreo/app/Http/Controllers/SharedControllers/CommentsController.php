<?php
namespace App\Http\Controllers\SharedControllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Datatables;
use Session;
use DB;

class CommentsController extends Controller
{

    public function index(){
    }

    public function create(){

    }

    public function edit($id){

    }

    public function store(Request $request){

        $data['client_added_service_id']=$request->client_added_service_id;
        $data['comment_added_by']=Session::get('user_id');
        $data['comment']=$request->comment;
        $data['show_to_client']=$request->show_to_client ? $request->show_to_client : 0;
        $data['created_at']=now();

        $inserted_id=DB::table('user_added_service_comments')->insertGetId($data);

        if($inserted_id > 0){
            Session::flash('alert-success', 'Comment Added !!!');
        }else{
            Session::flash('alert-danger', 'Comment Not Added !!!');
        }
        return redirect()->back();
    }

    public function update(Request $request,$id){

    }

    public function destroy($id)
    {
        $is_deleted=DB::table('user_added_service_comments')->where('id',$id)->update(['is_active'=>0]);
        if($is_deleted > 0){
            Session::flash('alert-success', 'Comment Deleted !!!');
        }else{
            Session::flash('alert-danger', 'Comment Not Deleted !!!');
        }
        return redirect()->back();
    }

    public function show(Request $request)
    {

    }

}
