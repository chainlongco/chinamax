<?php

namespace Tests\Unit\Models\Customers;

use Tests\TestCase;
use App\Models\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CustomerTest extends TestCase
{
    use RefreshDatabase;
    private $customer;

    public function setUp(): void
    {
        parent::setUp();
        $this->customer = Customer::factory()->make();
    }

    //['first_name', 'last_name', 'phone', 'email', 'address1', 'address2', 'city', 'state', 'zip', 'card_number', 'expired', 'cvv', 'updated_at']
    
    public function test_customers_table_has_first_name_field()
    {
        $firstname = $this->customer->first_name;
        $this->assertNotEmpty($firstname);
    }

    public function test_customers_table_has_last_name_field()
    {
        $lastname = $this->customer->last_name;
        $this->assertNotEmpty($lastname);
    }

    public function test_customers_table_has_phone_field()
    {
        $phone = $this->customer->phone;
        $this->assertNotEmpty($phone);
    }

    public function test_customers_table_has_email_field()
    {
        $email = $this->customer->email;
        $this->assertNotEmpty($email);
    }

    public function test_customers_table_has_password_field()
    {
        $password = $this->customer->password;
        $this->assertNotEmpty($password);
    }

    public function test_customers_table_has_address1_field()
    {
        $address1 = $this->customer->address1;
        $this->assertNotEmpty($address1);
    }

    public function test_customers_table_has_address2_field()
    {
        $address2 = $this->customer->address2;
        $this->assertNotEmpty($address2);
    }

    public function test_customers_table_has_city_field()
    {
        $city = $this->customer->city;
        $this->assertNotEmpty($city);
    }

    public function test_customers_table_has_state_field()
    {
        $state = $this->customer->state;
        $this->assertNotEmpty($state);
    }

    public function test_customers_table_has_zip_field()
    {
        $zip = $this->customer->zip;
        $this->assertNotEmpty($zip);
    }

    public function test_customers_table_has_card_number_field()
    {
        $cardNumber = $this->customer->card_number;
        $this->assertNotEmpty($cardNumber);
    }

    public function test_customers_table_has_expired_field()
    {
        $expired = $this->customer->expired;
        $this->assertNotEmpty($expired);
    }

    public function test_customers_table_has_cvv_field()
    {
        $cvv = $this->customer->cvv;
        $this->assertNotEmpty($cvv);
    }

    public function test_customers_table_has_updated_at_field()
    {
        $updatedAt = $this->customer->updated_at;
        $this->assertNotEmpty($updatedAt);
    }
}
