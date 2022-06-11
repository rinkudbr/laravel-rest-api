<?php

namespace Tests\Feature\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;


class LoginTest extends TestCase
{
    public function testRequiresEmailAndLogin()
    {
        $this->postJson('api/login')
            ->assertStatus(422)
            ->assertJson([
                'error'=>[
                    'email' => ['The email field is required.'],
                    'password' => ['The password field is required.'],
                ]
            ]);
    }


    public function testUserPasswordLengthValidation()
    {
        $email = 'test@gmail.com';
        $password = '123';


        // Simulated landing
        $response = $this->postJson('api/login',[
            'email' => $email,
            'password' => $password,
        ]);

        //Write the response in laravel.log
        \Log::info(1, [$response->getContent()]);

        // Determine whether password validation is failed or not
        $response->assertStatus(422);
    }

    public function testUserLoginsSuccessfully()
    {
        $email = rand(12345,678910).'test987@gmail.com';

        // Creating Users
        User::create([
            'name' => 'Test',
            'email'=> $email,
            'password' => $password = bcrypt('rinku@123')
        ]);

        // Simulated landing
        $response = $this->postJson('api/login',[
            'email' => $email,
            'password' => 'rinku@123',
        ]);

        //Write the response in laravel.log
        \Log::info(1, [$response->getContent()]);

        // Determine whether the login is successful and receive token
        $response->assertStatus(200);

        $this->assertArrayHasKey('token',$response->json());

        // Delete users
        User::where('email',$email)->delete();

    }
}

