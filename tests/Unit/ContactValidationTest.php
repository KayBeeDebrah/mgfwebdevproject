<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Contact;
use App\Models\Company;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;
use Mockery;
use App\Support\Validation\ContactValidation;

class ContactValidationTest extends TestCase
{
      /** Add these 2 lines */
    protected $testCompany;
    use RefreshDatabase;  // Resets DB after each test

    protected function setUp(): void
    {
        parent::setUp();
        $this->testCompany = Company::factory()->create();
    }
    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    /** @test */
    public function firstname_is_required()
    {
        $data = [
            'lastname' => 'Doe',
            'email' => 'john@example.com',
            'company_id' => $this->testCompany->id,
        ];

        //check validation
        $validator = Validator::make($data, ContactValidation::rules());
       

        $this->assertFalse($validator->passes());
        $this->assertEquals(['firstname'], array_keys($validator->errors()->messages()));
    }

    /** @test */
    public function lastname_is_required()
    {
        $data = [
            'firstname' => 'John',
            'email' => 'john@example.com',
            'company_id' => $this->testCompany->id,
        ];

         $validator = Validator::make($data, ContactValidation::rules());
        $this->assertFalse($validator->passes());
        $this->assertArrayHasKey('lastname', $validator->errors()->messages());
    }

    /** @test */
    public function email_must_be_valid_email()
    {
        $data = [
            'firstname' => 'John',
            'lastname' => 'Doe',
            'email' => 'invalid-email',
            'company_id' => $this->testCompany->id,
        ];

        $validator = Validator::make($data, ContactValidation::rules());

        $this->assertFalse($validator->passes());
        $this->assertArrayHasKey('email', $validator->errors()->messages());
    }

    /** @test */
    public function email_must_be_unique()
    {
        // Create contact with existing email
        Contact::factory()->create(['email' => 'john@example.com']);

        $data = [
            'firstname' => 'John',
            'lastname' => 'Doe',
            'email' => 'john@example.com',
            'company_id' => $this->testCompany->id,
        ];

         $validator = Validator::make($data, ContactValidation::rules());

        $this->assertFalse($validator->passes());
        $this->assertArrayHasKey('email', $validator->errors()->messages());
    }

    /** @test */
    public function firstname_has_max_length()
    {
        $longName = str_repeat('A', 46); // Longer than 45 chars

        $data = [
            'firstname' => $longName,
            'lastname' => 'Doe',
            'email' => 'john@example.com',
            'company_id' => $this->testCompany->id,
        ];

         $validator = Validator::make($data, ContactValidation::rules());

        $this->assertFalse($validator->passes());
        $this->assertArrayHasKey('firstname', $validator->errors()->messages());
    }

    /** @test */
    public function company_id_must_exist()
    {
        $data = [
            'firstname' => 'John',
            'lastname' => 'Doe',
            'email' => 'john@example.com',
            'company_id' => 999999, // Non-existent ID
        ];

        $validator = Validator::make($data, ContactValidation::rules());

        $this->assertFalse($validator->passes());
        $this->assertArrayHasKey('company_id', $validator->errors()->messages());
    }

    /** @test */
    public function valid_data_passes_validation()
    {
        $data = [
            'firstname' => 'John',
            'lastname' => 'Doe',
            'email' => 'john.doe@example.com',
            'company_id' => $this->testCompany->id,
        ];

         $validator = Validator::make($data, ContactValidation::rules());

        $this->assertTrue($validator->passes());
        $this->assertEmpty($validator->errors()->messages());
    }

    /** @test */
    public function update_validation_ignores_current_record_email()
    {
        $existingContact = Contact::factory()->create(['email' => 'john@example.com']);
        
        $data = [
            'firstname' => 'John Updated',
            'lastname' => 'Doe',
            'email' => 'john@example.com', // Same as existing
            'company_id' => $this->testCompany->id,
        ];

        $validator = Validator::make($data, [
            'firstname' => 'required|string|max:45',
            'lastname' => 'required|string|max:45',
            'email' => "required|email|unique:contacts,email,{$existingContact->id}|max:90",
            'company_id' => 'nullable|exists:companies,id',
        ]);

        $this->assertTrue($validator->passes());
    }
}
