<?php

namespace Codebank\Acl;

use Illuminate\Support\ServiceProvider;

class AclServiceProvider extends ServiceProvider {

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishMigration();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerCodebankAcl();
    }

    /**
     * Register the application bindings.
     *
     * @return void
     */
    private function registerCodebankAcl()
    {
        $this->app->bind('acl', function ($app)
        {
            return new Acl($app);
        });
    }

    /**
     * Publish the migration to the application migration folder
     */
    public function publishMigration()
    {
        $this->publishes([
            __DIR__ . '/../../migrations/' => base_path('/database/migrations'),
                ], 'migrations');
    }

}
