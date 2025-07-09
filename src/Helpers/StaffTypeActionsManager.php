<?php

namespace Notabenedev\StaffTypes\Helpers;

use Illuminate\Support\Facades\Route;
use App\StaffType;

class StaffTypeActionsManager
{
    /**
     * Admin breadcrumbs
     *
     * @param StaffType $type
     * @return array
     *
     */
    public function getAdminBreadcrumb(StaffType $type)
    {
        $breadcrumb[] = (object) [
                "title" => config("staff-types.siteStaffTypesName"),
                "url" => route("admin.staff-types.index"),
                "active" => false,
            ];

        $routeParams = Route::current()->parameters();
        $active = ! empty($routeParams["type"]) &&
            $routeParams["type"]->id == $type->id;
        $breadcrumb[] = (object) [
            "title" => $type->title,
            "url" => route("admin.staff-types.show", ["type" => $type]),
            "active" => $active,
        ];

        return $breadcrumb;
    }
}