<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

use Illuminate\Support\Facades\Auth;

class SchoolMailValidation implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        {
            if(!preg_match('/^[A-Za-z0-9._%+-]+@mydavinci\.nl$/', $value)){
                $fail('Email domein moet eindigen @mydavinci.nl');
            }
        }
    }
}
