<?php

namespace App\Http\Controllers\admin;

use App\Exports\ExportSubCategory;
use App\Http\Controllers\Controller;
use App\Imports\SubCategoryImport;
use App\Models\Category;
use App\Models\subCategory;
use PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class SubCategoryController extends Controller
{

    public function index(Request $request){
        $subCategories = subCategory::select('sub_categories.*','categories.name as categoryName')
                        ->oldest('sub_categories.id')
                        ->leftJoin('categories','categories.id','sub_categories.category_id');
                        
        if(!empty($request->get('keyword'))){
             $subCategories = $subCategories->where('sub_categories.name','like','%'.$request->get('keyword').'%');
             $subCategories = $subCategories->orWhere('categories.name','like','%'.$request->get('keyword').'%');
        }
        $subCategories = $subCategories->paginate(10);
        
        return view('admin.sub_category.list',compact('subCategories'));
    }
    
    public function create(){
        $categories = Category::orderBy('name', 'ASC')->get();
        $data['categories'] = $categories;
        return view('admin.sub_category.create',$data);
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'slug' => 'required|unique:sub_categories',
            'category' => 'required',
            'status' => 'required',
        ]);

        if ($validator->passes()){

            $subCategory = new subCategory();
            $subCategory->name = $request->name;
            $subCategory->slug = $request->slug;
            $subCategory->status = $request->status;
            $subCategory->showHome = $request->showHome;
            $subCategory->category_id = $request->category;
            $subCategory->save();

            $request->session()->flash('success','Sub Category Created Successfully.');

            return response([
                'status' => true,
                'message' => 'Sub Category Created Successfully.'
            ]);

        }else {
            return response([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    public function edit($id, Request $request){
        
        $subCategory = subCategory::find($id);
        if (empty($subCategory)) {
            $request->session()->flash('error','Record Not Found');
            return redirect()->route('sub-categories.index');
        }

        $categories = Category::orderBy('name', 'ASC')->get();
        $data['categories'] = $categories;
        $data['subCategory'] = $subCategory;
        return view('admin.sub_category.edit',$data);
    }

    public function update($id, Request $request){
        
        $subCategory = subCategory::find($id);
        
         if (empty($subCategory)) {
                $request->session()->flash('error','Record Not Found');
                return response([
                    'status' => false,
                    'notFound' =>true
                ]);
            }

        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'slug' => 'required|unique:sub_categories,slug,'.$subCategory->id.',id',
            'category' => 'required',
            'status' => 'required',
        ]);

        if ($validator->passes()){

            $subCategory->name = $request->name;
            $subCategory->slug = $request->slug;
            $subCategory->status = $request->status;
            $subCategory->showHome = $request->showHome;
            $subCategory->category_id = $request->category;
            $subCategory->save();

            $request->session()->flash('success','Sub Category Updated Successfully.');

            return response([
                'status' => true,
                'message' => 'Sub Category Updated Successfully.'
            ]);

        }else {
            return response([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    public function destroy($id, Request $request){
        $subCategory = subCategory::find($id);
        
         if (empty($subCategory)) {
                $request->session()->flash('error','Record Not Found');
                return response([
                    'status' => false,
                    'notFound' =>true
                ]);
            }

            $subCategory->delete();

            $request->session()->flash('success','Sub Category Deleted Successfully.');

            return response([
                'status' => true,
                'message' => 'Sub Category Deleted Successfully.'
            ]);
    }

    public function export_excel(){
       return Excel::download(new ExportSubCategory, "sub category.xlsx");
    }

    public function import_excel()
    {
        try {
            Excel::import(new SubCategoryImport, request()->file('file'));
            session()->flash('success', 'Excel file imported successfully.');
        } catch (\Exception $e) {
            session()->flash('error', 'Error importing Excel file: ' . $e->getMessage());
        }

        return back();
    }

    public function export_pdf()
    {
        // Retrieve order details and customer information
        $subCategories = subCategory::select('sub_categories.*','categories.name as categoryName')
                        ->leftJoin('categories','categories.id','sub_categories.category_id')
                        ->get();
        $data['subCategories'] = $subCategories;
        $now = Carbon::now()->format('Y-m-d');
        $data['now'] = $now;

        // Generate the PDF
        $pdf = PDF::loadView('admin.report.subCategory', compact('data'));

        // Set options if needed (e.g., page size, orientation)
        $pdf->setPaper('A4', 'potrait');
        
        // Download the PDF with a specific filename
        return $pdf->stream('Sub Category.pdf');
    }
}