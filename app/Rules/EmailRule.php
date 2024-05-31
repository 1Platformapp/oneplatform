<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class EmailRule implements Rule
{
    public function passes($attribute, $value)
    {
        return filter_var($value, FILTER_VALIDATE_EMAIL) && $this->isRfcCompliant($value);
    }

    public function message()
    {
        return 'The :attribute must be a valid email address.';
    }

    private function isRfcCompliant($email)
    {
        return (bool) preg_match('/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', $email);
    }
}
