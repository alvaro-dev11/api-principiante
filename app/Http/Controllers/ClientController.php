<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Client $client)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {
        //
    }
}
