<?php

namespace Tests\Feature;

use Tests\TestCase;

class EnvTest extends TestCase
{
    public function test_env(): void
    {
        dump('APP_ENV: '.config('app.env'));
        dump('DB_CONNECTION: '.config('database.default'));
        $this->assertEquals('testing', config('app.env'));
    }
}
