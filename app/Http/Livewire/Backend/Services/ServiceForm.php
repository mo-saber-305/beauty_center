<?php

namespace App\Http\Livewire\Backend\Services;

use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class ServiceForm extends Component
{
    public $subCategoryId;
    public $fields;
    public $categories;
    public $sub_categories;
    public $categoryId = 1;

    public $name;
    public $price;

    public function test()
    {
        Session::put('sub_category_id', 1);
    }


    public function render()
    {
        $categories = Category::all();
        $this->categories = $categories;

        $sub_categories = SubCategory::where('category_id', $this->categoryId)->get();

        $this->sub_categories = $sub_categories;

        $sub_category = SubCategory::where('category_id', $this->categoryId)->first();

        $fields = $sub_category->fields()->get();

        $this->subCategoryId = $sub_category->id;

        $this->fields = $fields;

        return view('livewire.backend.services.service-form');
    }


    public function clickSubCategory($id)
    {
        $sub_category = SubCategory::where('id', $id)->first();
        $fields = $sub_category->fields()->get();
        Session::put('sub_category_id', $id);
        $this->subCategoryId = $id;
        $this->fields = $fields;
    }

    public function changeCategory()
    {
        $sub_category = SubCategory::where('category_id', $this->categoryId)->first();

        $fields = $sub_category->fields()->get();

        $this->fields = $fields;

        Session::put('sub_category_id', $sub_category->id);
    }

    protected $rules = [
        'name' => 'required|min:6',
        'price' => 'required',
    ];

    public function submitForm()
    {
        $this->validate();
        dd($this->price);
    }

}
