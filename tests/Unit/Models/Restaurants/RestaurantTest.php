<?php

namespace Tests\Unit\Models\Restaurants;

use Tests\TestCase;
use App\Models\Restaurant;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RestaurantTest extends TestCase
{
    use RefreshDatabase;
    private $restaurant;

    public function setUp(): void
    {
        parent::setUp();
        $this->restaurant = Restaurant::factory()->make();
    }

    //['name', 'year_founded', 'tax_rate', 'phone', 'email', 'address1', 'address2', 'city', 'state', 'zip']
    
    public function test_restaurants_table_has_name_field()
    {
        $name = $this->restaurant->name;
        $this->assertNotEmpty($name);
    }

    public function test_restaurants_table_has_year_founded_field()
    {
        $yearfounded = $this->restaurant->year_founded;
        $this->assertNotEmpty($yearfounded);
    }

    public function test_restaurants_table_has_tax_rate_field()
    {
        $taxrate = $this->restaurant->tax_rate;
        $this->assertNotEmpty($taxrate);
    }

    public function test_restaurants_table_has_phone_field()
    {
        $phone = $this->restaurant->phone;
        $this->assertNotEmpty($phone);
    }

    public function test_restaurants_table_has_email_field()
    {
        $email = $this->restaurant->email;
        $this->assertNotEmpty($email);
    }

    public function test_restaurants_table_has_address1_field()
    {
        $address1 = $this->restaurant->address1;
        $this->assertNotEmpty($address1);
    }

    public function test_restaurants_table_has_address2_field()
    {
        $address2 = $this->restaurant->address2;
        $this->assertNotEmpty($address2);
    }

    public function test_restaurants_table_has_city_field()
    {
        $city = $this->restaurant->city;
        $this->assertNotEmpty($city);
    }

    public function test_restaurants_table_has_state_field()
    {
        $state = $this->restaurant->state;
        $this->assertNotEmpty($state);
    }

    public function test_restaurants_table_has_zip_field()
    {
        $zip = $this->restaurant->zip;
        $this->assertNotEmpty($zip);
    }
}
