<?php

namespace App\Http\Controllers\Api;

use App\Models\Qoutas;
use App\Models\Socio;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\support\Facades\Validator;

class qoutasController extends Controller
{
    // metodo para listar todos elementos
    public function index(){
        $qoutas = Qoutas::with('socio')->get();
        if($qoutas->count()>0){
            $formattedQoutas = $qoutas->map(function($qouta) {
                return [
                    'id' => $qouta->id,
                    'socio_nome' => $qouta->nome_socio,
                    'valor_contribuido' => number_format($qouta->valor_contribuido, 2, '.', ''),
                    'data_pagamento' => $qouta->data_pagamento,
                    'status_pagamento' => $qouta->status_pagamento,
                    'created_at' => $qouta->created_at
                ];
            });

            return response()->json([
                'status' => 200,
                'data' => $formattedQoutas
            ], 200);
        }else{
            return response()->json([
                'status' => 404,
                'message' => "Sem Quotas Registadas"
            ], 404);
        }
    }

    // metodo para criar registro
    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'id_socio' => 'required|exists:socios,id',
            'data_pagamento'  => 'required|date',
            'valor_contribuido' => 'required|numeric',
            'status_pagamento' => 'required|in:Pago,Pendente,Cancelado'
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages()
            ], 422);
        }else{
            $socio = Socio::find($request->id_socio);
            if(!$socio) {
                return response()->json([
                    'status' => 404,
                    'message' => "Sócio não encontrado"
                ], 404);
            }

            $qoutas = Qoutas::create([
                'valor_contribuido' => $request->valor_contribuido,
                'data_pagamento' => $request->data_pagamento,
                'nome_socio' => $socio->nome_completo,
                'id_socio' => $request->id_socio,
                'status_pagamento' => $request->status_pagamento ?? 'Pago'
            ]);
                       
            if($qoutas){
                $aux = $socio->valor_quota_contribuido + $qoutas->valor_contribuido;
                $socio->update(['valor_quota_contribuido' => $aux]);
                $socio->save();
     
                return response()->json([
                    'status' => 200,
                    'message' => "Quota registrada com sucesso",
                    'data' => [
                        'id' => $qoutas->id,
                        'socio_nome' => $qoutas->nome_socio,
                        'valor_contribuido' => number_format($qoutas->valor_contribuido, 2, '.', ''),
                        'data_pagamento' => $qoutas->data_pagamento,
                        'status_pagamento' => $qoutas->status_pagamento,
                        'created_at' => $qoutas->created_at
                    ]
                ], 200);  
            }else{
                return response()->json([
                    'status' => 500,
                    'message' => "Opps, algo correu mal"
                ], 500);  
            }
        }
    }

    public function show($id){
        $qoutas = Qoutas::find($id);

        if($qoutas){
            return response()->json([
                'status' => 200,
                'data' => [
                    'id' => $qoutas->id,
                    'socio_nome' => $qoutas->nome_socio,
                    'valor_contribuido' => number_format($qoutas->valor_contribuido, 2, '.', ''),
                    'data_pagamento' => $qoutas->data_pagamento,
                    'status_pagamento' => $qoutas->status_pagamento,
                    'created_at' => $qoutas->created_at
                ]
            ], 200); 
        }else{
            return response()->json([
                'status' => 404,
                'message' => "Quota não encontrada!"
            ], 404); 
        }
    }

    public function edit($id){
        $qoutas = Qoutas::find($id);

        if($qoutas){
            return response()->json([
                'status' => 200,
                'data' => [
                    'id' => $qoutas->id,
                    'socio_nome' => $qoutas->nome_socio,
                    'valor_contribuido' => number_format($qoutas->valor_contribuido, 2, '.', ''),
                    'data_pagamento' => $qoutas->data_pagamento,
                    'status_pagamento' => $qoutas->status_pagamento,
                    'created_at' => $qoutas->created_at
                ]
            ], 200); 
        }else{
            return response()->json([
                'status' => 404,
                'message' => "Quota não encontrada!"
            ], 404); 
        }
    }

    public function update(Request $request, int $id){
        $validator = Validator::make($request->all(), [
            'id_socio' => 'required|exists:socios,id',
            'data_pagamento'  => 'required|date',
            'valor_contribuido' => 'required|numeric',
            'status_pagamento' => 'required|in:Pago,Pendente,Cancelado'
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages()
            ], 422);
        }else{
            $qoutas = Qoutas::find($id);
            if($qoutas){
                $socio = Socio::find($request->id_socio);
                if(!$socio) {
                    return response()->json([
                        'status' => 404,
                        'message' => "Sócio não encontrado"
                    ], 404);
                }

                $qoutas->update([
                    'valor_contribuido' => $request->valor_contribuido,
                    'data_pagamento' => $request->data_pagamento,
                    'nome_socio' => $socio->nome_completo,
                    'id_socio' => $request->id_socio,
                    'status_pagamento' => $request->status_pagamento
                ]);
            
                return response()->json([
                    'status' => 200,
                    'message' => "Quota atualizada com sucesso!",
                    'data' => [
                        'id' => $qoutas->id,
                        'socio_nome' => $qoutas->nome_socio,
                        'valor_contribuido' => number_format($qoutas->valor_contribuido, 2, '.', ''),
                        'data_pagamento' => $qoutas->data_pagamento,
                        'status_pagamento' => $qoutas->status_pagamento,
                        'created_at' => $qoutas->created_at
                    ]
                ], 200);  
            }else{
                return response()->json([
                    'status' => 404,
                    'message' => "Quota não encontrada!"
                ], 404);  
            }
        }
    }

    public function destroy($id){
        $qoutas = Qoutas::find($id);
        if($qoutas){
           $qoutas->delete();
           return response()->json([
            'status' => 200,
            'message' => "Quota deletada com sucesso"
         ], 200); 
        } else{
            return response()->json([
                'status' => 404,
                'message' => "Quota não encontrada!"
             ], 404);
        }
    }
}
