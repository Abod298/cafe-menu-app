<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Inspiring;
use Illuminate\Http\Request;
use Inertia\Middleware;
use Tighten\Ziggy\Ziggy;
use Illuminate\Support\Facades\Gate;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }
    protected function getUserPermissions(Request $request)
    {
        // Retrieve all permissions from the Permission model
        $permissions = \App\Models\Permission::all();

        // Initialize the result array
        $userPermissions = [
            'access-dashboard' => true,
        ];

        // Loop through each permission from the database
        foreach ($permissions as $permission) {
            // Dynamically generate the key for each permission (e.g., access-dashboard, access-users, etc.)
            $permissionKey = 'access-' . str_replace('_management_access', '', $permission->title);

            // Check if the user has permission for this specific permission key
            $userPermissions[$permissionKey] = Gate::allows($permission->title);
        }
        return $userPermissions;
    }

    /**
     * Define the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        [$message, $author] = str(Inspiring::quotes()->random())->explode('-');

        return [
            ...parent::share($request),
            'name' => config('app.name'),
            'quote' => ['message' => trim($message), 'author' => trim($author)],
            'auth' => [
                'user' => $request->user(),
            ],
            'ziggy' => [
                ...(new Ziggy)->toArray(),
                'location' => $request->url(),
            ],
            'flash' => [
                'success' => fn() => $request->session()->get('success'),
                'error' => fn() => $request->session()->get('error'),
            ],
            'can' => $this->getUserPermissions($request),
        ];
    }
}
