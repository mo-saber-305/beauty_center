<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\FieldService;
use App\Models\Section;
use App\Models\Service;
use App\Models\ServiceImage;
use App\Models\SubCategory;
use App\Models\User;
use App\Models\UserVerification;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Mail;

class ApiController extends Controller
{
    use GeneralTrait;

    // login method
    public function login(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'route_token' => 'required',
                'email' => 'required|email',
                'password' => 'required',
            ]);

            if ($validator->fails()) {
                return apiResponse('e400', false, $validator->errors()->first());
            }

            if ($request['route_token'] == env('ROUTE_TOKEN')) {
                $credentials = $request->only('email', 'password');

                if (!$token = auth('api')->attempt($credentials)) {
                    return apiResponse('e100', false, 'خطأ في تسجيل الدخول من فضلك حاول مره اخري');
                }

                return $this->respondWithToken($token);
            } else {
                return apiResponse('e400', false, 'من فضلك ضع توكين صحيح');
            }
        } catch (\Exception $ex) {
            return apiResponse('e500', false, $ex->getMessage());
        }
    }

    // register method
    public function register(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'route_token' => 'required',
                'name' => 'required',
                'email' => 'required|email|unique:users',
                'password' => 'required|confirmed',
                'phone' => 'required|regex:/(01)[0-9]{9}/',
                'birth_day' => 'required|date',
                'gender' => 'required'
            ]);

            if ($validator->fails()) {
                return apiResponse('e400', false, $validator->errors()->first());
            }

            if ($request['route_token'] == env('ROUTE_TOKEN')) {
                $name = $request['name'];
                $email = $request['email'];
                $password = $request['password'];
                $user = User::create([
                    'name' => $name,
                    'email' => $email,
                    'password' => bcrypt($password),
                    'phone' => $request['phone'],
                    'birth_day' => $request['birth_day'],
                    'gender' => $request['gender'],
                ]);

                $verification_code = random_int(100000, 999999); //Generate verification code

                // save code in user_verifications table
                UserVerification::create(['user_id' => $user->id, 'code' => $verification_code]);

                $subject = "Please verify your email address.";
                Mail::send('email.verify', ['name' => $name, 'verification_code' => $verification_code],
                    function ($mail) use ($email, $name, $subject) {
                        $mail->from(env('MAIL_FROM_ADDRESS'), "From User/Company Name Goes Here");
                        $mail->to($email, $name);
                        $mail->subject($subject);
                    });

//                $credentials = $request->only(['email', 'password']);
//
//                if (!$token = auth('api')->attempt($credentials)) {
//                    return apiResponse('e100', false, 'خطأ في تسجيل الدخول من فضلك حاول مره اخري');
//                }

//                return $this->respondWithToken($token);
                return apiResponse('e200', true, 'تم ارسال الكود بنجاح', $verification_code);
            } else {
                return apiResponse('e400', false, 'من فضلك ضع توكين صحيح');
            }
        } catch (\Exception $ex) {
            return apiResponse('e500', false, $ex->getMessage());
        }
    }

    // logout method
    public function logout(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'route_token' => 'required',
            ]);

            if ($validator->fails()) {
                return apiResponse('e400', false, $validator->errors()->first());
            }

            if ($request['route_token'] == env('ROUTE_TOKEN')) {
                auth('api')->logout();
                return apiResponse('e200', true, 'تم تسجيل الخروج بنجاح');
            } else {
                return apiResponse('e400', false, 'من فضلك ضع توكين صحيح');
            }
        } catch (\Exception $ex) {
            return apiResponse('e500', false, $ex->getMessage());
        }
    }

    // logout method
    public function profile(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'route_token' => 'required',
                'user_id' => 'required',
            ]);

            if ($validator->fails()) {
                return apiResponse('e400', false, $validator->errors()->first());
            }

            if ($request['route_token'] == env('ROUTE_TOKEN')) {
                $user = User::where('id', $request['user_id'])->first();

                if ($user) {
                    $data = [
                        'id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                        'image' => asset($user->image),
                        'cover_image' => asset($user->cover_image),
                        'phone' => $user->phone,
                        'birth_day' => $user->birth_day,
                        'gender' => $user->gender,
                        'fb_account' => $user->fb_account,
                    ];
                    return apiResponse('e200', true, 'تم استرجاع البيانات بنجاح', $data);
                }
                return apiResponse('e300', false, 'للاسف لا توجد بيانات حاليا');
            } else {
                return apiResponse('e400', false, 'من فضلك ضع توكين صحيح');
            }
        } catch (\Exception $ex) {
            return apiResponse('e500', false, $ex->getMessage());
        }
    }

    /*The data that return back when login in */
    protected function respondWithToken($token)
    {
        try {
            $user = auth('api')->user()->select('id', 'name', 'email')->first();

            if ($user) {
                $data = [
                    'user' => $user,
                    'access_token' => $token,
                    'token_type' => 'bearer',
                    'expires_in' => auth('api')->factory()->getTTL() * 60
                ];

                return apiResponse('e200', true, 'تم تسجيل الدخول بنجاح', $data);
            }

            return apiResponse('e300', false, 'للاسف لا توجد بيانات حاليا');

        } catch (\Exception $ex) {
            return apiResponse('e500', false, $ex->getMessage());
        }


    }

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
