<?php

namespace Sharelov\Shortener\Tests;

use Orchestra\Testbench\TestCase as OrchestraTestCase;

class TestCase extends OrchestraTestCase
{
    /**
     * Custom test fixture setup.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->getEnvironmentSetUp($this->app);
        $this->setUpDatabase($this->app);
    }

    /**
     * Define environment setup.
     *
     * @param \Illuminate\Foundation\Application $app
     */
    protected function getEnvironmentSetUp($app)
    {
        // Setup default database to use sqlite :memory:
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);

        $app['config']->set('app.key', '07h1sIsJustA7est7ok3nF0r7esting9');
        $app['config']->set('shortener.links_table', 'short_links');
    }

    protected function setUpDatabase($app)
    {
        include_once __DIR__.'/../src/migrations/create_table.php.stub';
        (new \CreateTable())->up();
    }
}
