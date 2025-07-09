<?php

namespace Notabenedev\StaffTypes\Http\Controllers\Admin;

use App\StaffParamUnit;
use App\Http\Controllers\Controller;
use App\StaffParamName;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class StaffParamNameController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->authorizeResource(StaffParamName::class, "staff-param-names");
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param StaffParamUnit $unit
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request, StaffParamUnit $unit = null)
    {
        $collection = StaffParamName::query();
        if (! empty($unit)) {
            $collection->where("staff_param_unit_id", $unit->id);
            $fromRoute = route("admin.staff-param-units.staff-param-names.index", ["unit" => $unit]);
        }
        else {
            $fromRoute = route("admin.staff-param-units.index");
        }
        if ($title = $request->get("title", false)) {
            $collection->where("title", "like", "%$title%");
        }
        if ($expected = $request->get("expected", "all")) {
            if ($expected == "no") {
                $collection->whereNull("expected_at");
            }
            elseif ($expected == "yes") {
                $collection->whereNotNull("expected_at");
            }
        }
        $collection->orderBy("priority");
        $names = $collection->paginate()->appends($request->input());
        return view(
            "staff-types::admin.staff-param-names.index",
            compact("unit", "fromRoute", "names", "request")
        );
    }

    /**
     * Show create product view
     *
     * @param Request $request
     * @param StaffParamUnit $unit
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function create(Request $request, StaffParamUnit $unit)
    {
        return view(
            "staff-types::admin.staff-param-names.create",
            compact("unit", "request")
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param StaffParamUnit $unit
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, StaffParamUnit $unit)
    {
        $this->storeValidator($request->all());
        if (! $request->get("name"))  $request["name"] = $request->get("title");
        $name = $unit->names()->create($request->all());
        $this->expect($name, $request->get("expected-btn"));
        return redirect()
            ->route("admin.staff-param-names.show", ["name" => $name])
            ->with("success", "Параметр добавлен");
    }

    /**]
     * @param $data
     */
    protected function storeValidator($data)
    {
        Validator::make($data, [
            "title" => ["required", "max:100", "unique:staff_param_names,title"],
            "slug" => ["nullable", "max:250", "unique:staff_param_names,slug"],
            "name" => ["nullable", "max:150"],
            "value_type" => ["required", "in:".$this->allowedTypes()],
        ], [], [
            "title" => "Заголовок",
            "slug" => "Адресная строка",
            "name" => "Имя в выгрузке",
            "value_type" => "Тип значения",
        ])->validate();
    }

    /**
     * @return string
     */

    protected function allowedTypes(){
        $allowed = "";
        foreach (array_keys(StaffParamName::ALLOW_TYPES) as $index => $value){
            $allowed = ($index !== 0? $allowed."," : $allowed).$value;
        }
        return $allowed;
    }

    /**
     * Display the specified resource.
     *
     * @param StaffParamName $name
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     *
     */
    public function show(StaffParamName $name)
    {
        $unit = $name->unit;
        return view(
            "staff-types::admin.staff-param-names.show",
            compact("name", "unit")
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Request $request
     * @param StaffParamName $name
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function edit(StaffParamName $name)
    {
        $unit = $name->unit;
        return view(
            "staff-types::admin.staff-param-names.edit",
            compact("name", "unit")
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param StaffParamName $name
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, StaffParamName $name)
    {
        $this->updateValidator($request->all(), $name);
        // Обновление.
        $name->update($request->all());
        $this->expect($name, $request->get("expected-btn"));

        return redirect()
            ->route("admin.staff-param-names.show", ["name" => $name])
            ->with("success", "Параметр обновлен");
    }

    /**
     * @param $data
     * @param StaffParamName $name
     */
    protected function updateValidator($data, StaffParamName $name)
    {
        $id = $name->id;
        Validator::make($data, [
            "title" => ["required", "max:100", "unique:staff_param_names,title,{$id}"],
            "slug" => ["nullable", "max:250", "unique:staff_param_names,slug,{$id}"],
            "name" => ["nullable", "max:150"],
            "value_type" => ["required"],
        ], [], [
            "title" => "Заголовок",
            "slug" => "Адресная строка",
            "name" => "Имя в выгрузке",
            "value_type" => "Тип значения",
        ])->validate();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param StaffParamName $name
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(StaffParamName $name)
    {
        $unit = $name->unit;
        $name->delete();

        return redirect()
            ->route("admin.staff-param-units.staff-param-names.index", ["unit" => $unit])
            ->with("success", "Параметр удален");
    }


    /**
     * @param StaffParamName $name
     * @param $check
     * @return void
     */
    protected function expect(StaffParamName $name, $check)
    {
        $checkStatus = $check ? 1 : null;
        $status = $name->expected_at ? 1 : null;
        if ($status !== $checkStatus)
            $name->expected();
    }
}
