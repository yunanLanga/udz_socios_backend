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

            $qoutas = Qoutas::all();
            if($qoutas->count()>0){
                return response()->json([
                   'status' => 200,
                   'qoutas' => $qoutas
                ], 200);
            }else{
                return response()->json([
                    'status' => 404,
                    'message' => "Sem Socios Registados"
                 ], 404);
            }
        }

        // metodo para criar reegisto
    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'nome_socio',
            'data_pagamento'  => 'required',
            'id_socio' => 'required|max:30',
            'valor_contribuido' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages()
            ], 422);
        }else{
             $buscar_nome = Socio::find($request->id_socio);
             $nome = $buscar_nome->nome_completo;
             $qoutas = Qoutas::create([
                'valor_contribuido' =>$request->valor_contribuido,
                'data_pagamento' =>$request->data_pagamento,
                'nome_socio'=> $nome,
                'id_socio' => $request->id_socio,
             ]);
                       
           
             if($qoutas){
                $socio = Socio::find($request->id_socio);
                $aux = $socio->valor_quota_contribuido + $qoutas->valor_contribuido;
                $socio->update(['valor_quota_contribuido' => $aux]);
                $socio->save();
     
                return response()->json([
                   'status' => 200,
                   'message' => "Socio criado com sucesso"
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
                'qoutas' => $qoutas
             ], 200); 
        }else{
            return response()->json([
                'status' => 404,
                'message' => "Opps, socio nao encontrado!"
             ], 404); 
        }
    }

    public function edit($id){
        $qoutas = Qoutas::find($id);

        if($qoutas){
            return response()->json([
                'status' => 200,
                'qoutas' => $qoutas
             ], 200); 
        }else{
            return response()->json([
                'status' => 404,
                'message' => "Opps, socio nao encontrado!"
             ], 404); 
        }
    }


    public function update(Request $request, int $id){
        $validator = Validator::make($request->all(), [
            'nome_socio' => 'max:191',
            'data_pagamento'  => 'required',
            'id_socio' => 'required|max:30',
            'valor_contribuido' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages()
            ], 422);
        }else{
             $qoutas = qoutas::find($id);
             $qoutas->update([
                'valor_contribuido' =>$request->valor_contribuido,
                'data_pagamento' =>$request->data_pagamento,
                'nome_socio'=> $request->nome_socio,
                'id_socio' => $request->id_socio,
             ]);
            
            
             if($qoutas){
                return response()->json([
                   'status' => 200,
                   'message' => "Pagamento de qouta Actualizado com sucesso!"
                ], 200);  
             }else{
                return response()->json([
                    'status' => 404,
                    'message' => "Opps, Pagamento de qouta nao encontrado!"
                 ], 500);  
             }
        }
    }

    public function destroy($id){
        $qoutas = Qoutas::find($id);
        if($qoutas){
           $qoutas->delete();
           return response()->json([
            'status' => 200,
            'message' => "pagamento de qouta deletado com sucesso"
         ], 200); 
        } else{
            return response()->json([
                'status' => 404,
                'message' => "Opps, Registo nao encontrado!"
             ], 500);
        }
    }

}
