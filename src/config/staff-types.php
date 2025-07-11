<?php
return [
    "sitePackageName" => "Типы специалистов",
    "siteStaffTypeName" => "Тип специалистов",
    "siteStaffTypesName" => "Типы специалистов",
    "siteStaffParamUnitsName" => "Группы параметров",
    "siteStaffParamUnitName" => "Группа параметров",
    "siteStaffParamNamesName" => "Имена параметров",
    "siteStaffEmployeeOfferName" => "Предложение специалиста",
    "siteStaffEmployeeOffersName" => "Предложения специалиста",

    "siteCurrencyDefault" => "RUR",

    "typeUrlName" => "staff-types",
    "paramUnitUrlName" => "staff-param-units",

    "staffTypesAdminRoutes" => true,

    "offerFacade" => \Notabenedev\StaffTypes\Helpers\StaffOfferActionsManager::class,
    "paramNameFacade" => \Notabenedev\StaffTypes\Helpers\StaffParamNameActionsManager::class,
    "paramUnitFacade" => \Notabenedev\StaffTypes\Helpers\StaffParamUnitActionsManager::class,
    "typeFacade" => \Notabenedev\StaffTypes\Helpers\StaffTypeActionsManager::class,

];