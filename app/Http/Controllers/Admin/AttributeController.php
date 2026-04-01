<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Attribute;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AttributeController extends Controller
{
    function index()
    {
        $attributes = Attribute::orderBy('name')->paginate(10); //'default_pagination')
        return view('admin-views.attribute.index', compact('attributes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:attributes|max:100',
        ], [
            'name.required' => trans('messages.Name is required!'),
        ]);

        $attribute = new Attribute;
        $attribute->name = $request->name;
        $attribute->save();

        Toastr::success(trans('messages.attribute_added_successfully'));
        return back();
    }

    public function edit($id)
    {
        $attribute = Attribute::findOrFail($id);
        return view('admin-views.attribute.edit', compact('attribute'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:100|unique:attributes,name,'.$id,
        ], [
            'name.required' => trans('messages.Name is required!'),
        ]);

        $attribute = Attribute::findOrFail($id);
        $attribute->name = $request->name;
        $attribute->save();
        Toastr::success(trans('messages.attribute_updated_successfully'));
        return back();
    }

    public function delete(Request $request)
    {
        $attribute = Attribute::findOrFail($request->id);
        $attribute->delete();
        Toastr::success(trans('messages.attribute_deleted_successfully'));
        return back();
    }

    public function search(Request $request){
        $key = explode(' ', $request['search']);
        $attributes=Attribute::where(function ($q) use ($key) {
            foreach ($key as $value) {
                $q->orWhere('name', 'like', "%{$value}%");
            }
        })->limit(50)->get();
        return response()->json([
            'view'=>view('admin-views.attribute.partials._table',compact('attributes'))->render(),
            'count'=>$attributes->count(),
        ]);
    }



}
