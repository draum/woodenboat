<?php

namespace WBDB\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Register all the service providers for the DataStore Repositories
 * which are independent of the underlying persistence layer
 *
 * Class RepositoryServiceProviders
 *
 * @package WA\Providers
 */
class RepositoryServiceProviders extends ServiceProvider
{
    /**
     * Register all repository providers
     *
     * @return void
     */
    public function register()
    {
        // Use IoC to ensure all the required models are available

    }

}
