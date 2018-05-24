<?php

namespace HubertNNN\FlowPlayer\Integration\Laravel;

use HubertNNN\FlowPlayer\Contracts\FlowPlayer;
use HubertNNN\FlowPlayer\FlowPlayerService;
use Illuminate\Config\Repository;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class FlowPlayerServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/config.php', 'flowplayer'
        );

        $this->app->singleton(FlowPlayer::class, function ($app) {

            /** @var Application $app */
            /** @var Repository $config */
            $config = $app['config'];

            $apiKey = $config->get('flowplayer.credentials.apiKey');
            $siteId = $config->get('flowplayer.credentials.siteId');
            $userId = $config->get('flowplayer.credentials.userId');

            return new FlowPlayerService($apiKey, $siteId, $userId);
        });
    }

    public function boot()
    {
        $this->publishes([
            __DIR__.'/config.php' => config_path('flowplayer.php')
        ], 'config');
    }
}
