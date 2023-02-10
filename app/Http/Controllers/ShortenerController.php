<?php

namespace App\Http\Controllers;

use App\Models\Shortener;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;
use Exception;
use PDOException;

class ShortenerController extends Controller
{

    private function serverErrorMessage($e)
    {
        error_log($e->getMessage());
        return new JsonResponse(["message" => "Ocurrió un error, vuelva a intentarlo más tárde"], 500);
    }

    public function all()
    {
        try {
            return new JsonResponse(Shortener::all(), 200);
        } catch (Exception $e) {
            return $this->serverErrorMessage($e);
        }
    }

    public function find($key = null)
    {
        try {
            $shortener = Shortener::where('shortened_key', $key)->first();
            if ($shortener) {
                return new JsonResponse($shortener->setHidden(['updated_at', 'created_at', 'user_id', 'id']), 200);
            } else {
                return new JsonResponse(["message" => "No existe un acortador con esa clave"], 404);
            }
        } catch (Exception $e) {
            return $this->serverErrorMessage($e);
        }
    }

    /**
     * Busca entre los registros la url enviada y verifica su existencia
     * En caso de encontrarla: Devuelve como respuesta la información del registro existente
     * En caso de no existir: Crea un nuevo registro con la información
     * @return JsonResponse
     */
    public function create(Request $request)
    {
        $user = null;
        try {
            $shortener = Shortener::where([['linked_url', $request->input()], ['user_id', $user]])->first();

            if (!$shortener) {
                $shortener = new Shortener([
                    'shortened_key' => Str::random(5),
                    'linked_url' => $request->input('url'),
                    'user_id' => $user
                ]);
                $shortener->save();
            }
            return new JsonResponse($shortener->setHidden(['updated_at', 'created_at', 'user_id', 'id'])->toArray(), 200);
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                return new JsonResponse(["message" => "Los campos enviados no corresponden a un objeto, revise y vuelva a intentarlo"], 400);
            }
            return $this->serverErrorMessage($e);
        } catch (Exception $e) {
            return $this->serverErrorMessage($e);
        }
    }
}
