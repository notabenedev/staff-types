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
    protected $models = ["StaffType", "StaffOffer", "StaffParamUnit", "StaffParamName"];

    /**
     * Make Controllers
     */
    protected $controllers = [
        "Admin" => ["StaffTypeController"],
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
        ]
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
        }
        if ($this->option("policies") || $all) {
            $this->makeRules();
        }
        if ($this->option("menu") || $all) {
            $this->makeMenu();
        }
        return 0;
    }

    /**
     * @return void
     */
    protected function makeMenu()
    {
        try {
            $menu = Menu::query()
                ->where('key', 'admin')
                ->firstOrFail();
        }
        catch (\Exception $e) {
            return;
        }

        $title = config("staff-types.sitePackageName");
        $itemData = [
            'title' => $title,
            'template' => "staff-types::admin.menu",
            'url' => "#",
            'ico' => 'far fa-newspaper',
            'menu_id' => $menu->id,
        ];

        try {
            $menuItem = MenuItem::query()
                ->where("menu_id", $menu->id)
                ->where('title', $title)
                ->firstOrFail();
            $menuItem->update($itemData);
            $this->info("Элемент меню '$title' обновлен");
        }
        catch (\Exception $e) {
            MenuItem::create($itemData);
            $this->info("Элемент меню '$title' создан");
        }
    }

}
