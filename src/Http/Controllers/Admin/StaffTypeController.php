<?php

namespace Notabenedev\StaffTypes\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Meta;
use App\StaffDepartment;
use App\StaffType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StaffTypeController extends Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->authorizeResource(StaffType::class, "staff-types");
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

        $collection = StaffType::query()
                ->orderBy("title","desc");
        $types= $collection->get();

        return view("staff-types::admin.staff-types.index", compact("types"));
    }

    /**
     * Show the form for creating a new resource
     *
     * @param StaffType|null $type
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     *
     */
    public function create(StaffType $type = null)
    {
        return view("staff-types::admin.staff-types.create", [
            "type" => $type,
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
        $item = StaffType::create($request->all());
        $this->updateDepartments($request->all(), $item);

        return redirect()
            ->route("admin.staff-types.show", ["type" => $item])
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
     * @param StaffType $type
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(StaffType $type)
    {
        // units
        $unitsCount = isset($type->units)? $type->units->count(): null;
        if ($unitsCount) {
            $units = $type->units()->orderBy("priority")->get();
        }
        else {
            $units = false;
        }
        // departments
        $departmentsCount = isset($type->departments) ? $type->departments->count(): null;
        if ($departmentsCount) {
            $departments = $type->departments()->orderBy("priority")->get();
        }
        else {
            $departments = false;
        }

        return view("staff-types::admin.staff-types.show", [
            "type" => $type,
            "units" => $units,
            "departments" => $departments
        ] );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param StaffType $type
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     *
     */
    public function edit(StaffType $type)
    {
        return view("staff-types::admin.staff-types.edit", compact("type"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param StaffType $type
     * @return \Illuminate\Http\RedirectResponse
     *
     */
    public function update(Request $request, StaffType $type)
    {
        $this->updateValidator($request->all(), $type);
        $type->update($request->all());
        $this->updateDepartments($request->all(), $type);

        return redirect()
            ->route("admin.staff-types.show", ["type" => $type])
            ->with("success", "Успешно обновлено");
    }

    /**
     * Update validate
     *
     * @param array $data
     * @param StaffType $type
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function updateValidator(array $data, StaffType $type)
    {
        $id = $type->id;
        Validator::make($data, [
            "title" => ["required", "max:150"],
            "slug" => ["nullable", "max:150", "unique:staff_types,slug,{$id}"],
        ], [], [
            "title" => "Заголовок",
            "slug" => "Адресная строка",
        ])->validate();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param StaffType $type
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(StaffType $type)
    {
        $type->delete();

        return redirect()
            ->route("admin.staff-types.index")
            ->with("success", "Успешно удалено");

    }



    /**
     * To export file
     *
     * @param StaffType $type
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     */

    public function export(StaffType $type)
    {
        $this->authorize("update", $type);

        $type->exported();

        return
                redirect()
                ->back()
                ->with("success", "Успешно изменено");

    }

    /**
     * Обновить отделы.
     *
     * @param $userInput
     */
    protected function updateDepartments($userInput, StaffType $type)
    {
        $departmentIds = [];
        foreach ($userInput as $key => $value) {
            if (strstr($key, "check-") == false) {
                continue;
            }
            $departmentIds[] = $value;
        }
        $departments = StaffDepartment::query()->whereIn('id',  $departmentIds)->get();
        foreach ($departments as $department){
            $department->staff_type_id = $type->id;
            $department->save();
        }
    }

}
