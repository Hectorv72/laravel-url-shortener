<?php

namespace App\Http\Controllers;

use App\Models\Shortener;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Exception;
use PDOException;

class ShortenerController extends Controller
{
    private $errorMessage = 'Lo sentimos, ocurrió un error vuelva a intentarlo más tárde';

    private function serverErrorMessage($e)

    {
        error_log($e->getMessage());
        return response()->json(['message' => $this->errorMessage], Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    public function show($key = '')
    {
        try {
            $shortener = Shortener::where('shortened_key', $key)->first();
            if ($shortener) {
                return view('redirect', ['urldir' => $shortener->linked_url]);
            }
            return response('<h1>Lo sentimos, no existe ningún acortador con esa clave :(</h1>');
        } catch (Exception $e) {
            error_log($e->getMessage());
            return response('<h1>' . $this->errorMessage . '</h1>');
        }
    }

    public function all()
    {
        try {
            return response()->json(Shortener::all(), Response::HTTP_OK);
        } catch (Exception $e) {
            return $this->serverErrorMessage($e);
        }
    }

    public function find($key = null)
    {
        try {
            $shortener = Shortener::where('shortened_key', $key)->first();
            if ($shortener) {
                $shortener = $shortener->setHidden(['updated_at', 'created_at', 'user_id', 'id']);
                return response()->json($shortener, Response::HTTP_OK);
            } else {
                return response()->json(['message' => 'No existe un acortador con esa clave'], Response::HTTP_NOT_FOUND);
            }
        } catch (Exception $e) {
            return $this->serverErrorMessage($e);
        }
    }

    /**
     * Busca entre los registros la url enviada y verifica su existencia
     * En caso de encontrarla: Devuelve como respuesta la información del registro existente
     * En caso de no existir: Crea un nuevo registro con la información
     */
    public function create(Request $request)
    {
        $user_id = auth()->user()?->id;
        try {
            $shortener = Shortener::where([['linked_url', $request->input()], ['user_id', $user_id]])->first();

            if (!$shortener) {
                $shortener = new Shortener([
                    'shortened_key' => Str::random(5),
                    'linked_url' => $request->input('url'),
                    'life_time' => date('Y-m-d', strtotime(date('Y-m-d') . '+2 days')),
                    'user_id' => $user_id
                ]);
                $shortener->save();
            }
            $shortener = $shortener->setHidden(['updated_at', 'created_at', 'user_id', 'id'])->toArray();
            return response()->json($shortener, Response::HTTP_OK);
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                return response()->json(['message' => 'Los campos enviados no corresponden a un objeto, revise y vuelva a intentarlo'], Response::HTTP_BAD_REQUEST);
            }
            return $this->serverErrorMessage($e);
        } catch (Exception $e) {
            return $this->serverErrorMessage($e);
        }
    }

    public function delete($key)
    {
        $user_id = auth()->user()->id;
        try {
            $shortener = Shortener::find($key);
            if ($shortener) {
                if ($shortener->user_id == $user_id) {
                    $shortener->delete();
                    return response()->json(['message' => 'Link eliminado correctamente'], Response::HTTP_OK);
                }
            }
        } catch (Exception $e) {
            return $this->serverErrorMessage($e);
        }
    }
}
