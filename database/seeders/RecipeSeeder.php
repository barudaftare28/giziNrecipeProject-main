<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\Ingredient;
use App\Models\Nutrition;
use App\Models\Rating;
use App\Models\Recipe;
use App\Models\Step;
use App\Models\User;

class RecipeSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        // Ambil semua user yang ada, jika tidak ada buat 1 user dummy
        $userIds = User::pluck('id')->all();

        if (empty($userIds)) {
            $user = User::factory()->create([
                'name'  => 'Demo User',
                'email' => 'demo@example.com',
            ]);
            $userIds = [$user->id];
        }

        // Template nama + path gambar (sesuai folder public/img/recipe images)
        $baseRecipes = [
            ['name' => 'Braised Steak',          'photo' => 'img/recipe images/braised steak.jpg'],
            ['name' => 'Bubur Ayam',             'photo' => 'img/recipe images/bubur.webp'],
            ['name' => 'Butter Chicken',         'photo' => 'img/recipe images/butter chicken.jpeg'],
            ['name' => 'Chicken Pasta',          'photo' => 'img/recipe images/chicken pasta.jpg'],
            ['name' => 'Creamy Garlic Prawns',   'photo' => 'img/recipe images/creamy garlic prawns.webp'],
            ['name' => 'Dumpling',               'photo' => 'img/recipe images/dumpling.webp'],
            ['name' => 'Fried Rice',             'photo' => 'img/recipe images/fried rice.jpg'],
            ['name' => 'Pempek',                 'photo' => 'img/recipe images/pempek.jpg'],
            ['name' => 'Quiche',                 'photo' => 'img/recipe images/quiche.jpeg'],
            ['name' => 'Rendang',                'photo' => 'img/recipe images/rendang.png'],
            ['name' => 'Sate',                   'photo' => 'img/recipe images/sate.jpg'],
            ['name' => 'Zucchini Slice',         'photo' => 'img/recipe images/zucchini slice.jpg'],
            ['name' => 'Fruit & Nuts Oatmeal',   'photo' => 'img/recipe images/oatmeal buah kacang.jpg'],
            ['name' => 'Roasted Lemon Chicken',  'photo' => 'img/recipe images/ayam panggan lemon brokoli.jpg'],
        ];

        $totalRecipes = 12;

        for ($i = 0; $i < $totalRecipes; $i++) {
            $template = $baseRecipes[$i % count($baseRecipes)];

            // Buat recipe
            $recipe = Recipe::create([
                'user_id'      => $faker->randomElement($userIds),
                'is_official'  => $faker->boolean(60),
                'name'         => $template['name'],
                'nutritionist' => $faker->name(),
                'duration'     => $faker->numberBetween(10, 120) . ' menit',
                'description'  => $faker->paragraphs(3, true),
                'photo'        => $template['photo'],
            ]);

            // Ingredients (4–8 item)
            $ingredientCount = $faker->numberBetween(4, 8);
            for ($j = 1; $j <= $ingredientCount; $j++) {
                Ingredient::create([
                    'recipe_id' => $recipe->id,
                    'item'      => $faker->sentence(3),
                ]);
            }

            // Steps (3–7 langkah)
            $stepCount = $faker->numberBetween(3, 7);
            for ($order = 1; $order <= $stepCount; $order++) {
                Step::create([
                    'recipe_id'   => $recipe->id,
                    'instruction' => $faker->sentence(10),
                    'order'       => $order,
                ]);
            }

            // Nutritions basic
            $nutritionsTemplate = [
                'Calories'      => $faker->numberBetween(150, 800) . ' kcal',
                'Protein'       => $faker->numberBetween(5, 40) . ' g',
                'Carbohydrates' => $faker->numberBetween(10, 90) . ' g',
                'Fat'           => $faker->numberBetween(3, 30) . ' g',
            ];

            foreach ($nutritionsTemplate as $name => $value) {
                Nutrition::create([
                    'recipe_id' => $recipe->id,
                    'name'      => $name,
                    'value'     => $value,
                ]);
            }

            $maxRatings = min(count($userIds), 5);
            $selectedUserIds = $faker->randomElements(
                $userIds,
                $faker->numberBetween(1, $maxRatings)
            );

            foreach ($selectedUserIds as $uid) {
                Rating::firstOrCreate(
                    [
                        'recipe_id' => $recipe->id,
                        'user_id'   => $uid,
                    ],
                    [
                        'rating'    => $faker->numberBetween(1, 5),
                    ]
                );
            }
        }
    }
}
