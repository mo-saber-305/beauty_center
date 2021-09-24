<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Field;
use App\Models\FieldService;
use App\Models\Section;
use App\Models\Service;
use App\Models\ServiceImage;
use App\Models\SubCategory;
use App\Models\User;
use App\Models\UserResetPassword;
use App\Models\UserVerification;
use App\Traits\GeneralTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Mail;
use Stichoza\GoogleTranslate\GoogleTranslate;

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

            if ($request['route_token'] == $this->routeToken()) {
                $credentials = $request->only('email', 'password');

                $credentials['is_verified'] = 1;

                if (!$token = auth('api')->attempt($credentials)) {
                    return apiResponse('e100', false, 'خطأ في تسجيل الدخول من فضلك حاول مره اخري');
                }

                $user = User::where('email', $request['email'])->select('id', 'name', 'email')->first();

                return $this->respondWithToken($token, $user);
            } else {
                return apiResponse('e400', false, 'من فضلك ضع توكين صحيح');
            }
        } catch (\Exception $ex) {
            return apiResponse('e500', false, $ex->getMessage());
        }
    }

    // social login method
    public function socialLogin(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'route_token' => 'required',
                'name' => 'required',
                'email' => 'required|email',
                'provider' => 'required',
                'provider_id' => 'required',
            ]);

            if ($validator->fails()) {
                return apiResponse('e400', false, $validator->errors()->first());
            }

            if ($request['route_token'] == $this->routeToken()) {
                $user = User::where('email', $request->email)->select('email', 'password')->first();

                /*check if user has email in database or not => if has email */
                if (!$user) {
                    $data = User::create([
                        'name' => $request->name,
                        'email' => $request->email,
                        'is_verified' => 1,
                        'email_verified_at' => Carbon::now(),
                        'provider' => $request->provider,
                        'provider_id' => $request->provider_id
                    ]);

                    if (!$token = auth('api')->login($data)) {
                        return apiResponse('e100', false, 'خطأ في تسجيل الدخول من فضلك حاول مره اخري');
                    }

                    $user_data = [
                        'id' => $data->id,
                        'name' => $data->name,
                        'email' => $data->email,
                    ];

                    return $this->respondWithToken($token, $user_data);
                }

                if (!$token = auth('api')->login($user)) {
                    return apiResponse('e100', false, 'خطأ في تسجيل الدخول من فضلك حاول مره اخري');
                }

                $user_data = User::where('email', $request->email)->select('id', 'name', 'email')->first();

                return $this->respondWithToken($token, $user_data);

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

            if ($request['route_token'] == $this->routeToken()) {
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

                $data = [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                ];

                return apiResponse('e200', true, 'تم انشاء حساب جديد وارسال الكود بنجاح من فضلك فعل حسابك حتي تتمكن من تسجيل الدخول', $data);
            } else {
                return apiResponse('e400', false, 'من فضلك ضع توكين صحيح');
            }
        } catch (\Exception $ex) {
            return apiResponse('e500', false, $ex->getMessage());
        }
    }

    // verify method
    public function verify(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'route_token' => 'required',
                'user_id' => 'required',
                'code' => 'required',
            ]);

            if ($validator->fails()) {
                return apiResponse('e400', false, $validator->errors()->first());
            }

            if ($request['route_token'] == $this->routeToken()) {
                $code = UserVerification::where('user_id', $request['user_id'])->where('code', $request['code'])->first();

                if (!is_null($code)) {
                    $user = User::where('id', $code->user_id)->first();

                    if (!is_null($user)) {
                        if ($user->is_verified == 1) {
                            return apiResponse('e200', true, 'هذا الحساب مفعل يمكنك تسجيل الدخول بدون تفعيل');
                        }

                        $user->update([
                            'is_verified' => 1,
                            'email_verified_at' => Carbon::now()
                        ]);

                        $code->delete();
                        return apiResponse('e200', true, 'تم تفعيل الحساب بنجاح يمكنك تسجيل الدخول الان');
                    }

                    return apiResponse('e300', false, 'للاسف لا توجد بيانات حاليا');
                }
                return apiResponse('e300', false, 'هذا الكود غير صحيح من فضلك ضع كود صحيح وحاول مره اخري');
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

            if ($request['route_token'] == $this->routeToken()) {
                auth('api')->logout();
                return apiResponse('e200', true, 'تم تسجيل الخروج بنجاح');
            } else {
                return apiResponse('e400', false, 'من فضلك ضع توكين صحيح');
            }
        } catch (\Exception $ex) {
            return apiResponse('e500', false, $ex->getMessage());
        }
    }

    // reset password method
    public function resetPassword(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'route_token' => 'required',
                'email' => 'required',
            ]);

            if ($validator->fails()) {
                return apiResponse('e400', false, $validator->errors()->first());
            }

            if ($request['route_token'] == $this->routeToken()) {
                $user = User::where('email', $request['email'])->first();

                if ($user) {
                    if ($user->is_verified == 1) {
                        $name = $user->name;
                        $email = $user->email;

                        $verification_code = random_int(100000, 999999); //Generate verification code

                        $resetPassword = UserResetPassword::where('email', $email)->first();
                        if ($resetPassword) {
                            // update code in user_reset_password table
                            $resetPassword->update(['code' => $verification_code]);
                        } else {
                            // save code in user_reset_password table
                            UserResetPassword::create(['email' => $email, 'code' => $verification_code]);
                        }

                        $subject = "Please verify your email address.";
                        Mail::send('email.verify', ['name' => $name, 'verification_code' => $verification_code],
                            function ($mail) use ($email, $name, $subject) {
                                $mail->from(env('MAIL_FROM_ADDRESS'), "From User/Company Name Goes Here");
                                $mail->to($email, $name);
                                $mail->subject($subject);
                            });

                        $data = [
                            'id' => $user->id,
                            'name' => $user->name,
                            'email' => $user->email,
                        ];
                        return apiResponse('e200', true, 'تم ارسال الكود بنجاح', $data);
                    }

                    return apiResponse('e300', false, 'للاسف يجب تفعيل الحساب اولا');
                }
                return apiResponse('e300', false, 'للاسف لا توجد بيانات حاليا');
            } else {
                return apiResponse('e400', false, 'من فضلك ضع توكين صحيح');
            }
        } catch (\Exception $ex) {
            return apiResponse('e500', false, $ex->getMessage());
        }
    }

    // change password method
    public function changePassword(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'route_token' => 'required',
                'user_id' => 'required',
                'code' => 'required',
                'password' => 'required|confirmed|min:6',
            ]);

            if ($validator->fails()) {
                return apiResponse('e400', false, $validator->errors()->first());
            }

            if ($request['route_token'] == $this->routeToken()) {
                $user = User::where('id', $request['user_id'])->first();


                if ($user) {
                    $email = $user->email;

                    // check if code is true
                    $checkCode = UserResetPassword::where('email', $email)->where('code', $request['code'])->first();
                    if ($checkCode) {
                        $user->update(['password' => Hash::make($request->password)]);

                        return apiResponse('e200', true, 'تم تغيير الباسورد بنجاح');
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

    // profile method
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

            if ($request['route_token'] == $this->routeToken()) {
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


    // update profile method
    public function updateProfile(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'route_token' => 'required',
                'user_id' => 'required',
                'name' => 'required',
                'phone' => 'required',
                'password' => 'confirmed|min:6',
                'image' => 'image',
                'cover' => 'image',
            ]);

            if ($validator->fails()) {
                return apiResponse('e400', false, $validator->errors()->first());

            }

            if ($request['route_token'] == $this->routeToken()) {
                $user = User::where('id', $request['user_id'])->first();
                if ($user) {
                    $data = [];

                    if ($request->has('image')) {
                        if ($user->image != 'user_default.jpg') {
                            File::delete($user->image);
                        }

                        $data['image'] = $this->uploadImage('users/profile', $request->image);
                    }

                    if ($request->has('cover')) {
                        if ($user->cover_image != 'cover_default.jpg') {
                            File::delete($user->cover_image);
                        }
                        $data['cover_image'] = $this->uploadImage('users/cover', $request->cover);
                    }

                    if ($request->has('password')) {
                        $data['password'] = Hash::make($request['password']);
                    }

                    $data['name'] = $request['name'];
                    $data['phone'] = $request['phone'];

                    $user->update($data);

                    return apiResponse('e200', true, 'تم حفظ البيانات بنجاح');
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
    protected function respondWithToken($token, $user)
    {
        try {
            $data = [
                'user' => $user,
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => auth('api')->factory()->getTTL() * 60
            ];

            return apiResponse('e200', true, 'تم تسجيل الدخول بنجاح', $data);

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
                'lang' => 'required',
            ]);

            if ($validator->fails()) {
                return apiResponse('e400', false, $validator->errors()->first());
            }

            if ($request['route_token'] == $this->routeToken()) {
                $sections = Section::all();

                if (count($sections)) {
                    $lang = $request['lang'];
                    $nameVar = "name_$lang";
                    $data = [];
                    foreach ($sections as $section) {
                        $data[] = [
                            'id' => $section->id,
                            'name' => $section->$nameVar,
                            'created_at' => $section->created_at,
                            'updated_at' => $section->updated_at,
                        ];
                    }

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

    //get all categories where('section_id', $section_id)
    public function categories(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'route_token' => 'required',
                'section_id' => 'required',
                'lang' => 'required',
            ]);

            if ($validator->fails()) {
                return apiResponse('e400', false, $validator->errors()->first());
            }

            if ($request['route_token'] == $this->routeToken()) {
                $categories = Category::where('section_id', $request['section_id'])->get();

                if (count($categories)) {
                    $lang = $request['lang'];
                    $nameVar = "name_$lang";
                    $descriptionVar = "description_$lang";
                    $data = [];

                    foreach ($categories as $category) {
                        $data[] = [
                            'id' => $category->id,
                            'section_id' => $category->section_id,
                            'name' => $category->$nameVar,
                            'description' => $category->$descriptionVar,
                            'image' => $category->image_path,
                            'created_at' => $category->created_at,
                            'updated_at' => $category->updated_at,
                        ];
                    }

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

    //get all sub categories where('category_id', $category_id)
    public function subCategories(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'route_token' => 'required',
                'category_id' => 'required',
                'lang' => 'required',
            ]);

            if ($validator->fails()) {
                return apiResponse('e400', false, $validator->errors()->first());
            }

            if ($request['route_token'] == $this->routeToken()) {
                $subCategories = SubCategory::where('category_id', $request['category_id'])->get();

                if (count($subCategories)) {
                    $lang = $request['lang'];
                    $nameVar = "name_$lang";
                    $data = [];

                    foreach ($subCategories as $subCategory) {
                        $data[] = [
                            'id' => $subCategory->id,
                            'category_id' => $subCategory->category_id,
                            'name' => $subCategory->$nameVar,
                            'image' => $subCategory->image_path,
                            'created_at' => $subCategory->created_at,
                            'updated_at' => $subCategory->updated_at,
                        ];
                    }

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

    //get fields where('sub_category_id', $subCategory_id)
    public function fields(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'route_token' => 'required',
                'sub_category_id' => 'required',
                'lang' => 'required',
            ]);

            if ($validator->fails()) {
                return apiResponse('e400', false, $validator->errors()->first());
            }


            if ($request['route_token'] == $this->routeToken()) {

                $subCategories = SubCategory::where('id', $request['sub_category_id'])->first();

                if ($subCategories) {
                    $fields = $subCategories->fields()->with('options')->get();
                    if (count($fields)) {
                        $options = [];
                        $data = [];
                        $lang = $request['lang'];
                        $nameVar = "name_$lang";
                        foreach ($fields as $field) {
                            foreach ($field->options()->get() as $item) {
                                $options[] = [
                                    'id' => $item->id,
                                    'name' => $item->$nameVar,
                                ];
                            }

                            $fieldsData = [
                                'id' => $field->id,
                                'key' => $field->key,
                                'name' => $field->$nameVar,
                                'type' => $field->type,
                            ];

                            $optionsData = [
                                'options' => $options
                            ];

                            if ($field->type == 'select') {
                                $data[] = array_merge($fieldsData, $optionsData);
                            } else {
                                $data[] = $fieldsData;
                            }
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
                'lang' => 'required',
            ]);

            if ($validator->fails()) {
                return apiResponse('e400', false, $validator->errors()->first());
            }

            if ($request['route_token'] == $this->routeToken()) {

                $subCategories = SubCategory::where('id', $request['sub_category_id'])->first();

                if ($subCategories) {
                    $services = $subCategories->services()->with('fields')->get();

                    if (count($services)) {
                        $data = [];
                        $lang = $request['lang'];
                        $nameVar = "name_$lang";
                        $descriptionVar = "description_$lang";
                        $valueVar = "value_$lang";

                        foreach ($services as $service) {
                            /* هنا بقي بنجيب الفيلدس اللي تبع السيرفيس دي */
                            $fields = $service->fields()->withPivot($valueVar)->get();
                            $fields_data = [];
                            foreach ($fields as $field) {
                                $fields_data[] = [
                                    'id' => $field->id,
                                    'key' => $field->key,
                                    'name' => $field->$nameVar,
                                    'value' => $field->pivot->$valueVar,
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
                                'user_id' => $service['user_id'],
                                'category_id' => $service['category_id'],
                                'sub_category_id' => $service['sub_category_id'],
                                'name' => $service->$nameVar,
                                'description' => $service->$descriptionVar,
                                'as_offers' => $service->as_offers,
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

    //get services for user where('user_id', $user_id)
    public function servicesForUser(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'route_token' => 'required',
                'user_id' => 'required',
                'lang' => 'required',
            ]);

            if ($validator->fails()) {
                return apiResponse('e400', false, $validator->errors()->first());
            }

            if ($request['route_token'] == $this->routeToken()) {

                $user = User::where('id', $request['user_id'])->first();

                if ($user) {
                    $services = $user->services()->with('fields')->get();

                    if (count($services)) {
                        $data = [];
                        $lang = $request['lang'];
                        $nameVar = "name_$lang";
                        $descriptionVar = "description_$lang";
                        $valueVar = "value_$lang";

                        foreach ($services as $service) {
                            /* هنا بقي بنجيب الفيلدس اللي تبع السيرفيس دي */
                            $fields = $service->fields()->withPivot($valueVar)->get();
                            $fields_data = [];
                            foreach ($fields as $field) {
                                $fields_data[] = [
                                    'id' => $field->id,
                                    'key' => $field->key,
                                    'name' => $field->$nameVar,
                                    'value' => $field->pivot->$valueVar,
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
                                'name' => $service->$nameVar,
                                'description' => $service->$descriptionVar,
                                'as_offers' => $service->as_offers,
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
                'lang' => 'required',
                'user_id' => 'required',
                'category_id' => 'required',
                'sub_category_id' => 'required',
                'name' => 'required',
                'description' => 'required',
                'images' => 'required',
                'as_offers' => 'required',
                'fields' => 'required',
            ]);

            if ($validator->fails()) {
                return apiResponse('e400', false, $validator->errors()->first());
            }

            if ($request['route_token'] == $this->routeToken()) {
                $lang = $request['lang'];

                /*translate only name and description*/
                if ($lang == 'ar') {
                    $name_ar = $request['name'];
                    $name_en = GoogleTranslate::trans($request['name'], 'en', 'ar');
                    $description_ar = $request['description'];
                    $description_en = GoogleTranslate::trans($request['description'], 'en', 'ar');
                } else {
                    $name_ar = GoogleTranslate::trans($request['name'], 'ar', 'en');
                    $name_en = $request['name'];
                    $description_ar = GoogleTranslate::trans($request['description'], 'ar', 'en');
                    $description_en = $request['description'];
                }

                /* save service data */
                $service = Service::create([
                    'user_id' => $request['user_id'],
                    'category_id' => $request['category_id'],
                    'sub_category_id' => $request['sub_category_id'],
                    'name_ar' => $name_ar,
                    'name_en' => $name_en,
                    'description_ar' => $description_ar,
                    'description_en' => $description_en,
                    'as_offers' => $request['as_offers'] == 1 ? 1 : 0,
                ]);

                /* save fields for service */
                foreach ($request['fields'] as $item) {
                    $field = Field::where('id', $item['id'])->first();

                    /*translate only fields has type tex or varchar*/
                    if ($field->type == 'varchar' || $field->type == 'text') {
                        /*translate fields before save*/
                        if ($lang == 'ar') {
                            $value_ar = $item['value'];
                            $value_en = GoogleTranslate::trans($item['value'], 'en', 'ar');
                        } else {
                            $value_ar = GoogleTranslate::trans($item['value'], 'ar', 'en');
                            $value_en = $item['value'];
                        }
                    } else {
                        $value_ar = $item['value'];
                        $value_en = $item['value'];
                    }

                    FieldService::create([
                        'field_id' => $item['id'],
                        'service_id' => $service->id,
                        'value_ar' => $value_ar,
                        'value_en' => $value_en,
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

    //edit service
    public function editService(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'route_token' => 'required',
                'lang' => 'required',
                'user_id' => 'required',
                'category_id' => 'required',
                'sub_category_id' => 'required',
                'as_offers' => 'required',
                'fields' => 'required',
            ]);

            if ($validator->fails()) {
                return apiResponse('e400', false, $validator->errors()->first());
            }
            if ($request['route_token'] == $this->routeToken()) {
                /* هنا بقي بنحفظ الداتا بتاعة السيرفس بس مش كلها لان في داتا تانيه في جداول مختلفه */
                $service = Service::create([
                    'user_id' => $request['user_id'],
                    'category_id' => $request['category_id'],
                    'sub_category_id' => $request['sub_category_id'],
                    'as_offers' => $request['as_offers'],
                ]);

                $lang = $request['lang'];

                /* هنا بقي بنحفظ الداتا بتاعة الفيلدس اللي تبع السيرفس */
                foreach ($request['fields'] as $item) {
                    $field = Field::where('id', $item['id'])->first();

                    /*translate only fields has type tex or varchar*/
                    if ($field->type == 'varchar' || $field->type == 'text') {
                        /*translate fields before save*/
                        if ($lang == 'ar') {
                            $value_ar = $item['value'];
                            $value_en = GoogleTranslate::trans($item['value'], 'en', 'ar');
                        } else {
                            $value_ar = GoogleTranslate::trans($item['value'], 'ar', 'en');
                            $value_en = $item['value'];
                        }
                    } else {
                        $value_ar = $item['value'];
                        $value_en = $item['value'];
                    }

                    FieldService::create([
                        'field_id' => $item['id'],
                        'service_id' => $service->id,
                        'value_ar' => $value_ar,
                        'value_en' => $value_en,
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
