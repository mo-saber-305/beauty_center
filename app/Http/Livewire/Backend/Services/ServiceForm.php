<?php

namespace App\Http\Livewire\Backend\Services;

use App\Models\Category;
use App\Models\Field;
use App\Models\FieldService;
use App\Models\Service;
use App\Models\SubCategory;
use Livewire\Component;
use Livewire\WithFileUploads;

class ServiceForm extends Component
{
    use WithFileUploads;

    public $subCategoryId = 1;
    public $fields;
    public $categories;
    public $sub_categories;
    public $categoryId = 1;
    public $myForm;
    public $images = [];
    public $test;


    public function render()
    {
        /*get all categories*/
        $categories = Category::all();
        $this->categories = $categories;

        /*get all sub categories*/
        $sub_categories = SubCategory::where('category_id', $this->categoryId)->get();
        $this->sub_categories = $sub_categories;

        /*get  sub category then get all her own fields */
        $sub_category = SubCategory::where('category_id', $this->categoryId)->first();
        $fields = $sub_category->fields()->get();
        $this->fields = $fields;

        return view('livewire.backend.services.service-form');
    }

    /*when click on sub category button get her own fields*/
    public function clickSubCategory($id)
    {
        $sub_category = SubCategory::where('id', $id)->first();
        $fields = $sub_category->fields()->get();
        $this->subCategoryId = $id;
        $this->fields = $fields;
        $this->resetErrorBag();
        $this->resetValidation();
    }

    /*when category changed the sub category change and fields*/
    public function changeCategory()
    {
        $sub_category = SubCategory::where('category_id', $this->categoryId)->first();
        $fields = $sub_category->fields()->get();
        $this->fields = $fields;

        $this->subCategoryId = $sub_category->id;

        /*to reset validation errors in inputs after changed*/
        $this->resetErrorBag();
        $this->resetValidation();
    }


    /*save fields data and create new service*/
    public function submitForm()
    {
        /*validate data*/
        $sub_category = SubCategory::where('category_id', $this->categoryId)->first();
        $fields = $sub_category->fields()->get();

        $rulesValidate = [];

//        foreach ($fields as $field) {
//            if ($field->type == 'image') {
//                $ruleData = ['image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'];
//            } elseif ($field->type == 'int') {
//                $ruleData = ['required', 'numeric'];
//            } else {
//                $ruleData = ['required'];
//            }
//
//            if ($field->type == 'image') {
//                $rulesValidate['images'] = 'required';
//                $rulesValidate['images.*'] = $ruleData;
//            }
//
//            $rulesValidate['myForm.' . $field->name] = $ruleData;
//        }
//
//        $this->validate($rulesValidate);

        /*saving service*/
        $service = Service::create([
            'category_id' => $this->categoryId,
            'sub_category_id' => $this->subCategoryId
        ]);

        /*saving fields*/
        foreach ($this->myForm as $key => $value) {
            $fieldId = Field::where('name', $key)->first()->id;
            FieldService::create([
                'field_id' => $fieldId,
                'service_id' => $service->id,
                'value' => $value,
            ]);
        }

        dd($service);
    }
}
