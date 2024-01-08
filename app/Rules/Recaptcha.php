<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Http;

class Recaptcha implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => '6LcY-EkpAAAAAMtrbD1XXGn7vA4exuiCW0ZHzun8',
            'response' => $value
        ])->object();

        $data = json_decode( json_encode($response), true);

        print_r($data);
        // exit;
        // error_log($data->implode(' '));

        if($data['success'] && $data['score'] >=0.7){
            $fail('Recaptcha no fue superado');
        }
    }
}
