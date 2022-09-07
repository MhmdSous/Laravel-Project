<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\category;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    
    public function AllCat()
    {
        $categories = Category::latest()->paginate(5);
        $trachCat = category::onlyTrashed()->latest()->paginate(3);

        return view('admin.categeory.index', compact('categories', 'trachCat'));
    }


    public function AddCat(Request $request)
    {
        $validatedData = $request->validate(
            [
                'category_name' => 'required|unique:categories|max:255',

            ],
            [
                'category_name.required' => 'Please Input Category Name',
                'category_name.max' => 'Category Less Then 255Chars',
            ]
        );

        Category::insert([
            'category_name' => $request->category_name,
            'user_id' => Auth::user()->id,
            'created_at' => Carbon::now()
        ]);

        return redirect()->back()->with('success', 'Categoery Inserted Successfully');
    }

    public function edit($id)
    {
        $categories = category::find($id);
        return view('admin.categeory.edit', compact('categories'));
    }

    public function update(Request $request, $id)
    {
        $update = category::find($id)->update([
            'category_name' => $request->category_name,
            'user_id' => Auth::user()->id
        ]);

        return redirect()->route('all.category')->with('success', 'Categoery Inserted Successfully');
    }
    public function softdelete($id)
    {
        $delete = category::find($id)->delete();
        return redirect()->back()->with('success', 'Categoery Soft Deleted Successfully');
    }
    public function restore($id){
        $delete = category::withTrashed()->find($id)->restore();
        return redirect()->back()->with('success', 'Categoery Restored Successfully');

    }
    public function pdelete($id){
        $delete = category::onlyTrashed()->find($id)->forceDelete();
        return redirect()->back()->with('success', 'Categoery Permanently Deleted');
    }
}
