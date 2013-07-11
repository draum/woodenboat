<?php

class TestCase extends Illuminate\Foundation\Testing\TestCase
{

    /**
     * Default preparation for each test
     */
    public function setUp()
    {
        parent::setUp();

        $this->prepareForTests();
                
    }

    /**
     * Creates the application.
     *
     * @return Symfony\Component\HttpKernel\HttpKernelInterface
     */
    public function createApplication()
    {
        $unitTesting = true;

        $testEnvironment = 'testing';

        return require __dir__ . '/../../bootstrap/start.php';
    }


    /**
     * Migrates the database and set the mailer to 'pretend'.
     * This will cause the tests to run quickly.
     *
     */
    private function prepareForTests()
    {
        
        Artisan::call('migrate');
        Artisan::call('db:seed');
    }

    /**
     * Short-cuts for REST / HTTP calls
     */    
    public function __call($method, $args) {
        if (in_array($method, array('get', 'post', 'put', 'patch', 'delete'))) {
            return $this->call($method, $args[0]);
        }
        throw new BadMethodCallException;
    }

}
