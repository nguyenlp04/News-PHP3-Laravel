<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query=DB::table('categories')->get();
        return view('admin.category.category',['data'=>$query]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // $query=DB::table('categories')->get();
        // return view('admin.category.category',['data'=>$query]);
    }

    public function updateStatus(Request $request)
    {
        $category = Category::find($request->id);
        if ($category) {
            $category->status = $request->has('status') ? 1 : 0;
            $category->save();
            return redirect()->back()->with('alert', [
                'type' => 'success',
                'message' => 'Category status updated successfully.'
            ]);
        }
        return redirect()->back()->with('alert', [
            'type' => 'error',
            'message' => 'Failed to update category status.'
        ]);
    }
    
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validatedData=$request->validate([
                'name'=>'required|string|max:100',
                'description'=>'required|string|max:500',
            ]);
            $query=DB::table('categories')->insert([
                'name'=>$validatedData['name'],
                'description'=>$validatedData['description'],
                'status'=>1,
                'created_at' => now(),
            ]);
            if($query > 0){
                return redirect()->back()->with('alert', [
                    'type' => 'success',
                    'message' => 'Category added successfully!'
                ]);

            }else{
                return redirect()->back()->with('alert', [
                    'type' => 'error',
                    'message' => 'Failed to add category. Please try again.'
                ]);
            }
        } catch (\Throwable $th) {

            return redirect()->back()->with('alert', [
                'type' => 'error',
                'message' => 'Có lỗi xảy ra : ' . $th->getMessage()
            ]);

        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $query=DB::table('categories')
        ->where('id', $id)
        ->first();
        $query1=DB::table('categories')->get();
        // return view('admin.category.category',['data'=>$query]);
        return view('admin.category.category',['dataId'=>$query,'data'=>$query1]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // $query=DB::table('categories')->where('id',$id)->first();
        // $query1=DB::table('categories')->get();
        // return view('admin.category.category',['dataId'=>$query,'data'=>$query1]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $check=DB::table('categories')->where('id', $id)->first();
        try {
            $validatedData=$request->validate([
                'name'=>'required|string|max:100',
                'description'=>'required|string|max:500',
            ]);
            $query=DB::table('categories')->where('id',$id)->update([
                'name'=>$validatedData['name'],
                'description'=>$validatedData['description'],
                'updated_at'=>now(),
            ]);
            if($query > 0){
                return redirect()->back()->with('alert', [
                    'type' => 'success',
                    'message' => ' Cập nhật thành công !'
                    
                ]);

            }else{
                return redirect()->back()->with('alert', [
                    'type' => 'error',
                    'message' => ' Bạn chưa thay đổi dữ liệu nào !'
                ]);
            }
        } catch (\Throwable $th) {

            return redirect()->back()->with('alert', [
                'type' => 'error',
                'message' => 'Có lỗi xảy ra : ' . $th->getMessage()
            ]);

        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $category = Category::find($id);
            if ($category) {
                $category->delete();
                return redirect()->back()->with('alert',[
                    'type'=>'success',
                    'message'=>'Category deleted successfully!'
            ]);
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('alert',[
                'type'=>'error',
                'message'=>' Lỗi : '.$th->getMessage()
        ]);
        }
    }
}
