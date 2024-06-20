<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ClientController extends Controller
{

    public function index()
    {
        $clients = Client::all();

        if ($clients->isEmpty()) {
            $data = [
                'status' => 200,
                'message' => 'No se encontró clientes',
            ];
            return response()->json($data, 200);
        }

        $data = [
            'status' => 200,
            'data' => $clients,
        ];

        return response()->json($data, 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:110'],
            'lastname' => ['required', 'string', 'max:110']
        ]);

        if ($validator->fails()) {
            $data = [
                'status' => 500,
                'message' => 'Error en la validación',
                'errors' => $validator->errors()
            ];
            return response()->json($data, 500);
        }

        $client = new Client();
        $client->name = $request->name;
        $client->lastname = $request->lastname;
        $client->save();

        if (!$client) {
            $data = [
                'status' => 400,
                'message' => 'Error al crear el cliente'
            ];
            return response()->json($data, 400);
        }

        $data = [
            'status' => 201,
            'message' => 'Cliente creado con éxito',
            'data' => $client
        ];

        return response()->json($data, 201);
    }


    public function show($id)
    {
        try {
            // Intenta encontrar al cliente por su ID
            $client = Client::find($id);
            Log::debug('Client found: ', ['client' => $client]);

            // Verifica si el cliente no fue encontrado
            if (!$client) {
                $data = [
                    'status' => 404,
                    'message' => 'No se encontró al cliente'
                ];
                return response()->json($data, 404);
            }

            // Retorna el cliente encontrado
            return response()->json($client, 200);
        } catch (\Exception $e) {
            // Registra el error en el log
            Log::error('Error al obtener el cliente: ', ['error' => $e->getMessage()]);

            // Retorna una respuesta JSON con el error
            $data = [
                'status' => 500,
                'message' => 'Ocurrió un error al obtener el cliente'
            ];
            return response()->json($data, 500);
        }
    }


    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:110'],
            'lastname' => ['required', 'string', 'max:110']
        ]);

        if ($validator->fails()) {
            $data = [
                'status' => 500,
                'message' => 'Error en la validación',
                'errors' => $validator->errors()
            ];
            return response()->json($data, 500);
        }

        $client = Client::find($id);

        if (!$client) {
            $data = [
                'status' => 404,
                'message' => 'No se encontró al cliente'
            ];
            return response()->json($data, 404);
        }

        $client->name = $request->name;
        $client->lastname = $request->lastname;
        $client->update();

        $data = [
            'status' => 200,
            'message' => 'Cliente actualizado con éxito',
            'data' => $client
        ];

        return response()->json($data, 200);
    }

    public function destroy($id)
    {
        $client = Client::find($id);

        if (!$client) {
            $data = [
                'status' => 404,
                'message' => 'No se encontró al cliente'
            ];
            return response()->json($data, 404);
        }

        $client->delete();

        return response()->noContent();
    }
}
