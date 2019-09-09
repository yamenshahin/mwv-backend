<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\DriverPlace;
use App\User;
use Faker\Generator as Faker;

$factory->define(DriverPlace::class, function (Faker $faker) {
    return [
        'user_id' => User::all()->random()->id,
        'address' => $faker->streetAddress,
        'lat' =>  '0.00',
        'lng' =>  '0.00',
        'distance' => 25,
        'stars' => $faker->numberBetween($min = 0, $max = 5),
        'votes' => $faker->numberBetween($min = 1, $max = 5),
        
        'price_small_van_weekday' => $faker->randomFloat($nbMaxDecimals = 2, $min = 0.00, $max = 90.00),
        'price_small_van_weekday1' => $faker->randomFloat($nbMaxDecimals = 2, $min = 0.00, $max = 90.00),
        'price_small_van_weekday2' => $faker->randomFloat($nbMaxDecimals = 2, $min = 0.00, $max = 90.00),
        'price_small_van_weekday3' => $faker->randomFloat($nbMaxDecimals = 2, $min = 0.00, $max = 90.00),
        'price_small_van_weekday4' => $faker->randomFloat($nbMaxDecimals = 2, $min = 0.00, $max = 90.00),
        'price_small_van_weekend' => $faker->randomFloat($nbMaxDecimals = 2, $min = 0.00, $max = 90.00),
        'price_small_van_weekend1' => $faker->randomFloat($nbMaxDecimals = 2, $min = 0.00, $max = 90.00),
        'price_small_van_weekend2' => $faker->randomFloat($nbMaxDecimals = 2, $min = 0.00, $max = 90.00),
        'price_small_van_weekend3' => $faker->randomFloat($nbMaxDecimals = 2, $min = 0.00, $max = 90.00),
        'price_small_van_weekend4' => $faker->randomFloat($nbMaxDecimals = 2, $min = 0.00, $max = 90.00),

        'price_mid_van_weekday' => $faker->randomFloat($nbMaxDecimals = 2, $min = 0.00, $max = 90.00),
        'price_mid_van_weekday1' => $faker->randomFloat($nbMaxDecimals = 2, $min = 0.00, $max = 90.00),
        'price_mid_van_weekday2' => $faker->randomFloat($nbMaxDecimals = 2, $min = 0.00, $max = 90.00),
        'price_mid_van_weekday3' => $faker->randomFloat($nbMaxDecimals = 2, $min = 0.00, $max = 90.00),
        'price_mid_van_weekday4' => $faker->randomFloat($nbMaxDecimals = 2, $min = 0.00, $max = 90.00),
        'price_mid_van_weekend' => $faker->randomFloat($nbMaxDecimals = 2, $min = 0.00, $max = 90.00),
        'price_mid_van_weekend1' => $faker->randomFloat($nbMaxDecimals = 2, $min = 0.00, $max = 90.00),
        'price_mid_van_weekend2' => $faker->randomFloat($nbMaxDecimals = 2, $min = 0.00, $max = 90.00),
        'price_mid_van_weekend3' => $faker->randomFloat($nbMaxDecimals = 2, $min = 0.00, $max = 90.00),
        'price_mid_van_weekend4' => $faker->randomFloat($nbMaxDecimals = 2, $min = 0.00, $max = 90.00),

        'price_large_van_weekday' => $faker->randomFloat($nbMaxDecimals = 2, $min = 0.00, $max = 90.00),
        'price_large_van_weekday1' => $faker->randomFloat($nbMaxDecimals = 2, $min = 0.00, $max = 90.00),
        'price_large_van_weekday2' => $faker->randomFloat($nbMaxDecimals = 2, $min = 0.00, $max = 90.00),
        'price_large_van_weekday3' => $faker->randomFloat($nbMaxDecimals = 2, $min = 0.00, $max = 90.00),
        'price_large_van_weekday4' => $faker->randomFloat($nbMaxDecimals = 2, $min = 0.00, $max = 90.00),
        'price_large_van_weekend' => $faker->randomFloat($nbMaxDecimals = 2, $min = 0.00, $max = 90.00),
        'price_large_van_weekend1' => $faker->randomFloat($nbMaxDecimals = 2, $min = 0.00, $max = 90.00),
        'price_large_van_weekend2' => $faker->randomFloat($nbMaxDecimals = 2, $min = 0.00, $max = 90.00),
        'price_large_van_weekend3' => $faker->randomFloat($nbMaxDecimals = 2, $min = 0.00, $max = 90.00),
        'price_large_van_weekend4' => $faker->randomFloat($nbMaxDecimals = 2, $min = 0.00, $max = 90.00),

        'price_giant_van_weekday' => $faker->randomFloat($nbMaxDecimals = 2, $min = 0.00, $max = 90.00),
        'price_giant_van_weekday1' => $faker->randomFloat($nbMaxDecimals = 2, $min = 0.00, $max = 90.00),
        'price_giant_van_weekday2' => $faker->randomFloat($nbMaxDecimals = 2, $min = 0.00, $max = 90.00),
        'price_giant_van_weekday3' => $faker->randomFloat($nbMaxDecimals = 2, $min = 0.00, $max = 90.00),
        'price_giant_van_weekday4' => $faker->randomFloat($nbMaxDecimals = 2, $min = 0.00, $max = 90.00),
        'price_giant_van_weekend' => $faker->randomFloat($nbMaxDecimals = 2, $min = 0.00, $max = 90.00),
        'price_giant_van_weekend1' => $faker->randomFloat($nbMaxDecimals = 2, $min = 0.00, $max = 90.00),
        'price_giant_van_weekend2' => $faker->randomFloat($nbMaxDecimals = 2, $min = 0.00, $max = 90.00),
        'price_giant_van_weekend3' => $faker->randomFloat($nbMaxDecimals = 2, $min = 0.00, $max = 90.00),
        'price_giant_van_weekend4' => $faker->randomFloat($nbMaxDecimals = 2, $min = 0.00, $max = 90.00),

        'price_stop' =>  $faker->randomFloat($nbMaxDecimals = 2, $min = 0.00, $max = 90.00),
        'price_mile' =>  $faker->randomFloat($nbMaxDecimals = 2, $min = 0.00, $max = 90.00),
        'price_stairs' =>  $faker->randomFloat($nbMaxDecimals = 2, $min = 0.00, $max = 90.00),
        'miles_driven' =>  $faker->randomFloat($nbMaxDecimals = 2, $min = 0.00, $max = 90.00),
        'jobs_booked' => $faker->numberBetween($min = 0, $max = 5)
    ];
});
