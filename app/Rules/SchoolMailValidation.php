<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

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
            $domainPart = explode('@', $value)[1] ?? null;
          
            if ($domainPart != 'mydavinci.nl') {
              $fail('email must be your school mail');
            }
            if(!preg_match('/^[A-Za-z0-9._%+-]+@mydavinci\.nl$/'
            , $value)){
                $fail('email is invalid');
            }
        }
    }
}
