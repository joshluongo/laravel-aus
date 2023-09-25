<?php

namespace LaravelAus\LaravelAus\Tests;

use Faker\Factory;
use Faker\Generator;
use LaravelAus\LaravelAus\Fakers\AbnAcnProvider;
use LaravelAus\LaravelAus\LaravelAusServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    public Generator $faker;

    protected function setUp(): void
    {
        $faker = Factory::create();
        $faker->addProvider(new AbnAcnProvider($faker));
        $this->faker = $faker;
    }

    protected function getPackageProviders($app)
    {
        return [
            LaravelAusServiceProvider::class,
        ];
    }
}
