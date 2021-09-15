<?php

use App\Models\Category;
use App\Models\Field;
use App\Models\FieldSubCategory;
use App\Models\Section;
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
        ]);

        $user->attachRole('super_admin');

        Section::insert([
            ['name' => 'services', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now(),],
            ['name' => 'products', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now(),],
        ]);

        Category::insert([
            ['section_id' => 1, 'name' => 'atelier', 'description' => 'this is test description', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now(),],
            ['section_id' => 1, 'name' => 'spa', 'description' => 'this is test description', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now(),],
            ['section_id' => 1, 'name' => 'studio', 'description' => 'this is test description', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now(),],
            ['section_id' => 1, 'name' => 'flowers', 'description' => 'this is test description', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now(),],
            ['section_id' => 1, 'name' => 'limousine', 'description' => 'this is test description', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now(),],
        ]);

        SubCategory::insert([
            ['name' => 'engagement', 'category_id' => 1, 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now(),],
            ['name' => 'wedding', 'category_id' => 1, 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now(),],
            ['name' => 'soiree', 'category_id' => 1, 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now(),],
            ['name' => 'veiled', 'category_id' => 1, 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now(),],

            ['name' => 'sauna', 'category_id' => 2, 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now(),],
            ['name' => 'jacuzzi', 'category_id' => 2, 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now(),],
            ['name' => 'steem', 'category_id' => 2, 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now(),],
            ['name' => 'massage', 'category_id' => 2, 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now(),],

            ['name' => 'studio', 'category_id' => 3, 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now(),],
            ['name' => 'photographer', 'category_id' => 3, 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now(),],
            ['name' => 'location', 'category_id' => 3, 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now(),],
        ]);

        $fields = Field::insert([
            ['name' => 'name', 'type' => 'varchar', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'price', 'type' => 'int', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'stock', 'type' => 'int', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'purchase_type', 'type' => 'select', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'images', 'type' => 'image', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'description', 'type' => 'text', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'kg_from', 'type' => 'int', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'kg_to', 'type' => 'int', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'width_height', 'type' => 'varchar', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'instructions', 'type' => 'text', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'discount', 'type' => 'int', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'material', 'type' => 'select', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'size', 'type' => 'varchar', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'shipping', 'type' => 'select', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'duration', 'type' => 'varchar', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'additional_options', 'type' => 'text', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'used_products', 'type' => 'text', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'available_fo_sale', 'type' => 'boolean', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'suggested_seller', 'type' => 'select', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'colors', 'type' => 'varchar', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'add_as_offer', 'type' => 'boolean', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'driver', 'type' => 'select', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'rent_type', 'type' => 'select', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'brand_name', 'type' => 'varchar', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'degree', 'type' => 'select', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'coverage', 'type' => 'select', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'listing', 'type' => 'select', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'supplies', 'type' => 'select', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'photos', 'type' => 'select', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'portrait', 'type' => 'select', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'an_offer', 'type' => 'text', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ]);

        FieldSubCategory::insert([
            //engagement
            ['field_id' => 2, 'sub_category_id' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 3, 'sub_category_id' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 4, 'sub_category_id' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 1, 'sub_category_id' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 5, 'sub_category_id' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 6, 'sub_category_id' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 7, 'sub_category_id' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 8, 'sub_category_id' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 9, 'sub_category_id' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 10, 'sub_category_id' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 21, 'sub_category_id' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            //wedding
            ['field_id' => 2, 'sub_category_id' => 2, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 3, 'sub_category_id' => 2, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 4, 'sub_category_id' => 2, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 1, 'sub_category_id' => 2, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 5, 'sub_category_id' => 2, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 6, 'sub_category_id' => 2, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 7, 'sub_category_id' => 2, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 8, 'sub_category_id' => 2, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 9, 'sub_category_id' => 2, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 10, 'sub_category_id' => 2, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 21, 'sub_category_id' => 2, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            //soiree
            ['field_id' => 2, 'sub_category_id' => 3, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 3, 'sub_category_id' => 3, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 4, 'sub_category_id' => 3, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 1, 'sub_category_id' => 3, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 5, 'sub_category_id' => 3, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 6, 'sub_category_id' => 3, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 7, 'sub_category_id' => 3, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 8, 'sub_category_id' => 3, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 9, 'sub_category_id' => 3, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 10, 'sub_category_id' => 3, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 21, 'sub_category_id' => 3, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            //veiled
            ['field_id' => 2, 'sub_category_id' => 4, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 3, 'sub_category_id' => 4, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 4, 'sub_category_id' => 4, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 1, 'sub_category_id' => 4, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 5, 'sub_category_id' => 4, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 6, 'sub_category_id' => 4, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 7, 'sub_category_id' => 4, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 8, 'sub_category_id' => 4, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 9, 'sub_category_id' => 4, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 10, 'sub_category_id' => 4, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 21, 'sub_category_id' => 4, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            //sauna
            ['field_id' => 2, 'sub_category_id' => 5, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 11, 'sub_category_id' => 5, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 15, 'sub_category_id' => 5, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 1, 'sub_category_id' => 5, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 5, 'sub_category_id' => 5, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 6, 'sub_category_id' => 5, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 16, 'sub_category_id' => 5, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 17, 'sub_category_id' => 5, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 18, 'sub_category_id' => 5, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 19, 'sub_category_id' => 5, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 10, 'sub_category_id' => 5, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 21, 'sub_category_id' => 5, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            //jacuzzi
            ['field_id' => 2, 'sub_category_id' => 6, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 11, 'sub_category_id' => 6, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 15, 'sub_category_id' => 6, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 1, 'sub_category_id' => 6, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 5, 'sub_category_id' => 6, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 6, 'sub_category_id' => 6, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 16, 'sub_category_id' => 6, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 17, 'sub_category_id' => 6, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 18, 'sub_category_id' => 6, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 19, 'sub_category_id' => 6, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 10, 'sub_category_id' => 6, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 21, 'sub_category_id' => 6, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            //steem
            ['field_id' => 2, 'sub_category_id' => 7, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 11, 'sub_category_id' => 7, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 15, 'sub_category_id' => 7, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 1, 'sub_category_id' => 7, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 5, 'sub_category_id' => 7, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 6, 'sub_category_id' => 7, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 16, 'sub_category_id' => 7, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 17, 'sub_category_id' => 7, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 18, 'sub_category_id' => 7, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 19, 'sub_category_id' => 7, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 10, 'sub_category_id' => 7, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 21, 'sub_category_id' => 7, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            //massage
            ['field_id' => 2, 'sub_category_id' => 8, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 11, 'sub_category_id' => 8, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 15, 'sub_category_id' => 8, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 1, 'sub_category_id' => 8, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 5, 'sub_category_id' => 8, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 6, 'sub_category_id' => 8, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 16, 'sub_category_id' => 8, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 17, 'sub_category_id' => 8, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 18, 'sub_category_id' => 8, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 19, 'sub_category_id' => 8, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 10, 'sub_category_id' => 8, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['field_id' => 21, 'sub_category_id' => 8, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ]);

    }
}
