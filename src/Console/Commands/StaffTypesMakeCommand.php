<?php

namespace Notabenedev\StaffTypes\Console\Commands;

use App\Menu;
use App\MenuItem;
use PortedCheese\BaseSettings\Console\Commands\BaseConfigModelCommand;


class StaffTypesMakeCommand extends BaseConfigModelCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:staff-types
    {--all : Run all}
    {--models : Export models}
    {--controllers : Export controllers}
    {--policies : Export policies}
    {--vue : Export vue}
    ';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Settings for staff-types package';

    /**
     * Vendor Name
     * @var string
     *
     */
    protected $vendorName = 'Notabenedev';

    /**
     * Package Name
     * @var string
     *
     */
    protected $packageName = 'StaffTypes';

    /**
     * The models to  be exported
     * @var array
     */
    protected $models = ["StaffType", "StaffOffer", "StaffParamUnit", "StaffParamName", "StaffParam"];

    /**
     * Make Controllers
     */
    protected $controllers = [
        "Admin" => ["StaffTypeController", "StaffParamUnitController", "StaffParamNameController", "StaffOfferController"],
        "Ajax" => ["StaffParamController"],
        "Site" => ["StaffYmlController"]
    ];

    /**
     * Policies
     * @var array
     *
     */
    protected $ruleRules = [
        [
            "title" => "Типы сотрудников",
            "slug" => "staff-types",
            "policy" => "StaffTypePolicy",
        ],
        [
            "title" => "Группы параметров для сотрудников",
            "slug" => "staff-param-units",
            "policy" => "StaffParamUnitPolicy",
        ],
        [
            "title" => "Имена параметров для групп сотрудников",
            "slug" => "staff-param-names",
            "policy" => "StaffParamNamePolicy",
        ],
        [
            "title" => "Предложения сотрудников",
            "slug" => "staff-offers",
            "policy" => "StaffOfferPolicy",
        ],
        [
            "title" => "Параметры сотрудников и предложений",
            "slug" => "staff-params",
            "policy" => "StaffParamPolicy",
        ],

    ];

    /**
     * Vue files folder
     *
     * @var string
     */
    protected $vueFolder = "staff-types";

    /**
     * Vue files list
     *
     * @var array
     */
    protected $vueIncludes = [
        'admin' => [
            'staff-params' => "ParamsComponent",
        ],
        'app' => [],
    ];

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $all = $this->option("all");

        if ($this->option("models") || $all) {
            $this->exportModels();
        }
        if ($this->option("controllers") || $all) {
            $this->exportControllers("Admin");
            $this->exportControllers("Ajax");
            $this->exportControllers("Site");
        }
        if ($this->option("policies") || $all) {
            $this->makeRules();
        }
        if ($this->option("vue") || $all) {
            $this->makeVueIncludes("admin");
        }
        return 0;
    }

}
