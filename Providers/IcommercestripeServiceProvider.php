<?php

namespace Modules\Icommercestripe\Providers;

use Illuminate\Support\Arr;
use Illuminate\Support\ServiceProvider;
use Modules\Core\Events\BuildingSidebar;
use Modules\Core\Events\LoadingBackendTranslations;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Icommercestripe\Events\Handlers\RegisterIcommercestripeSidebar;

class IcommercestripeServiceProvider extends ServiceProvider
{
    use CanPublishConfiguration;

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     */
    public function register(): void
    {
        $this->registerBindings();
        $this->app['events']->listen(BuildingSidebar::class, RegisterIcommercestripeSidebar::class);

        $this->app['events']->listen(LoadingBackendTranslations::class, function (LoadingBackendTranslations $event) {
            $event->load('icommercestripes', Arr::dot(trans('icommercestripe::icommercestripes')));
            // append translations
        });
    }

    public function boot(): void
    {
        $this->publishConfig('icommercestripe', 'permissions');
        $this->publishConfig('icommercestripe', 'config');
        $this->publishConfig('icommercestripe', 'crud-fields');

        $this->mergeConfigFrom($this->getModuleConfigFilePath('icommercestripe', 'settings'), 'asgard.icommercestripe.settings');
        $this->mergeConfigFrom($this->getModuleConfigFilePath('icommercestripe', 'settings-fields'), 'asgard.icommercestripe.settings-fields');

        //$this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
    }

    /**
     * Get the services provided by the provider.
     */
    public function provides(): array
    {
        return [];
    }

    private function registerBindings()
    {
        $this->app->bind(
            'Modules\Icommercestripe\Repositories\IcommerceStripeRepository',
            function () {
                $repository = new \Modules\Icommercestripe\Repositories\Eloquent\EloquentIcommerceStripeRepository(new \Modules\Icommercestripe\Entities\IcommerceStripe());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Icommercestripe\Repositories\Cache\CacheIcommerceStripeDecorator($repository);
            }
        );
        // add bindings
    }
}
