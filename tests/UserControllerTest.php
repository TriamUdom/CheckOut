<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserControllerTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function test_login()
    {
        $user = factory(App\User::class)->create();

        $response = $this->call('POST', '/login', [
            'username' => $user['username'],
            'password' => 'secret',
        ]);

        $this->assertRedirectedTo('/');
    }
}
