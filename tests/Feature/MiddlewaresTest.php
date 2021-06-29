<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\RolesTableSeeder;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MiddlewaresTest extends TestCase
{
    use RefreshDatabase;
    use DatabaseMigrations;

    protected $authorUser;
    protected $adminUser;
    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        $this->authorUser=User::factory()->create();
        $this->adminUser=User::factory()->admin()->create();
        $this->seed(RolesTableSeeder::class);
    }

    /**
     * @test
     */
    public function author_should_be_directed_to_authors_dashboard_after_login()
    {
//        $this->withoutExceptionHandling();
        $email=$this->authorUser->email;
        $password=$this->authorUser->password;
        $resp=$this->post('login',['email'=>$email,'password'=>$password]);

        $resp->assertRedirect('/home');
    }
}