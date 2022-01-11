<?php

namespace Tests\Unit\Models\Users;

use Tests\TestCase;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UserTest extends TestCase
{
    use RefreshDatabase; //DatabaseMigrations; //DatabaseTransactions;//RefreshDatabase;
    private $user;
    
    protected function setUp(): void
    {
        parent::setUp();
        /*$this->user = User::create([
            'name'=>'Jacky Shyu',
            'email'=>'shyujacky@yahoo.com',
            'password'=>Hash::make('12345678')
        ]);*/
        $this->user = User::factory()->make();
    }

    public function test_user_table_has_name_field()
    {        
        //$this->assertEquals('Jacky Shyu', $this->user->name);
        $name = $this->user->name;
        $this->assertNotEmpty($name);
    }

    public function test_user_table_has_email_field()
    {        
        $email = $this->user->email;
        $this->assertNotEmpty($email);
    }

    public function test_user_table_has_password_field()
    {        
        $password = $this->user->password;
        $this->assertNotEmpty($password);
    }

}
