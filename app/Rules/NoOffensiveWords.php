<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class NoOffensiveWords implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  Closure(string, ?string=): PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $offensiveWords = ['stupied'];
        $lowerCaseValue = mb_strtolower($value);
        foreach ($offensiveWords as $word) {
            if(str_contains($lowerCaseValue, $word)) {
        $fail("The :attribute contains inappropriate content.");                return;
            }
        }
    }
}
