<?php

namespace Sharelov\Shortener\Tests;

use Orchestra\Testbench\TestCase as OrchestraTestCase;

class TestCaseWithSoftDeletes extends OrchestraTestCase
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
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);
        $app['config']->set('shortener.links_table', 'short_links');
        $app['config']->set('shortener.enable_soft_deletes', true);
        $app['config']->set('shortener.hash_length', 1);
    }

    protected function setUpDatabase($app)
    {
        include_once __DIR__.'/../src/migrations/create_shortener_table.php.stub';
        (new \CreateShortenerTable())->up();
    }
}
