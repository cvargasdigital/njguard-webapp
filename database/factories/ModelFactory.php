<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(Api\Users\Model\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->safeEmail,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});

$factory->define(Api\Companies\Models\Company::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->company,
        'business_description' => $faker->paragraphs(3, true),
        'sector' => $faker->sentence,
        'peer_group' => $faker->sentence,
        'country' => $faker->country,
        'country_of_incorporation' => $faker->country,
        'region' => $faker->sentence,
        'employees' => $faker->numberBetween(100, 1500),
        'market_cap' => $faker->randomNumber,
    ];
});

$factory->define(Api\Companies\Models\Director::class, function (Faker\Generator $faker) {
    return [
        'roles' => $faker->sentence,
        'is_chairman' => $faker->boolean,
        'is_ceo' => $faker->boolean,
        'is_lead' => $faker->boolean,
        'class' => $faker->randomElement(['insider','outsider']),
        'is_independent' => $faker->boolean,
        'total_boards' => $faker->randomDigit,
        'tenure' => (int) $faker->numberBetween(4, 20),
        'audit_committee' => $faker->randomElement([null,'M','C']),
        'nominating_committee' => $faker->randomElement([null,'M','C']),
        'remuneration_committee' => $faker->randomElement([null,'M','C']),
        'executive_roles' => $faker->randomDigit,
        'board_roles' => $faker->randomDigit,
        'chairmanships' => $faker->randomDigit,
        'overboarded' => $faker->randomDigit,
        'audit_overboarded' => $faker->randomDigit,
        'inside_roles' => $faker->sentence,
        'cluster' => $faker->paragraphs(3, true),
    ];
});

$factory->define(Api\Companies\Models\Executive::class, function (Faker\Generator $faker) {
    return [
        'is_ceo' => $faker->boolean,
        'role' => $faker->sentence,
    ];
});

$factory->define(Api\Companies\Models\Person::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'date_of_birth' => $faker->date('Y'),
        'sex' => $faker->randomElement(['M','F','X']),
        'biography' => $faker->paragraphs(4, true),
        'roles' => $faker->sentence,
    ];
});

$factory->define(Api\Companies\Models\Compensation::class, function (Faker\Generator $faker) {
    return [
        'fiscal_year_end' => $faker->date('Y'),
        'iso_code' => $faker->randomElement(['USD','GDP']),
        'base_salary' => $faker->numberBetween(100000, 30000000),
        'annual_bonus' => $faker->numberBetween(5000, 1000000),
        'stock' => $faker->numberBetween(5000, 1000000),
        'options' => $faker->numberBetween(5000, 1000000),
        'other_lti' => $faker->numberBetween(5000, 1000000),
        'other_compensation' => $faker->numberBetween(5000, 1000000),
        'total' => $faker->numberBetween(10000000, 50000000),
    ];
});

$factory->define(Api\Companies\Models\Equity::class, function (Faker\Generator $faker) {
    return [
        'fiscal_year_end' => $faker->date('Y'),
        'exercisable_options' => $faker->numberBetween(100000, 30000000),
        'unexercisable_options' => $faker->numberBetween(100000, 30000000),
        'exercise_price' => $faker->numberBetween(5000, 1000000),
        'unvested_shares' => $faker->numberBetween(5000, 1000000),
        'vested_shares' => $faker->numberBetween(5000, 1000000),
    ];
});

$factory->define(Api\Companies\Models\Event::class, function (Faker\Generator $faker) {
    return [
        'indicator_code' => $faker->lexify('?.?.??'),
        'name' => $faker->realText,
        'score' => $faker->randomDigit,
    ];
});

$factory->define(Api\Companies\Models\Incident::class, function (Faker\Generator $faker) {
    return [
        'type' => $faker->realText,
        'title' => $faker->realText,
        'summary' => $faker->paragraphs(2, true),
        'analysis' => $faker->paragraphs(5, true),
        'risk' => $faker->numberBetween(1,10),
        'impact' => $faker->numberBetween(1,10),
        'source' => $faker->url,
    ];
});

$factory->define(Api\Companies\Models\Development::class, function (Faker\Generator $faker) {
    return [
        'event_type' => $faker->sentence,
        'headline' => $faker->realText,
        'situation' => $faker->paragraphs(3, true),
        'announced_date' => $faker->date('Y-m-d'),
    ];
});

$factory->define(Api\Companies\Models\Provision::class, function (Faker\Generator $faker) {
    return [
        'type' => $faker->randomElement(['takeover','governance']),
        'pillar' => $faker->numerify('G.#.#'),
        'code' => $faker->numerify('#.#'),
        'value' => $faker->randomElement(['yes','no']),
        'name' => $faker->sentence,
    ];
});

$factory->define(Api\Companies\Models\Ownership::class, function (Faker\Generator $faker) {
    return [
        'holder_name' => $faker->company,
        'percent_shares_outstanding' => $faker->numberBetween(1,85) / 10,
    ];
});

$factory->define(Api\Companies\Models\Indicator::class, function (Faker\Generator $faker) {
    return [
        'indicator_code' => $faker->numerify('G.#.#'),
        'name' => $faker->sentence,
        'description' => $faker->paragraph,
        'score' => $faker->numberBetween(1,100),
        'comment' => $faker->paragraphs(3, true),
        'source' => $faker->url,
        'tickbox_comment' => $faker->paragraph,
        'tickbox_code' => $faker->numerify('#.#.#'),
    ];
});

$factory->define(Api\Companies\Models\Affiliation::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'type' => $faker->name,
        'start_date' => $faker->date('Y'),
        'end_date' => $faker->randomElement([null, $faker->date('Y')]),
        'description' => $faker->sentence,
    ];
});

