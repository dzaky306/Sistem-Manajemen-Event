<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Seminar', 'icon' => '🎓', 'description' => 'Seminar edukasi dan pelatihan'],
            ['name' => 'Workshop', 'icon' => '🛠️', 'description' => 'Workshop praktis dan hands-on'],
            ['name' => 'Konser', 'icon' => '🎵', 'description' => 'Konser musik dan pertunjukan'],
            ['name' => 'Webinar', 'icon' => '💻', 'description' => 'Webinar dan seminar online'],
            ['name' => 'Conference', 'icon' => '🏛️', 'description' => 'Konferensi dan forum diskusi'],
            ['name' => 'Meetup', 'icon' => '🤝', 'description' => 'Meetup komunitas dan networking'],
        ];

        foreach ($categories as $cat) {
            Category::create($cat);
        }
    }
}