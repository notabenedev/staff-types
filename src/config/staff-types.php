<?php
return [
    "sitePackageName" => "Типы специалистов",
    "siteStaffTypeName" => "Тип специалистов",
    "siteStaffTypesName" => "Типы специалистов",
    "siteStaffParamUnitsName" => "Группы параметров",
    "siteStaffParamUnitName" => "Группа параметров",
    "siteStaffParamNamesName" => "Имена параметров",
    "siteStaffParamsName" => "Параметры",
    "siteStaffParamName" => "Параметр",
    "siteStaffEmployeeOfferName" => "Предложение ",
    "siteStaffEmployeeOffersName" => "Предложения ",

    "siteCurrencyDefault" => "RUR",

    "typeUrlName" => "staff-types",
    "paramUnitUrlName" => "staff-param-units",

    /*
   |-------------------------------------
   | Доступные модели
   |-------------------------------------
   |
   | Можно перечислить модели которые обладают параметрами,
   | при этом у модели должен быть метод params.
   |
   | public function params() {
   |   return $this->morphMany('App\StaffParam', 'paramable');
   | }
   |
   */

    "staffParamModels" => [
        "employee" => "App\StaffEmployee",
        "staff-offer" => "App\StaffOffer",
    ],

    "staffTypesAdminRoutes" => true,
    "staffParamUnitsAdminRoutes" => true,
    "staffParamNamesAdminRoutes" => true,
    "staffOffersAdminRoutes" => true,
    "staffParamsAjaxRoutes" => true,
    "staffYmlSiteRoutes" => true,

    "paramFacade" => \Notabenedev\StaffTypes\Helpers\StaffParamActionsManager::class,
    "offerFacade" => \Notabenedev\StaffTypes\Helpers\StaffOfferActionsManager::class,
    "paramNameFacade" => \Notabenedev\StaffTypes\Helpers\StaffParamNameActionsManager::class,
    "paramUnitFacade" => \Notabenedev\StaffTypes\Helpers\StaffParamUnitActionsManager::class,
    "typeFacade" => \Notabenedev\StaffTypes\Helpers\StaffTypeActionsManager::class,


    "cacheLifetime" => 86400,
    "cacheKey" => "staff-export-yml",
    "ymlUrlName" => "staff-export",
    "ymlName" => "",
    "ymlCompany" => "",
    "ymlPicture" => "",
    "departmentFilterField" => "published_at",
    "stripTags" => true,
];