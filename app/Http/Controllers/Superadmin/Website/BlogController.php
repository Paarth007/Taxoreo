<?php
namespace App\Http\Controllers\Superadmin\Website;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Datatables;
use Session;
use DB;


class BlogController extends Controller
{
    public $url="superadmin/website/blog";
    public $blog_attachment_path="website/blogs/";

    public function index(){
        return view('Superadmin.Website.Blog.Index')->with(['url'=>$this->url]);
    }

    public function create(){
        return view('Superadmin.Website.Blog.Form')->with(['id'=>NULL,
                                                            'url'=>$this->url,
                                                            'blog'=>NULL]);
    }

    public function edit(Request $request,$id){
        $blog=DB::table('website_blogs')->where('id',$id)->first();
        return view('Superadmin.Website.Blog.Form')->with(['id'=>$id,
                                                            'url'=>$this->url,
                                                            'blog'=>$blog]);
    }

    public function store(Request $request)
    {
        if($request->hasFile('attachment_url')){
            $file = $request->file('attachment_url');
            $filename=date('Ymdhis').".".$file->getClientOriginalExtension();
            $file->move($this->blog_attachment_path,$filename);
            $request->attachment_url=$this->blog_attachment_path."/".$filename;
        }

        $id=DB::table('website_blogs')->insertGetId([
                                            'blog_title'=>$request->blog_title,
                                            'blog_slug'=>$request->blog_slug,
                                            'attachment_url'=>$request->attachment_url,
                                            'description'=>$request->description,
                                            'is_active'=>$request->is_active,
                                            'remark'=>$request->remark ? $request->remark : NULL,
                                            'created_at'=>now()
                                            ]);
        if($id > 0){
            Session::flash('alert-success', 'Blog Added Successfully !!!');
            return redirect($this->url);
        }else{
            Session::flash('alert-danger', 'Blog Not Added !!!');
            return redirect($this->url."/create");
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
            'blog_title'=>$request->blog_title,
            'blog_slug'=>$request->blog_slug,
            'description'=>$request->description,
            'is_active'=>$request->is_active,
            'remark'=>$request->remark ? $request->remark : NULL,
            'updated_at'=>now()
        ]);


        $update=DB::table('website_blogs')->where('id',$id)->update($dataArray);
        if($update > 0){
            Session::flash('alert-success', 'Blog Updated Successfully !!!');
            return redirect($this->url);
        }else{
            Session::flash('alert-danger', 'Blog Not Updated !!!');
            return redirect($this->url."/".$id."/edit");
        }
    }


    public function show(){
        $query = DB::table('website_blogs');
        $data = $query->where('is_active',1)
                      ->orderby('id','desc')
                      ->get();
        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('blog_slug', function($row){
                $slug = wordwrap($row->blog_slug,20, "\n", true);
                $slug = htmlentities($slug);
                $slug = nl2br($slug);
                return  mb_convert_encoding($slug,'UTF-8', 'UTF-8');
            })
            ->addColumn('description', function($row){
                    $text=strip_tags($row->description);
                    $add='<i class="fas fa-arrow-circle-right" onclick="get_description('.$row->id.')">';
                    return mb_convert_encoding($text,'UTF-8', 'UTF-8') .' '.$add;
            })
            ->addColumn('attachment_url', function($row){
                return $row->attachment_url ? '<div>
                                                <img src="'.asset($row->attachment_url).'" style="height:50px;width:auto">
                                               </div>' : "<b>Not Found</b>";
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
            ->rawColumns(['select_checkbox','blog_slug','description','attachment_url','is_active','action'])
            ->make(true);
    }

}
