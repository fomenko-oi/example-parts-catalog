<?php

namespace App\Providers;

use App\Entity\Catalog\Brand;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * The path to the "home" route for your application.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        Route::bind('brand', function($value, \Illuminate\Routing\Route $route) {
            $categorySlug = $route->parameter('category');
            $regionSlug = $route->parameter('region');

            $brandField = $route->bindingFieldFor('brand');

            if ($brandField === 'id') {
                return $value;
            }

            if ($categorySlug && $regionSlug) {
                return Brand::where('slug', $value)->whereHas('region', function($q) use($regionSlug, $categorySlug) {
                    $q->where('slug', $regionSlug)->whereHas('category', function ($q) use($categorySlug) {
                        $q->where('slug', $categorySlug);
                    });
                })->firstOrFail();
            }

            return Brand::where('slug', $value)->firstOrFail();
        });
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapAdminRoutes();

        $this->mapCabinetRoutes();

        $this->mapWebRoutes();
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "cabinet" routes for the application.
     *
     * @return void
     */
    protected function mapCabinetRoutes()
    {
        Route::middleware('web')
            ->namespace("{$this->namespace}\\Cabinet")
            ->as('cabinet.')
            ->middleware(['web', 'auth'])
            ->group(base_path('routes/cabinet.php'));
    }

    /**
     * Define the "admin" routes for the application.
     *
     * @return void
     */
    protected function mapAdminRoutes()
    {
        Route::middleware('web')
            ->namespace("{$this->namespace}\\Admin")
            ->prefix('admin')
            ->as('admin.')
            ->middleware('admin')
            ->group(base_path('routes/admin.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/api.php'));
    }
}
