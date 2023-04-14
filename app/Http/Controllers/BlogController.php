<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Category;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Validator;
use Auth;

class BlogController extends Controller
{
    public function index()
    {
        $categories = Category::get();
        return view('admin.dashboard',compact('categories'));
    }

    public function getblogs(Request $request)
    {
        $userId = Auth::id();
        if ($request->ajax()) {
            $data = Blog::latest()->where('user_id',$userId)->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('image', function ($data) {
                    $url = asset('images/blogthumb/'.$data->image);
                    return '<img src="'.$url.'" border="0" width="40" class="img-rounded" align="center" />';
                })
                ->addColumn('category', function ($data) {
                    return $data->category->title;
                })
                ->addColumn('action', function($data){
                    
                    $actionBtn = '<a href="javascript:void(0)" id="editBlogBtn" class="btn btn-gray text-blue btn-sm" data-toggle="modal" data-target="#BlogModal" onclick="" data-id="' .$data->id. '" class="edit btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" id="deleteBlogBtn" data-toggle="modal" data-target="#DeleteBlogModal" onclick="" data-id="' .$data->id. '" class="delete btn btn-danger btn-sm">Delete</a>';
                    return $actionBtn;
                })

                ->rawColumns(['category','image','action'])
                ->make(true);
        }
    }

    public function addorupdateblog(Request $request){
        //dd($request->all());
        $userId = Auth::id();
        $messages = [
            'title.required' =>'Please provide a Term Name',
            'blogthumb.image' =>'Please provide a Valid Extension Image(e.g: .jpg .png)',
            'blogthumb.mimes' =>'Please provide a Valid Extension Image(e.g: .jpg .png)',
        ];

        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'blogthumb' => 'image|mimes:jpeg,png,jpg',
        ], $messages);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(),'status'=>'failed']);
        }
        if(isset($request->action) && $request->action=="update"){
            $action = "update";
            $blog = Blog::find($request->blog_id);
            

            if(!$blog){
                return response()->json(['status' => '400']);
            }

            $old_image = $blog->image;
            $image_name = $old_image;
            $blog->title = $request->title;
            $blog->category_id = $request->category_id;
            $blog->description = $request->description;
        }
        else{
            $action = "add";
            $blog = new Blog();
            $blog->title = $request->title;
            $blog->category_id = $request->category_id;
            $blog->created_at = new \DateTime(null, new \DateTimeZone('Asia/Kolkata'));
            $image_name=null;
            $blog->description = $request->description;
            $blog->user_id = $userId;
        }

        if ($request->hasFile('blogthumb')) {
            $image = $request->file('blogthumb');
            $image_name = 'blogthumb_' . rand(111111, 999999) . time() . '.' . $image->getClientOriginalExtension();
            // $destinationPath = public_path('images/blogthumb');
            // $image->move($destinationPath, $image_name);
            $destinationPath = public_path('images/blogthumb/'.$image_name);
            $imageTemp = $_FILES["blogthumb"]["tmp_name"];
            
           
            $destinationPath = public_path('images/blogthumb');
            $image->move($destinationPath, $image_name);  
           
            if(isset($old_image)) { 
                $old_image = public_path('images/blogthumb/' . $old_image);
                if (file_exists($old_image)) {
                    unlink($old_image);
                }
            }
            $blog->image = $image_name;
        }

        $blog->save();

        return response()->json(['status' => '200', 'action' => $action]);
    }

    public function editblog($id){
        $blog = blog::find($id);
        return response()->json($blog);
    }

    public function deleteblog($id){
        $blog = blog::find($id);
        if ($blog){
            $blog->delete();
            return response()->json(['status' => '200']);
        }
        return response()->json(['status' => '400']);
    }

    public function blogs()
    {
        $categories = Category::get();
        return view('blogs',compact('categories'));
    }

    public function allblogs(Request $request)
    {
        
        $data = $request->all();
        $query = Blog::whereNotNull('title');

        if(isset($data["category"]) && $data["category"]){
            $query = $query->where('category_id',$data["category"]);
        }

        if(isset($data["search"]) && $data["search"]){
            $query = $query->where('title', 'like', '%' . $data["search"] . '%');
        }

        $results = $query->get();

        $artilces = '';
        if ($request->ajax()) {
            foreach ($results as $blog) {
                $Category = Category::where('id',$blog->category_id)->first();
                $artilces.='<div class="col-sm-6 col-md-6 col-lg-4 col-xxl-3 mb-4"><div class="card">
                <img class="card-img-top" src="'. url("images/blogthumb/".$blog->image) .'" alt="Card image cap">
                <div class="card-body">
                  <h5 class="card-title">'. $blog->title .'</h5>
                  <p class="card-text">'. $blog->description .'</p>
                  <p class="card-text"><small class="text-muted">'. $Category->title .'</small></p>
                </div>
                </div>
              </div>';
            }
        }

       $data = $artilces;  
       return $data;
      
    }
}
