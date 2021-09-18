<?php

namespace App\Http\Livewire\Backend\Services;

use App\Models\Category;
use App\Models\Field;
use App\Models\FieldService;
use App\Models\Service;
use App\Models\SubCategory;
use Livewire\Component;
use Livewire\WithFileUploads;
use Stichoza\GoogleTranslate\GoogleTranslate;

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

        foreach ($fields as $field) {
            if ($field->type == 'image') {
                $rulesValidate['images'] = 'required';
                $rulesValidate['images.*'] = ['image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'];
            } elseif ($field->type == 'int') {
                $rulesValidate['myForm.' . $field->key] = ['required', 'numeric'];
            } else {
                $rulesValidate['myForm.' . $field->key] = ['required'];
            }
        }

        $this->validate($rulesValidate);

        /*saving service*/
        $service = Service::create([
            'category_id' => $this->categoryId,
            'sub_category_id' => $this->subCategoryId
        ]);

        /*saving fields*/
        $lang = app()->getLocale();

        $fieldService = [];

        foreach ($this->myForm as $key => $value) {
            $field = Field::where('key', $key)->first();
            /*translate only fields has type tex or varchar*/
            if ($field->type == 'varchar' || $field->type == 'text') {
                /*translate fields before save*/
                if ($lang == 'ar') {
                    $value_ar = $value;
                    $value_en = GoogleTranslate::trans($value, 'en', 'ar');
                } else {
                    $value_ar = GoogleTranslate::trans($value, 'ar', 'en');
                    $value_en = $value;
                }
            } else {
                $value_ar = $value;
                $value_en = $value;
            }
            $fieldService[] = [
                'field_id' => $field->id,
                'service_id' => $service->id,
                'value_ar' => $value_ar,
                'value_en' => $value_en,
            ];

        }

        FieldService::insert($fieldService);

        $this->alert('success', trans('backend.added_successfully'));

        $this->myForm = [];

    }

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

}
