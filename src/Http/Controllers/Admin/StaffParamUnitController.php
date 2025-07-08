<?php

namespace Notabenedev\StaffTypes\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\StaffParamUnit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StaffParamUnitController extends Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->authorizeResource(StaffParamUnit::class, "type");
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     *
     */
    public function index(Request $request)
    {

        $collection = StaffParamUnit::query()
                ->orderBy("priority","desc");
        $units= $collection->get();

        return view("staff-types::admin.staff-param-units.index", compact("units"));
    }

    /**
     * Show the form for creating a new resource
     *
     * @param StaffParamUnit|null $unit
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     *
     */
    public function create(StaffParamUnit $unit = null)
    {
        return view("staff-types::admin.staff-param-units.create", [
            "type" => $unit,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     *
     */
    public function store(Request $request)
    {
        $this->storeValidator($request->all());
        $item = StaffParamUnit::create($request->all());
        $this->demonstrate($item, $request->get("demonstrated-btn"));

        return redirect()
            ->route("admin.staff-param-units.show", ["unit" => $item])
            ->with("success", "Добавлено");
    }

    /**
     * Validator
     *
     * @param array $data
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function storeValidator(array $data)
    {
        Validator::make($data, [
            "title" => ["required", "max:150"],
            "slug" => ["nullable", "max:150", "unique:staff_types,slug"],
        ], [], [
            "title" => "Заголовок",
            "slug" => "Адресная строка",
        ])->validate();
    }

    /**
     * Display the specified resource.
     *
     * @param StaffParamUnit $unit
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(StaffParamUnit $unit)
    {
        $namesCount = isset($unit->names)? $unit->names->count(): null;
        if ($namesCount) {
            $names = $unit->names()->orderBy("priority")->get();
        }
        else {
            $names = false;
        }

        $typesCount = isset($unit->types)? $unit->types->count(): null;
        if ($typesCount) {
            $types = $unit->types()->get();
        }
        else {
            $types = false;
        }

        return view("staff-types::admin.staff-param-units.show", [
            "unit" => $unit,
            "names" => $names,
            "types" => $types,
        ] );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param StaffParamUnit $unit
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     *
     */
    public function edit(StaffParamUnit $unit)
    {
        return view("staff-types::admin.staff-param-units.edit", compact("unit"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param StaffParamUnit $unit
     * @return \Illuminate\Http\RedirectResponse
     *
     */
    public function update(Request $request, StaffParamUnit $unit)
    {
        $this->updateValidator($request->all(), $unit);
        $unit->updateTypes($request->all(), true);
        $this->demonstrate($unit, $request->get("demonstrated-btn"));
        $unit->update($request->all());

        return redirect()
            ->route("admin.staff-param-units.show", ["unit" => $unit])
            ->with("success", "Успешно обновлено");
    }

    /**
     * Update validate
     *
     * @param array $data
     * @param StaffParamUnit $unit
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function updateValidator(array $data, StaffParamUnit $unit)
    {
        $id = $unit->id;
        Validator::make($data, [
            "title" => ["required", "max:150"],
            "slug" => ["nullable", "max:150", "unique:staff_param_units,slug,{$id}"],
        ], [], [
            "title" => "Заголовок",
            "slug" => "Адресная строка",
        ])->validate();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param StaffParamUnit $unit
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(StaffParamUnit $unit)
    {
        $unit->delete();

        return redirect()
            ->route("admin.staff-param-units.index")
            ->with("success", "Успешно удалено");

    }


    /**
     * @param StaffParamUnit $unit
     * @param $check
     * @return void
     */
    protected function demonstrate(StaffParamUnit $unit, $check)
    {
        $checkStatus = $check ? 1 : null;
        $status = $unit->demonstrated_at ? 1 : null;
        if ($status !== $checkStatus)
            $unit->demonstrated();
    }



}
