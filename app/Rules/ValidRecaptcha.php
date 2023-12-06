<?php

namespace App\Rules;

use Closure;
use GuzzleHttp\Client;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidRecaptcha implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Initialization http client
        $client = new Client([
            'base_uri' => 'https://google.com/recaptcha/api/'
        ]);

        // Send data to google recaptcha
        $response = $client->post('siteverify', [
            'query'=> [
                'secret'=> env('NOCAPTCHA_SITEKEY'),
                'response' => $value
            ]
        ]);

        dd($response);
    }

     /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        // Message
        return 'ReCaptcha verification failed.';
    }
}
