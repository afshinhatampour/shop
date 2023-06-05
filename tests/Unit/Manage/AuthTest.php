<?php

namespace Manage;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;
use Throwable;

class AuthTest extends TestCase
{
    use DatabaseMigrations;
//
//    /**
//     * @return void
//     */
//    public function runDatabaseMigrations(): void
//    {
//        $this->artisan('migrate:refresh');
//        $this->artisan('db:seed');
//        $this->artisan('passport:install');
//    }
//
//    /**
//     * @return void
//     * @test
//     * @throws Throwable
//     */
//    public function login()
//    {
//        $existUserInfo = User::where('id', 1)->first(['email'])->toArray();
//        $existUserInfo['password'] = 'password';
//        $response = $this->post(route('login'), $existUserInfo);
//        $response->assertStatus(Response::HTTP_OK);
//
//        $content = $response->decodeResponseJson();
//        $content->assertPath('message', trans('user.manage.login.success'));
//    }
}
