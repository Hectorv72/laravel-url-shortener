<?php

namespace App\Http\Controllers;

use App\Models\Shortener;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;
use Exception;
use PDOException;

class ShortenerController extends Controller
{
    private $errorMessage = "Lo sentimos, ocurrió un error vuelva a intentarlo más tárde";
    private function serverErrorMessage($e)
    {
        error_log($e->getMessage());
        return new JsonResponse(["message" => $this->errorMessage], 500);
    }

    public function show($key = '')
    {
        try {
            $shortener = Shortener::where('shortened_key', $key)->first();
            if ($shortener) {
                return view('redirect', ['urldir' => $shortener->linked_url]);
            }
            return new Response('<h1>Lo sentimos, no existe ningún acortador con esa clave :(</h1>');
        } catch (Exception $e) {
            error_log($e->getMessage());
            return new Response("<h1>" . $this->errorMessage . "</h1>");
        }
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
                    'life_time' => date('Y-m-d', strtotime(date('Y-m-d') . '+2 days')),
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

    public function delete($key)
    {
        $user = null;
        try {
            $shortener = Shortener::find($key);
            if ($shortener) {
                if ($shortener->user_id == $user?->id) {
                    $shortener->delete();
                    return new JsonResponse(["message" => "Link eliminado correctamente"], 200);
                }
            }
        } catch (Exception $e) {
            return $this->serverErrorMessage($e);
        }
    }
}
