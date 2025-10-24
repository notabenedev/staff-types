<?php

namespace Notabenedev\StaffTypes\Traits;

use App\Contact;

trait ShouldStaffOfferEmail
{
    public function submissionEmail(){
        $emails = false;
        if ($this->form->name == "staff-employee-form" && class_exists(Contact::class)) {
            foreach ($this->values as $value) {
                if ($value->field->name == "address") {
                    $contact = Contact::query()->where('title', "=", $value->value)
                        ->orWhere('address', '=', $value->value)->first();
                    if (!$contact || !$contact->links_data) break;
                    foreach ($contact->links_data as $name => $values) {
                        if ($name == "emails" && !empty($values)) {
                            $emails = $values[0]["value"];
                            break;
                        }
                    }
                }
            }
        }
        return $emails;
    }
}