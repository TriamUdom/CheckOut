<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AuthorControllerTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_showAuthorPage()
    {
        $this->withSession([
            'user_logged_in' => true,
        ])->get('/author');

        $this->seeStatusCode(200);
        $this->seePageIs('/author');
    }
}
