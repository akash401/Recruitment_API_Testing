<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
    ];
});
$factory->define(App\Candidates::class, function () {
    return [
        'first_name' => 'test_firstname',
        'last_name' => 'test_lastname',
        'email' => 'makash@addonit.in',
        'contact_number' => '8899889988',
        'gender' => 1,
        'specialization' => 'unittest specialization',
        'work_ex_year' => 3,
        'candidate_dob' => '2020-04-05',
        'address' => 'unittest address',
        'resume' => 'unittest testproduct',
    ];
});