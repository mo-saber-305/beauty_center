<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\FieldService;
use App\Models\Section;
use App\Models\Service;
use App\Models\ServiceImage;
use App\Models\SubCategory;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApiController extends Controller
{
    use GeneralTrait;

    //get all sections
    public function sections(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'route_token' => 'required',
            ]);

            if ($validator->fails()) {
                return apiResponse('e400', false, $validator->errors()->first());
            }

            if ($request['route_token'] == env('ROUTE_TOKEN')) {
                $sections = Section::all();

                if (count($sections)) {
                    return apiResponse('e200', true, 'تم استرجاع البيانات بنجاح', $sections);
                }
                return apiResponse('e300', false, 'للاسف لا توجد بيانات حاليا');
            } else {
                return apiResponse('e400', false, 'من فضلك ضع توكين صحيح');
            }

        } catch (\Exception $ex) {
            return apiResponse('e500', false, $ex->getMessage());
        }
    }

    //get all categories where('section_id', $section_id)
    public function categories(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'route_token' => 'required',
                'section_id' => 'required',
            ]);

            if ($validator->fails()) {
                return apiResponse('e400', false, $validator->errors()->first());
            }

            if ($request['route_token'] == env('ROUTE_TOKEN')) {
                $categories = Category::where('section_id', $request['section_id'])->get();

                if (count($categories)) {
                    return apiResponse('e200', true, 'تم استرجاع البيانات بنجاح', $categories);
                }
                return apiResponse('e300', false, 'للاسف لا توجد بيانات حاليا');
            } else {
                return apiResponse('e400', false, 'من فضلك ضع توكين صحيح');
            }

        } catch (\Exception $ex) {
            return apiResponse('e500', false, $ex->getMessage());
        }
    }

    //get all sub categories where('category_id', $category_id)
    public function subCategories(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'route_token' => 'required',
                'category_id' => 'required',
            ]);

            if ($validator->fails()) {
                return apiResponse('e400', false, $validator->errors()->first());
            }

            if ($request['route_token'] == env('ROUTE_TOKEN')) {
                $subCategories = SubCategory::where('category_id', $request['category_id'])->get();

                if (count($subCategories)) {
                    return apiResponse('e200', true, 'تم استرجاع البيانات بنجاح', $subCategories);
                }
                return apiResponse('e300', false, 'للاسف لا توجد بيانات حاليا');
            } else {
                return apiResponse('e400', false, 'من فضلك ضع توكين صحيح');
            }

        } catch (\Exception $ex) {
            return apiResponse('e500', false, $ex->getMessage());
        }
    }

    //get fields where('sub_category_id', $subCategory_id)
    public function fields(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'route_token' => 'required',
                'sub_category_id' => 'required',
            ]);

            if ($validator->fails()) {
                return apiResponse('e400', false, $validator->errors()->first());
            }


            if ($request['route_token'] == env('ROUTE_TOKEN')) {

                $subCategories = SubCategory::where('id', $request['sub_category_id'])->first();

                if ($subCategories) {
                    $fields = $subCategories->fields()->get();
                    if (count($fields)) {
                        $data = [];
                        foreach ($fields as $field) {
                            $data[] = [
                                'id' => $field['id'],
                                'name' => $field['name'],
                                'type' => $field['type'],
                                'created_at' => $field['created_at'],
                                'updated_at' => $field['updated_at'],
                            ];
                        }
                        return apiResponse('e200', true, 'تم استرجاع البيانات بنجاح', $data);
                    }
                    return apiResponse('e300', false, 'للاسف لا توجد بيانات حاليا');
                }
                return apiResponse('e300', false, 'للاسف لا توجد بيانات حاليا');
            } else {
                return apiResponse('e400', false, 'من فضلك ضع توكين صحيح');
            }

        } catch (\Exception $ex) {
            return apiResponse('e500', false, $ex->getMessage());
        }
    }

    //get services where('sub_category_id', $subCategory_id)
    public function services(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'route_token' => 'required',
                'sub_category_id' => 'required',
            ]);

            if ($validator->fails()) {
                return apiResponse('e400', false, $validator->errors()->first());
            }


            if ($request['route_token'] == env('ROUTE_TOKEN')) {

                $subCategories = SubCategory::where('id', $request['sub_category_id'])->first();

                if ($subCategories) {
                    $services = $subCategories->services()->with('fields')->get();

                    if (count($services)) {
                        $data = [];

                        foreach ($services as $service) {
                            /* هنا بقي بنجيب الفيلدس اللي تبع السيرفيس دي */
                            $fields = $service->fields()->withPivot('value')->get();
                            $fields_data = [];
                            foreach ($fields as $field) {
                                $fields_data[] = [
                                    'id' => $field->id,
                                    'name' => $field->name,
                                    'value' => $field->pivot->value,
                                    'type' => $field->type
                                ];
                            }

                            /* هنا يامعلم بنجيب الصور اللي تبع السيرفس دي لانها محفوظه في تابل تانيه مختلفه */
                            $images = [];
                            foreach ($service->images()->get() as $item) {
                                $images[] = [
                                    'id' => $item->id,
                                    'image' => asset($item->image),
                                ];
                            }

                            $data[] = [
                                'id' => $service['id'],
                                'category_id' => $service['category_id'],
                                'sub_category_id' => $service['sub_category_id'],
                                'fields' => $fields_data,
                                'images' => count($images) ? $images : null
                            ];
                        }

                        return apiResponse('e200', true, 'تم استرجاع البيانات بنجاح', $data);
                    }
                    return apiResponse('e300', false, 'للاسف لا توجد بيانات حاليا');
                }
                return apiResponse('e300', false, 'للاسف لا توجد بيانات حاليا');
            } else {
                return apiResponse('e400', false, 'من فضلك ضع توكين صحيح');
            }

        } catch (\Exception $ex) {
            return apiResponse('e500', false, $ex->getMessage());
        }
    }

    //add new service
    public function addNewService(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'route_token' => 'required',
                'category_id' => 'required',
                'sub_category_id' => 'required',
                'fields' => 'required',
            ]);

            if ($validator->fails()) {
                return apiResponse('e400', false, $validator->errors()->first());
            }

            if ($request['route_token'] == env('ROUTE_TOKEN')) {
                /* هنا بقي بنحفظ الداتا بتاعة السيرفس بس مش كلها لان في داتا تانيه في جداول مختلفه */
                $service = Service::create([
                    'category_id' => $request['category_id'],
                    'sub_category_id' => $request['sub_category_id']
                ]);

                /* هنا بقي بنحفظ الداتا بتاعة الفيلدس اللي تبع السيرفس */
                foreach ($request['fields'] as $field) {
                    FieldService::create([
                        'field_id' => $field['id'],
                        'service_id' => $service->id,
                        'value' => $field['value'],
                    ]);
                }

                /* هنا بقي بنتشيك الاول لو في صور مبعوته في الريكويست لانها اكتر من صوره والصور دي برضو تبع السيرفيس بس في جدول تاني معلش اصل السيرفيس عندنا متعبه شويه  */
                if ($request->has('images')) {
                    foreach ($request['images'] as $image) {
                        $filePath = $this->uploadImage('services', $image);
                        ServiceImage::create([
                            'service_id' => $service->id,
                            'image' => $filePath
                        ]);
                    }
                }

                return apiResponse('e200', true, 'تم حفظ البيانات بنجاح');
            } else {
                return apiResponse('e400', false, 'من فضلك ضع توكين صحيح');
            }

        } catch (\Exception $ex) {
            return apiResponse('e500', false, $ex->getMessage());
        }
    }
}
