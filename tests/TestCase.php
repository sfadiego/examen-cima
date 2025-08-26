<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\WithFaker;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, WithFaker;
    public static bool $migrated = false;
    protected function setUp(): void
    {
        parent::setUp();
        if (! self::$migrated) {
            self::runFreshMigrations();
            self::$migrated = true;
        }
        $this->withoutVite();
        $this->withoutExceptionHandling();
    }

    public function runFreshMigrations(): void
    {
        $this->artisan('migrate:fresh');
        $this->artisan('db:seed');
    }
}
