<?php

use App\Models\Category;
use App\Models\Field;
use App\Models\FieldSubCategory;
use App\Models\Section;
use App\Models\SelectOption;
use App\Models\Setting;
use App\Models\SubCategory;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'Super Admin',
            'email' => 'info@admin.com',
            'password' => bcrypt('admin5050'),
            'email_verified_at' => Carbon::now(),
            'is_verified' => 1,
            'birth_day' => '30-05-1994',
            'gender' => 'male',
        ]);

        $user->attachRole('super_admin');

        Section::insert([
            ['name_ar' => 'الخدمات', 'name_en' => 'services', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now(),],
            ['name_ar' => 'المنتجات', 'name_en' => 'products', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now(),],
        ]);

        Category::insert([
            ['section_id' => 1, 'name_ar' => 'اتيليه', 'name_en' => 'atelier', 'description_ar' => 'هذا النص تجريبي', 'description_en' => 'this is test description', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now(),],
            ['section_id' => 1, 'name_ar' => 'اكسسوارات', 'name_en' => 'accessories', 'description_ar' => 'هذا النص تجريبي', 'description_en' => 'this is test description', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now(),],
            ['section_id' => 1, 'name_ar' => 'سبا', 'name_en' => 'spa', 'description_ar' => 'هذا النص تجريبي', 'description_en' => 'this is test description', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now(),],
            ['section_id' => 1, 'name_ar' => 'ستديوهات', 'name_en' => 'studio', 'description_ar' => 'هذا النص تجريبي', 'description_en' => 'this is test description', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now(),],
            ['section_id' => 1, 'name_ar' => 'ورود', 'name_en' => 'flowers', 'description_ar' => 'هذا النص تجريبي', 'description_en' => 'this is test description', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now(),],
            ['section_id' => 1, 'name_ar' => 'لاموزين', 'name_en' => 'limousine', 'description_ar' => 'هذا النص تجريبي', 'description_en' => 'this is test description', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now(),],
        ]);

        SubCategory::insert([
            ['name_ar' => 'خطوبه', 'name_en' => 'engagement', 'category_id' => 1, 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now(),],
            ['name_ar' => 'فرح', 'name_en' => 'wedding', 'category_id' => 1, 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now(),],
            ['name_ar' => 'سواريه', 'name_en' => 'soiree', 'category_id' => 1, 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now(),],
            ['name_ar' => 'محجبات', 'name_en' => 'veiled', 'category_id' => 1, 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now(),],

            ['name_ar' => 'ساعات', 'name_en' => 'watches', 'category_id' => 2, 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now(),],
            ['name_ar' => 'حقائب', 'name_en' => 'bags', 'category_id' => 2, 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now(),],
            ['name_ar' => 'مجوهرات', 'name_en' => 'jewelry', 'category_id' => 2, 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now(),],
            ['name_ar' => 'احذيه', 'name_en' => 'shoes', 'category_id' => 2, 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now(),],
            ['name_ar' => 'اخري', 'name_en' => 'section 4', 'category_id' => 2, 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now(),],

            ['name_ar' => 'ساونا', 'name_en' => 'sauna', 'category_id' => 3, 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now(),],
            ['name_ar' => 'جاكوزي', 'name_en' => 'jacuzzi', 'category_id' => 3, 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now(),],
            ['name_ar' => 'ستييم', 'name_en' => 'steem', 'category_id' => 3, 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now(),],
            ['name_ar' => 'مساج', 'name_en' => 'massage', 'category_id' => 3, 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now(),],

            ['name_ar' => 'ستديو', 'name_en' => 'studio', 'category_id' => 4, 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now(),],
            ['name_ar' => 'فوتوجرافر', 'name_en' => 'photographer', 'category_id' => 4, 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now(),],
            ['name_ar' => 'اماكن تصوير', 'name_en' => 'location', 'category_id' => 4, 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now(),],

            ['name_ar' => 'زفاف', 'name_en' => 'wedding', 'category_id' => 5, 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now(),],
            ['name_ar' => 'هديه', 'name_en' => 'gift', 'category_id' => 5, 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now(),],

            ['name_ar' => 'زفاف', 'name_en' => 'wedding', 'category_id' => 5, 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now(),],
            ['name_ar' => 'رحله', 'name_en' => 'trip', 'category_id' => 5, 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now(),],
        ]);

        $fields = Field::insert([
            ['key' => 'price', 'name_ar' => 'السعر', 'name_en' => 'price', 'type' => 'int', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['key' => 'stock', 'name_ar' => 'المخزون', 'name_en' => 'stock', 'type' => 'int', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['key' => 'atelier_purchase_type', 'name_ar' => 'نوع الشراء', 'name_en' => 'purchase type', 'type' => 'select', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['key' => 'kg_from', 'name_ar' => 'الوزن من (كجم)', 'name_en' => 'weight from (kg)', 'type' => 'int', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['key' => 'kg_to', 'name_ar' => 'الوزن الي (كجم)', 'name_en' => 'weight to (kg)', 'type' => 'int', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['key' => 'width_height', 'name_ar' => 'الطول والعرض', 'name_en' => 'width height', 'type' => 'varchar', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['key' => 'instructions', 'name_ar' => 'تعليمات', 'name_en' => 'instructions', 'type' => 'text', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['key' => 'discount', 'name_ar' => 'الخصم', 'name_en' => 'discount', 'type' => 'int', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['key' => 'materials', 'name_ar' => 'المواد المستخدمه', 'name_en' => 'materials', 'type' => 'select', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['key' => 'size', 'name_ar' => 'الحجم', 'name_en' => 'size', 'type' => 'varchar', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['key' => 'shipping', 'name_ar' => 'الشحن', 'name_en' => 'shipping', 'type' => 'select', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['key' => 'duration', 'name_ar' => 'المده', 'name_en' => 'duration', 'type' => 'varchar', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['key' => 'additional_options', 'name_ar' => 'خيارات اضافيه', 'name_en' => 'additional options', 'type' => 'text', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['key' => 'used_products', 'name_ar' => 'المنتجات المستخدمه', 'name_en' => 'used products', 'type' => 'text', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['key' => 'available_for_sale', 'name_ar' => 'متاح للبيع ؟', 'name_en' => 'available for sale ?', 'type' => 'boolean', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['key' => 'suggested_seller', 'name_ar' => 'البائع المقترح', 'name_en' => 'suggested seller', 'type' => 'select', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['key' => 'colors', 'name_ar' => 'الالوان', 'name_en' => 'colors', 'type' => 'varchar', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['key' => 'driver', 'name_ar' => 'السائق', 'name_en' => 'driver', 'type' => 'select', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['key' => 'brand_name', 'name_ar' => 'اسم الماركه', 'name_en' => 'brand name', 'type' => 'varchar', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['key' => 'degree', 'name_ar' => 'الدرجه', 'name_en' => 'degree', 'type' => 'select', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['key' => 'coverage', 'name_ar' => 'مدي التغطيه', 'name_en' => 'coverage', 'type' => 'select', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['key' => 'listing', 'name_ar' => 'القائمه', 'name_en' => 'listing', 'type' => 'select', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['key' => 'supplies', 'name_ar' => 'اللوازم', 'name_en' => 'supplies', 'type' => 'varchar', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['key' => 'portrait', 'name_ar' => 'بورتريه', 'name_en' => 'portrait', 'type' => 'select', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['key' => 'an_offer', 'name_ar' => 'العرض', 'name_en' => 'an offer', 'type' => 'text', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ]);

        FieldSubCategory::insert([
            //engagement
            ['field_id' => 1, 'sub_category_id' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 2, 'sub_category_id' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 3, 'sub_category_id' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 4, 'sub_category_id' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 5, 'sub_category_id' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 6, 'sub_category_id' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 7, 'sub_category_id' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            //wedding
            ['field_id' => 1, 'sub_category_id' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 2, 'sub_category_id' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 3, 'sub_category_id' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 4, 'sub_category_id' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 5, 'sub_category_id' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 6, 'sub_category_id' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 7, 'sub_category_id' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            //soiree
            ['field_id' => 1, 'sub_category_id' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 2, 'sub_category_id' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 3, 'sub_category_id' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 4, 'sub_category_id' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 5, 'sub_category_id' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 6, 'sub_category_id' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 7, 'sub_category_id' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            //veiled
            ['field_id' => 1, 'sub_category_id' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 2, 'sub_category_id' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 3, 'sub_category_id' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 4, 'sub_category_id' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 5, 'sub_category_id' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 6, 'sub_category_id' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 7, 'sub_category_id' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            /***********************************************************************************************************/

            //watches
            ['field_id' => 1, 'sub_category_id' => 5, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 9, 'sub_category_id' => 5, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 8, 'sub_category_id' => 5, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 10, 'sub_category_id' => 5, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 11, 'sub_category_id' => 5, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 7, 'sub_category_id' => 5, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            //bags
            ['field_id' => 1, 'sub_category_id' => 6, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 9, 'sub_category_id' => 6, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 8, 'sub_category_id' => 6, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 10, 'sub_category_id' => 6, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 11, 'sub_category_id' => 6, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 7, 'sub_category_id' => 6, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            //jewelry
            ['field_id' => 1, 'sub_category_id' => 7, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 9, 'sub_category_id' => 7, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 8, 'sub_category_id' => 7, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 10, 'sub_category_id' => 7, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 11, 'sub_category_id' => 7, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 7, 'sub_category_id' => 7, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            //shoes
            ['field_id' => 1, 'sub_category_id' => 8, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 9, 'sub_category_id' => 8, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 8, 'sub_category_id' => 8, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 10, 'sub_category_id' => 8, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 11, 'sub_category_id' => 8, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 7, 'sub_category_id' => 8, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            //other
            ['field_id' => 1, 'sub_category_id' => 9, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 9, 'sub_category_id' => 9, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 8, 'sub_category_id' => 9, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 10, 'sub_category_id' => 9, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 11, 'sub_category_id' => 9, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 7, 'sub_category_id' => 9, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            /***********************************************************************************************************/

            //sauna
            ['field_id' => 1, 'sub_category_id' => 10, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 12, 'sub_category_id' => 10, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 8, 'sub_category_id' => 10, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 13, 'sub_category_id' => 10, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 14, 'sub_category_id' => 10, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 15, 'sub_category_id' => 10, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 16, 'sub_category_id' => 10, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 7, 'sub_category_id' => 10, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            //jacuzzi
            ['field_id' => 1, 'sub_category_id' => 11, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 12, 'sub_category_id' => 11, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 8, 'sub_category_id' => 11, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 13, 'sub_category_id' => 11, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 14, 'sub_category_id' => 11, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 15, 'sub_category_id' => 11, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 16, 'sub_category_id' => 11, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 7, 'sub_category_id' => 11, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            //steem
            ['field_id' => 1, 'sub_category_id' => 12, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 12, 'sub_category_id' => 12, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 8, 'sub_category_id' => 12, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 13, 'sub_category_id' => 12, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 14, 'sub_category_id' => 12, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 15, 'sub_category_id' => 12, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 16, 'sub_category_id' => 12, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 7, 'sub_category_id' => 12, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            //massage
            ['field_id' => 1, 'sub_category_id' => 13, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 12, 'sub_category_id' => 13, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 8, 'sub_category_id' => 13, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 13, 'sub_category_id' => 13, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 14, 'sub_category_id' => 13, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 15, 'sub_category_id' => 13, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 16, 'sub_category_id' => 13, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 7, 'sub_category_id' => 13, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            /***********************************************************************************************************/

            //studio
            ['field_id' => 1, 'sub_category_id' => 14, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 24, 'sub_category_id' => 14, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 12, 'sub_category_id' => 14, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 7, 'sub_category_id' => 14, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 25, 'sub_category_id' => 14, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            //photographer
            ['field_id' => 1, 'sub_category_id' => 15, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 24, 'sub_category_id' => 15, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 12, 'sub_category_id' => 15, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 7, 'sub_category_id' => 15, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 25, 'sub_category_id' => 15, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            //location
            ['field_id' => 1, 'sub_category_id' => 16, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 24, 'sub_category_id' => 16, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 12, 'sub_category_id' => 16, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 7, 'sub_category_id' => 16, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 25, 'sub_category_id' => 16, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            /***********************************************************************************************************/

            //wedding
            ['field_id' => 1, 'sub_category_id' => 17, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 17, 'sub_category_id' => 17, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 11, 'sub_category_id' => 17, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 7, 'sub_category_id' => 17, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            //gift
            ['field_id' => 1, 'sub_category_id' => 18, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 17, 'sub_category_id' => 18, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 11, 'sub_category_id' => 18, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 7, 'sub_category_id' => 18, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            /***********************************************************************************************************/

            //wedding
            ['field_id' => 1, 'sub_category_id' => 19, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 18, 'sub_category_id' => 19, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 12, 'sub_category_id' => 19, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 7, 'sub_category_id' => 19, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            //trip
            ['field_id' => 1, 'sub_category_id' => 20, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 18, 'sub_category_id' => 20, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 12, 'sub_category_id' => 20, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 7, 'sub_category_id' => 20, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ]);

        SelectOption::insert([
            ['field_id' => 3, 'name_ar' => 'للإيجار', 'name_en' => 'for rent', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 3, 'name_ar' => 'للشراء', 'name_en' => 'to buy', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 9, 'name_ar' => 'فضة', 'name_en' => 'silver', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 9, 'name_ar' => 'ذهب', 'name_en' => 'gold', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 9, 'name_ar' => 'اكسسوارات', 'name_en' => 'accessories', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 11, 'name_ar' => 'متاح', 'name_en' => 'available', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 11, 'name_ar' => 'غير متاح', 'name_en' => 'unavailable', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 18, 'name_ar' => 'مع سائق', 'name_en' => 'with driver', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 18, 'name_ar' => 'بدون سائق', 'name_en' => 'without driver', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 20, 'name_ar' => 'فاتح', 'name_en' => 'light', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 20, 'name_ar' => 'غامق', 'name_en' => 'dark', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 21, 'name_ar' => 'عالي', 'name_en' => 'high', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 21, 'name_ar' => 'وسط', 'name_en' => 'middle', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 21, 'name_ar' => 'ضعيف', 'name_en' => 'weak', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 22, 'name_ar' => '1&6 hours', 'name_en' => '1&6 hours', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 22, 'name_ar' => '6&12 hours', 'name_en' => '6&12 hours', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 22, 'name_ar' => '24 hours', 'name_en' => '24 hours', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 22, 'name_ar' => '27 hours', 'name_en' => '27 hours', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 24, 'name_ar' => '30*40', 'name_en' => '30*40', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 24, 'name_ar' => '40*50', 'name_en' => '40*50', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 24, 'name_ar' => '70*100', 'name_en' => '70*100', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 24, 'name_ar' => 'اخري', 'name_en' => 'other', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ]);


        Setting::create([
            'id' => 1,
            'app_name' => 'Beauty Center',
            'app_url' => 'http://localhost:8000',
            'app_logo' => 'backend/images/default_logo.png',
            'route_token' => 'smntffco2hfn6vui86hutja7',
        ]);
    }
}
