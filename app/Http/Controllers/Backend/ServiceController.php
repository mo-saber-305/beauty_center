<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        $sub_category = SubCategory::where('id', 1)->first();
        $fields = $sub_category->services()->first();

        dd($fields->fields()->withPivot('value')->get());
        $services = Service::where('id', $request->get('ser'))->with('fields')->first();
        $fields = $services->fields()->withPivot('value')->get();

        return view('backend.pages.services.index', compact('fields'));
    }

    public function create(Request $request)
    {

        return view('backend.pages.services.create');
    }

    public function store(Request $request)
    {
        dd($request->all());
        $services = Service::where('id', $request->get('ser'))->with('fields')->first();
        $fields = $services->fields()->get();

//        dd($fields);
        return view('backend.pages.services.index', compact('fields'));
    }
}
