<?php

namespace Database\Factories;
use App\Models\Contact;
use App\Models\Company;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Contact>
 */
class ContactFactory extends Factory
{
     protected $model = Contact::class;

    public function definition()
    {
        return [
            'firstname'  => $this->faker->firstName,
            'lastname'   => $this->faker->lastName,
            'email'      => $this->faker->unique()->safeEmail,
            'company_id' => Company::factory(),
        ];
    }
}
