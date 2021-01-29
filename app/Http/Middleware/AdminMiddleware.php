<?php

namespace App\Http\Middleware;

use App\Model\Auth\Entity\User;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Config;

class AdminMiddleware extends Middleware
{
    public function handle($request, $next, ...$guard)
    {
        /** @var User $user */
        $user = $request->user();
        if ($user && $user->getRole()->isAdmin()) {
            $this->setRequiredAdminConfigs();
            return $next($request);
        }

        return redirect()->route('login');
    }

    private function setRequiredAdminConfigs(): void
    {
        Config::set('breadcrumbs.view', 'admin._shared.segments.breadcrumbs');
        Config::set('breadcrumbs.files', base_path('routes/breadcrumbs/admin_breadcrumbs.php'));
    }
}
