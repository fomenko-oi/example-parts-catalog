<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use View;

class SidebarServiceProvider extends ServiceProvider
{

    /**
     * Sidebar service.
     *
     * @return void
     */
    public function boot()
    {
        View::composer(
            'admin._shared.includes.sidebar', 'App\Http\ViewComposers\SidebarViewComposer'
        );

        View::composer(
            'admin._shared.includes.header-horizontal', 'App\Http\ViewComposers\SidebarViewComposer'
        );
    }
}
