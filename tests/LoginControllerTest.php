<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LoginControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(){
        parent::setUp();

        Session::setDefaultDriver('array');
    }

    public function test_showLoginPage_success(){
        $this->get('/login');

        $this->seeStatusCode(200);
        $this->see('Login');
    }

    public function test_showLoginPage_already_logged_in(){
        $this->withSession([
            'user_logged_in' => true,
        ])->get('/login');

        $this->assertRedirectedTo('/');
    }

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

    public function test_showLogoutPage_without_login(){
        $this->get('/logout');

        $this->assertRedirectedTo('/login');
    }

    public function test_showLogoutPage_success(){
        $this->withSession([
            'user_logged_in' => true
        ])->get('/logout');

        $this->see('Logout');
    }

    public function test_handleLogout(){
        $this->withSession([
            'user_logged_in' => true,
        ])->call('POST', '/logout');

        $this->assertSessionMissing('user_logged_in');
    }
}
