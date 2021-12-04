<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\CategoryTranslation;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create([
            'id' => '1',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        $category_translations = [
            [
                'category_id' => '1',
                'locale' => 'ar',
                'name' => 'Category one ar'
            ],
            [
                'category_id' => '1',
                'locale' => 'en',
                'name' => 'Category one en'
            ]
        ];

        // CategoryTranslation::create($category_translations);
        DB::table('category_translations')->insert($category_translations);
    }
}
