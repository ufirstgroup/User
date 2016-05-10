<?php namespace Modules\User\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Modules\Core\Foundation\Asset\Manager\AssetManager;
use Modules\Core\Foundation\Asset\Pipeline\AssetPipeline;
use Pingpong\Modules\Facades\Module;

class AssetServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     * @return void
     */
    public function register()
    {
        $this->bindAssets();
    }

    /**
     * Bind classes related to assets
     */
    private function bindAssets()
    {
        $this->app[AssetManager::class]->addAsset('user_editlink.js', Module::asset('user:js/editlink.js'));
		$this->app[AssetManager::class]->addAsset('user_editlink.css', Module::asset('user:css/editlink.css'));
		$this->app[AssetPipeline::class]->requireJs('user_editlink.js');
        $this->app[AssetPipeline::class]->requireCss('user_editlink.css');
    }
}
