<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class RecaptchaController extends Controller
{
    public static function validateRecaptcha($token)
    {

        $cliente = new Client(['base_uri' => 'https://www.google.com/']);

        $response = $cliente->post('recaptcha/api/siteverify', [
            'form_params' => [
                'secret' => env('RECAPTCHA_SECRET_KEY'),
                'response' => $token,
            ]
        ]);

        $responseData = json_decode($response->getBody(), true);


        return $responseData['success'] ?? false;
    }
}
