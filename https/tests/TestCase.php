<?php

namespace Tests;

use App\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Redis;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function setUp()
    {
        parent::setUp();

        Artisan::call('migrate:refresh');
    }

    public function loginAdmin()
    {
        $user = factory(User::class)->create();
        Config::push('bahdcasts.administrator', $user->email);
        $this->actingAs($user);
    }

    public function flushRedis()
    {
        Redis::flushall();
    }
}
