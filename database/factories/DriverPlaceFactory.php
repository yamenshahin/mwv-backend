<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\DriverPlace;
use App\User;
use Faker\Generator as Faker;

$factory->define(DriverPlace::class, function (Faker $faker) {
    return [
        'user_id' => User::all()->random()->id,
        'address' => $faker->streetAddress,
        'lat' =>  $faker->randomFloat($nbMaxDecimals = 6, $min = -33.944489, $max = -33.737885),
        'lng' =>  $faker->randomFloat($nbMaxDecimals = 6, $min = 150.836090, $max = 151.235260),
        'distance' => 25,
        'stars' => $faker->numberBetween($min = 0, $max = 5),
        'votes' => $faker->numberBetween($min = 1, $max = 5),
        'price_small_van_weekday' =>  $faker->randomFloat($nbMaxDecimals = 2, $min = 0.00, $max = 90.00),
        'price_small_van_weekend' =>  $faker->randomFloat($nbMaxDecimals = 2, $min = 0.00, $max = 90.00),
        'price_mid_van_weekday' =>  $faker->randomFloat($nbMaxDecimals = 2, $min = 0.00, $max = 90.00),
        'price_mid_van_weekend' =>  $faker->randomFloat($nbMaxDecimals = 2, $min = 0.00, $max = 90.00),
        'price_large_van_weekday' =>  $faker->randomFloat($nbMaxDecimals = 2, $min = 0.00, $max = 90.00),
        'price_large_van_weekend' =>  $faker->randomFloat($nbMaxDecimals = 2, $min = 0.00, $max = 90.00),
        'price_giant_van_weekday' =>  $faker->randomFloat($nbMaxDecimals = 2, $min = 0.00, $max = 90.00),
        'price_giant_van_weekend' =>  $faker->randomFloat($nbMaxDecimals = 2, $min = 0.00, $max = 90.00),
        'price_stop' =>  $faker->randomFloat($nbMaxDecimals = 2, $min = 0.00, $max = 90.00),
        'price_mile' =>  $faker->randomFloat($nbMaxDecimals = 2, $min = 0.00, $max = 90.00),
        'price_step' =>  $faker->randomFloat($nbMaxDecimals = 2, $min = 0.00, $max = 90.00)
    ];
});
