<?php

namespace LuongoLabs\LaravelAus\Tests;

use Faker\Factory;
use Faker\Generator;
use LuongoLabs\LaravelAus\Fakers\AbnAcnProvider;
use LuongoLabs\LaravelAus\LaravelAusServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    public Generator $faker;

    protected function setUp(): void
    {
        parent::setUp();

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
