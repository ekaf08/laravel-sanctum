<?php

use App\Models\Product;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('price');
            $table->text('description');
            $table->timestamps();
            $table->softDeletes();
        });

        $faker = \Faker\Factory::create();
        for ($i = 0; $i < 15; $i++) {
            Product::create([
                'name'  => $faker->word,
                'price' => $faker->randomNumber(3, true),
                'description' => $faker->sentence(10, true)
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
