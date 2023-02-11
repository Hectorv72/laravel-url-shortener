<?php

namespace App\Http\Controllers;

use App\Models\Shortener;
use Exception;

class ShortenerController extends Controller
{
    public function show($key = '')
    {
        try {
            $shortener = Shortener::where('shortened_key', $key)->first();
            if ($shortener) {
                $shortener->interactions += 1;
                $shortener->save();
                return view('redirect', ['urldir' => $shortener->linked_url]);
            }
            return response('<h1>Lo sentimos, no existe ningún acortador con esa clave :(</h1>');
        } catch (Exception $e) {
            error_log($e->getMessage());
            return response('<h1>Lo sentimos, ocurrió un error vuelva a intentarlo más tárde</h1>');
        }
    }
}
