<?php

namespace Notabenedev\StaffTypes\Http\Controllers\Admin;

use App\Contact;
use App\StaffOffer;
use App\StaffEmployee;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Notabenedev\StaffTypes\Facades\StaffOfferActions;
use Notabenedev\StaffTypes\Models\StaffType;

class StaffOfferController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->authorizeResource(StaffOffer::class, "staff-offers");
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param StaffEmployee $employee
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request, StaffEmployee $employee = null)
    {
        $collection = StaffOffer::query();
        if (! empty($employee)) {
            $collection->where("staff_employee_id", $employee->id);
            $fromRoute = route("admin.employees.show.staff-offers.index", ["employee" => $employee]);
        }
        else {
            $fromRoute = route("admin.employees.index");
        }
        if ($title = $request->get("title", false)) {
            $collection->where("title", "like", "%$title%");
        }
        if ($published = $request->get("published", "all")) {
            if ($published == "no") {
                $collection->whereNull("published_at");
            }
            elseif ($published == "yes") {
                $collection->whereNotNull("published_at");
            }
        }
        $collection->orderBy("priority");
        $offers = $collection->paginate()->appends($request->input());
        return view(
            "staff-types::admin.staff-offers.index",
            compact("employee", "fromRoute", "offers", "request")
        );
    }

    /**
     * Show create product view
     *
     * @param Request $request
     * @param StaffEmployee $employee
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function create(Request $request, StaffEmployee $employee)
    {
        return view(
            "staff-types::admin.staff-offers.create",
            compact("employee", "request")
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param StaffEmployee $employee
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, StaffEmployee $employee)
    {
        $this->storeValidator($request->all());
        if (! $request->get("price"))  $request["price"] = 0;
        if ($request["price"] == 0) {
            $request["sales_notes"] = StaffOffer::SALES_NOTES_VARIANTS["undefined"];
        }

        $offer = $employee->offers()->create($request->all());

        $contact= Contact::find($request->get('contact_id'));
        $offer->contact()->associate($contact);
        $offer->save();

        $type= StaffType::find($request->get('staff_type_id'));
        $offer->type()->associate($type);
        $offer->save();

        $this->publish($offer, $request->get("published-btn"));
        $this->updateDepartments($request->all(), $offer);
        return redirect()
            ->route("admin.staff-offers.show", ["offer" => $offer])
            ->with("success", "Добавлено");
    }

    /**]
     * @param $data
     */
    protected function storeValidator($data)
    {

       Validator::make($data, [
            "title" => ["required", "max:100", "unique:staff_offers,title"],
            "slug" => ["nullable", "max:250", "unique:staff_offers,slug"],
            "price" => ["nullable", "integer"],
            "from_price" => ["nullable", "boolean"],
            "old_price" => ["nullable", "integer"],
            "currency" => ["required_with:price", "in:".$this->allowedCurrencies()],
            "sales_notes" => ["nullable", "in:".$this->allowedNotes()],
            "experience" => ["required", "integer"],
            "city" => ["required", "max:100"],
            "contact_id" => ["required", "integer"],
            "staff_type_id" => ["required", "integer"],
        ], [], [
            "title" => "Заголовок",
            "slug" => "Адресная строка",
            "price" => "Стоимость",
            "old_price" => "Старая стоимость",
            "from_price" => "Стоимость от",
            "sales_notes" => "Комментарий",
            "currency" => "Валюта",
            "experience" => "Лет опыта",
            "city" => "Город работы",
            "contact_id" => "Адрес работы",
            "staff_type_id" => "Тип",
        ])->validate();
    }

    /**
     * @return string
     */

    protected function allowedNotes(){
        $allowed = "";
        foreach (array_values(StaffOffer::SALES_NOTES_VARIANTS) as $i => $value){
            $allowed = ($i !== 0? $allowed."," : $allowed).$value;
        }
        return $allowed;
    }

    /**
     * @return string
     */

    protected function allowedCurrencies(){
        $allowed = "";
        foreach (array_keys(StaffOffer::CURRENCY_VARIANTS) as $index => $value){
            $allowed = ($index !== 0? $allowed."," : $allowed).$value;
        }
        return $allowed;
    }

    /**
     * Display the specified resource.
     *
     * @param StaffOffer $offer
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     *
     */
    public function show(StaffOffer $offer)
    {
        $employee = $offer->employee;
        return view(
            "staff-types::admin.staff-offers.show",
            compact("offer", "employee")
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param StaffOffer $offer
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function edit(StaffOffer $offer)
    {
        $employee = $offer->employee;
        return view(
            "staff-types::admin.staff-offers.edit",
            compact("offer", "employee")
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param StaffOffer $offer
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, StaffOffer $offer)
    {
        $this->updateValidator($request->all(), $offer);
        // Обновление.
        if (! $request->get("price"))  $request["price"] = 0;
        if ($request["price"] == 0) {
            $request["sales_notes"] = StaffOffer::SALES_NOTES_VARIANTS["undefined"];
        }

        $offer->update($request->all());
        $this->publish($offer, $request->get("published-btn"));

        $contact= Contact::find($request->get('contact_id'));
        $offer->contact()->associate($contact);
        $offer->save();

        $type= StaffType::find($request->get('staff_type_id'));
        $offer->type()->associate($type);
        $offer->save();
        $this->updateDepartments($request->all(), $offer);

        return redirect()
            ->route("admin.staff-offers.show", ["offer" => $offer])
            ->with("success", "Параметр обновлен");
    }

    /**
     * @param $data
     * @param StaffOffer $offer
     */
    protected function updateValidator($data, StaffOffer $offer)
    {
        $id = $offer->id;
        Validator::make($data, [
            "title" => ["required", "max:100", "unique:staff_offers,title,{$id}"],
            "slug" => ["nullable", "max:250", "unique:staff_offers,slug,{$id}"],
            "price" => ["nullable", "integer"],
            "from_price" => ["nullable", "boolean"],
            "old_price" => ["nullable", "integer"],
            "currency" => ["required_with:price", "in:".$this->allowedCurrencies()],
            "sales_notes" => ["nullable", "in:".$this->allowedNotes()],
            "description" => ["nullable"],
            "experience" => ["required", "integer"],
            "city" => ["required", "max:100"],
            "contact_id" => ["required", "integer"],
            "staff_type_id" => ["required", "integer"],
        ], [], [
            "title" => "Заголовок",
            "slug" => "Адресная строка",
            "price" => "Стоимость",
            "old_price" => "Старая стоимость",
            "from_price" => "Стоимость от",
            "sales_notes" => "Услуга",
            "currency" => "Валюта",
            "description" => "Описание",
            "experience" => "Лет опыта",
            "city" => "Город работы",
            "contact_id" => "Адрес работы",
            "staff_type_id" => "Тип",

        ])->validate();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param StaffOffer $offer
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(StaffOffer $offer)
    {
        $employee = $offer->employee;
        $offer->delete();

        return redirect()
            ->route("admin.employees.show.staff-offers.index", ["employee" => $employee])
            ->with("success", "Удалено");
    }


    /**
     * @param StaffOffer $offer
     * @param $check
     * @return void
     */
    protected function publish(StaffOffer $offer, $check)
    {
        $checkStatus = $check ? 1 : null;
        $status = $offer->published_at ? 1 : null;
        if ($status !== $checkStatus)
            $offer->published();
    }

    /**
     * Priority
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function priority(StaffEmployee $employee){
        $this->authorize("update", StaffEmployee::class);
        $collection =$employee->offers()->orderBy("priority")->get();
        $groups = [];
        foreach ($collection as $item) {
            $groups[] = [
                "name" => $item->title,
                "id" => $item->id,
            ];
        }
        return view("staff-types::admin.staff-offers.priority", [
            'groups' => $groups,
            'employee' => $employee,
        ]);

    }

    /**
     * Изменить приоритет
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function changeItemsPriority(Request $request)
    {
        $data = $request->get("items", false);
        if ($data) {
            $result = StaffOfferActions::saveOrder($data);
            if ($result) {
                return response()
                    ->json("Порядок сохранен");
            }
            else {
                return response()
                    ->json("Ошибка, что то пошло не так");
            }
        }
        else {
            return response()
                ->json("Ошибка, недостаточно данных");
        }
    }

    /**
     * Страница параметров.
     *
     * @param StaffOffer $offer
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function params(StaffOffer $offer)
    {
        $this->authorize("update", $offer);
        $employee = $offer->employee;
        return view("staff-types::admin.staff-offers.params", [
            'offer' => $offer,
            'employee' => $employee,
        ]);
    }

    /**
     * Обновить отделы.
     *
     * @param $userInput
     */
    protected function updateDepartments($userInput, StaffOffer $offer)
    {
        $departmentIds = [];
        foreach ($userInput as $key => $value) {
            if (str_contains($key, "check-") == false) {
                continue;
            }
            $departmentIds[] = $value;
        }
        $offer->departments()->sync($departmentIds);
    }
}
