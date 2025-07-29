<?php

namespace Notabenedev\StaffTypes\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\StaffDepartment;
use App\StaffEmployee;
use App\StaffType;
use Illuminate\Support\Facades\Cache;

class StaffYmlController extends Controller
{

    public function show(StaffType $type)
    {
        if (! $type->exported_at)
            return redirect(route("site.departments.index"), 301);
        $key =  config('staff-types.cacheKey:'.$type->slug, "staff-export-yml");
        $yml = Cache::remember( $key, config('staff-types.cacheLifetime', 0), function () use ($type) {
            $file = new \SimpleXMLElement("<?xml version='1.0' encoding='UTF-8' ?><yml_catalog></yml_catalog>");
            $file->addAttribute('date', date('Y-m-d h:i'));
            $shop = $file->addChild("shop");
            $shop->addChild("name",  config("staff-types.ymlName","") );
            $shop->addChild("company",  config("staff-types.ymlCompany",""));
            $shop->addChild("url", route("home") );
            $shop->addChild("picture",  asset(config("staff-types.ymlPicture","favicon.png")) );
            $currencies = $shop->addChild("currencies");
            $currency = $currencies->addChild("currency");
            $currency->addAttribute("id",config("staff-types.siteCurrencyDefault"));
            $currency->addAttribute("rate", "1");

            $categoriesYml = $shop->addChild("categories");
            $categoryYml = $categoriesYml->addChild("category", $type->title);
            $categoryYml->addAttribute("id", $type->id);

            $setsYml = $shop->addChild("sets");
            $departments = StaffDepartment::query()->select("id", "title","short", "slug");
            $departmentsFilter = config("staff-types.departmentFilterField",null);
            if (! empty($departmentsFilter))
                $departments->whereNotNull($departmentsFilter);
            $departments->chunk(100, function ($departments) use ($setsYml) {
                foreach ($departments as $department) {
                    $setYml = $setsYml->addChild("set");
                    $setYml->addAttribute("id", $department->slug);
                    $setYml->addChild("name", $department->short? $department->short: $department->title);
                    $setYml->addChild("url", route("site.departments.show",["department" => $department->slug]));
                }
            });

            $offersYml = $shop->addChild("offers");
            $employees = StaffEmployee::query();
            $employees->chunk(100, function ($employees) use ($offersYml) {
                $imageRoute =  class_exists(\App\ImageFilter::class) ? 'image-filter' : 'imagecache';
                foreach ($employees as $employee) {
                    if ($employee->published_at){
                        // image
                        $imageSrc = $employee->image ? route($imageRoute, ['template' => 'original', 'filename' => $employee->image->file_name]) : null;
                        // description
                        $description =
                            (config("staff-types.stripTags", true) ?
                                htmlspecialchars(strip_tags($employee->description),ENT_XML1) :
                                (! empty($employee->description) ? '<![CDATA[ '.htmlspecialchars($employee->description, ENT_XML1).' ]]>' : '' )
                            );

                        foreach ($employee->offers as $offer){
                            if ($offer->published_at && ($offer->price || $offer->sales_notes)){

                                // generate xml
                                $offerYml = $offersYml->addChild("offer");
                                $offerYml->addAttribute("id", $offer->slug);
                                $offerYml->addAttribute("group_id", $employee->id);

                                $offerYml->addChild("name", htmlspecialchars($offer->title));
                                $offerYml->addChild("url", route("site.employees.show", ["employee" => $employee]).'#'.$offer->slug);

                                $priceYML = $offerYml->addChild("price", $offer->price);
                                if ($offer->from_price)
                                    $priceYML->addAttribute('from', true);
                                if ($offer->old_price > $offer->price)
                                    $offerYml->addChild("old_price", $offer->price);

                                $offerYml->addChild("currencyId", $offer->currency);
                                $offerYml->addChild("sales_notes", $offer->sales_notes);

                                $sets = '';
                                foreach ($offer->departments as $item){
                                    $sets = (!empty($sets) ? $sets.',' : $sets).$item->slug;
                                }

                                $offerYml->addChild("set-ids", $sets);
                                $offerYml->addChild("description", $description);
                                if ($imageSrc)
                                    $offerYml->addChild("picture", "$imageSrc");

                                $this->addParams($employee->params, $offerYml);
                                $this->addParams($offer->params, $offerYml);
                            }
                        }
                    }
                }
            });
            return $file->asXML();
        });
        return response($yml, 200)->header('Content-Type', 'text/xml') ;
    }

    protected function addParams($params, $yml){
        if ($params)
        foreach ($params as $param){
            $paramYML = $yml->addChild("param", "$param->value");
            $name = $param->name->name;
            if ($param->name->unit->demonstrated_at){
                $paramYML->addAttribute('name', $param->name->unit->title. " - ".($param->setHuman +1));
                $paramYML->addAttribute('unit', $name);
            }
            else{
                $paramYML->addAttribute('name', $name);
            }
        }
    }
}