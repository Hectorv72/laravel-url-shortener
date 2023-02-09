<?php

namespace App\Http\Controllers;

use App\Models\Shortener;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ShortenerController extends Controller
{
    public function all()
    {
        return new JsonResponse(Shortener::all());
    }
}
