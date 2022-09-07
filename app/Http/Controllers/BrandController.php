<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;


class BrandController extends Controller
{
    public function AllBrand(){
$brands= Brand::latest()->paginate(4);
// $trachCat = Brand::onlyTrashed()->latest()->paginate(3);
 return view('admin.Brand.index',compact('brands'));
}

public function StoreBrand(Request $request){


    $validatedData = $request->validate(
        [
            'brand_name' => 'required|unique:brands|min:4',
            'brand_image' => 'required|mimes:jpg,jpeg,png',


        ],
        [
            'brand_name.required' => 'Please Input Brand Name',
            'brand_name.min' => 'Category Longer Then 4Chars',
        ]
    );

    $brand_image =$request->file('brand_image');
    $name_gen = hexdec(uniqid());
    $img_ext = strtolower($brand_image->getClientOriginalExtension());
    $img_name = $name_gen.'.'.$img_ext;
    $up_location = 'image/brand/';
    $last_img = $up_location.$img_name;
    $brand_image->move($up_location,$img_name);
    // $brand_image =$request->file('brand_image');
    // $name_gen = hexdec(uniqid()).'.'.$brand_image->getClientOriginalExtension();
    // Image::make($brand_image)->resize(300,200)->save('image/brand/',$name_gen);
    // $last_img='image/brand/'.$name_gen;
    Brand::insert([
        'brand_name'=>$request->brand_name,
        'brand_image'=>$last_img,
        'created_at'=> Carbon::now(),
    ]);


    $notification = array(
        'message' => 'Brand Inserted Successfully',
        'alert-type' => 'success'
    );

    return redirect()->back()->with('success', 'Brand Inserted Successfully');

}
public function edit($id){
$brands= Brand::find($id);
return view('admin.Brand.edit',compact('brands'));
}

public function Update(Request $request, $id){

    $validatedData = $request->validate([
        'brand_name' => 'required|min:4',

    ],
    [
        'brand_name.required' => 'Please Input Brand Name',
        'brand_image.min' => 'Brand Longer then 4 Characters',
    ]);

    $old_image = $request->old_image;

    $brand_image =  $request->file('brand_image');

    if($brand_image){

    $name_gen = hexdec(uniqid());
    $img_ext = strtolower($brand_image->getClientOriginalExtension());
    $img_name = $name_gen.'.'.$img_ext;
    $up_location = 'image/brand/';
    $last_img = $up_location.$img_name;
    $brand_image->move($up_location,$img_name);

    unlink($old_image);
    Brand::find($id)->update([
        'brand_name' => $request->brand_name,
        'brand_image' => $last_img,
        'created_at' => Carbon::now()
    ]);

    $notification = array(
        'message' => 'Brand Updated Successfully',
        'alert-type' => 'info'
    );
    return Redirect()->route('all.brand')->with($notification);

    }else{
        Brand::find($id)->update([
            'brand_name' => $request->brand_name,
            'created_at' => Carbon::now()
        ]);
        $notification = array(
            'message' => 'Brand Updated Successfully',
            'alert-type' => 'warning'
        );

        return Redirect()->route('all.brand')->with($notification);

    }
}
public function softdelete($id)
    {
        $image=Brand::find($id);
        $old_image=$image->brand_image;
        unlink($old_image);
        $delete = Brand::find($id)->forceDelete();
        return redirect()->back()->with('success', 'Brand Soft Deleted Successfully');
    }
    // public function restore($id){
    //     $delete = Brand::withTrashed()->find($id)->restore();
    //     return redirect()->back()->with('success', 'Brand Restored Successfully');

    // }
    // public function pdelete($id){
    //     $delete = Brand::onlyTrashed()->find($id)->forceDelete();
    //     return redirect()->back()->with('success', 'Brand Permanently Deleted');
    // }
    public function logout(){
        Auth::logout();
        return redirect()->route('login')->with('success','user.logout');
    }
}
