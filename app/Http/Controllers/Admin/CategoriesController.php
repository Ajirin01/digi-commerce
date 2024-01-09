<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
// use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

use App\Models\Category as Category;
use Validator;
use Session;

class CategoriesController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('Admin.Categories.category_list', ['categories'=> $categories]);
    }
    
    public function create()
    {
        $categories = Category::all();
        return view('Admin.Categories.category_creation_form',['categories'=> $categories]);

    }
    
    // public function store(Request $request)
    // {
    //     $rule = [
    //         'name'=> 'required| min:3| max: 191'
    //     ];
    //     $data = array();
    //     $data['name'] = $request->name;
        
    //     $valid = Validator::make($request->all(),$rule);

    //     if($valid->fails()){
    //         // return response()->json($valid->errors());
    //         return redirect()->back()->with('errors',$valid->errors());
    //     }else{
    //         $create_category = Category::create($data);

    //         if($create_category){
    //             return redirect()->back()->with('success','record created!');
    //         }else{
    //             return redirect()->back()->with('errors','could not create record');
    //         }
    //     }
    //     // return response()->json($request->all());
    // }

    public function show($id)
    {
        //
    }
    
    public function edit($id)
    {
        // echo $id;
        // exit;
        $category = Category::find($id);
        $categories = Category::all();
        // return response()->json($category);
        return view('Admin.Categories.category_edit_form',['category'=> $category, 'categories'=> $categories]);
        
    }
    
    // public function update(Request $request, $id)
    // {
    //     // echo $id;
    //     // exit;
    //     // $category_name = Category::where('name', $request->name)->
    //     $category_to_update = Category::find($id);

    //     // return response()->json($category_to_update);
    //     // return response()->json($request->all());

    //     $update_category = $category_to_update->update($request->all());

    //     if($update_category){
    //         return redirect()->back()->with('success', 'Category successfully updated!');
    //     }else {
    //         return redirect()->back()->with('errors', 'Category could not successfully updated!');

    //     }
    //     // return response()->json($request->all());
    // }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|min:3|max:191',
            'parent_id' => 'nullable|exists:categories,id', // Check if the provided parent_id exists in the categories table
            // 'photo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Adjust file types and size as needed
        ];

        $data = $request->validate($rules);

        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('category_photos', 'public');
            $data['photo'] = $photoPath;
        }

        $createCategory = Category::create($data);

        return redirect()->back()->with($createCategory ? 'success' : 'error', $createCategory ? 'Record created!' : 'Could not create record');
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'name' => 'required|min:3|max:191',
            'parent_id' => 'nullable|exists:categories,id', // Check if the provided parent_id exists in the categories table
            // 'photo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Adjust file types and size as needed
        ];

        $data = $request->validate($rules);

        $categoryToUpdate = Category::find($id);

        if ($request->hasFile('photo')) {
            // Delete existing photo if it exists
            if ($categoryToUpdate->photo) {
                Storage::disk('public')->delete($categoryToUpdate->photo);
            }

            $photoPath = $request->file('photo')->store('category_photos', 'public');
            $data['photo'] = $photoPath;
        }

        $updateCategory = $categoryToUpdate->update($data);

        return redirect()->back()->with($updateCategory ? 'success' : 'error', $updateCategory ? 'Category successfully updated!' : 'Could not update category');
    }

    public function destroy($id)
    {
        $categoryToDelete = Category::find($id);

        // Delete associated photo
        if ($categoryToDelete->photo) {
            Storage::disk('public')->delete($categoryToDelete->photo);
        }

        $deleteCategory = $categoryToDelete->delete();

        return redirect()->back()->with($deleteCategory ? 'success' : 'error', $deleteCategory ? 'Category successfully deleted!' : 'Could not delete category');
    }
}
