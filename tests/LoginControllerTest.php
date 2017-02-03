<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LoginControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(){
        parent::setUp();

        Session::setDefaultDriver('array');
    }

    /**
     * A basic functional test example.
     *
     * @return void
     */
    /*public function test_handleLoginRequest_success(){
        $user = factory(App\User::class)->create();

        $response = $this->call('POST', '/login', [
            'username' => $user['username'],
            'password' => 'secret',
        ]);

        $this->assertRedirectedTo('/'); // @TODO We should change this behaviour so it'll support AJAX call
    }*/

    public function test_handleLoginRequest_empty_field(){
        // Call login with out all the required field
        $response = $this->call('POST', '/login', [
            'username' => 'Something',
            'password' => '',
        ]);

        // Should return 422
        $this->seeStatusCode(422);
    }

    public function test_handleLoginRequest_user_not_found(){
        // Call login with out all the required field
        $response = $this->call('POST', '/login', [
            'username' => 'Something',
            'password' => 'abcd',
        ]);

        // Should return 422
        $this->seeStatusCode(422);
    }

    public function test_handleLoginRequest_incorrect_password(){
        $user = factory(App\User::class)->create();

        // Call login with out all the required field
        $response = $this->call('POST', '/login', [
            'username' => $user['username'],
            'password' => 'incorrect_password',
        ]);

        // Should return 422
        $this->seeStatusCode(422);
    }

    public function test_handleLoginRequest_success(){
        $user = factory(App\User::class)->create();

        $response = $this->call('POST', '/login', [
            'username' => $user['username'],
            'password' => 'secret',
        ]);

        $this->seeStatusCode(200);
        $this->assertSessionHas('user_logged_in', true);
        $this->assertSessionHas('username', $user['username']);
    }
}
