<?php

namespace App\Http\Controllers\Admin;

use App\Models\Tag;
use Brian2694\Toastr\Facades\Toastr;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function index()
    {
        $tags = Tag::latest()->get();
        return view('admin.tag.index',compact('tags'));
    }
    public function create()
    {
        return view('admin.tag.create');
    }
    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required'
        ]);
        $tag = new Tag();
        $tag->name = $request->name;
        $tag->slug = str_slug($request->name);
        $tag->save();
        Toastr::success('Tag Successfully Saved :)' ,'Success');
        return redirect()->route('admin.tag.index');
    }
    public function edit($id)
    {
        $tag = Tag::find($id);
        return view('admin.tag.edit',compact('tag'));
    }
    public function update(Request $request, $id)
    {
        $tag = Tag::find($id);
        $tag->name = $request->name;
        $tag->slug = str_slug($request->name);
        $tag->save();
        Toastr::success('Tag Successfully Updated :)','Success');
        return redirect()->route('admin.tag.index');
    }
    public function destroy($id)
    {
        Tag::find($id)->delete();
        Toastr::success('Tag Successfully Deleted :)','Success');
        return redirect()->back();
    }
}
