<?php

namespace App\Http\Controllers\Api;

use App\Models\Socio;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\support\Facades\Validator;

class sociosController extends Controller
{
    // metodo para listar todos elementos
    public function index(){

        $socios = Socio::all();
        if($socios->count()>0){
            return response()->json([
               'status' => 200,
               'socios' => $socios
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
            'nome_completo' => 'required|max:191',
            'endereco'  => 'required|max:220',
            'genero'  => 'required|max:9',
            'data_nasciemnto'  => 'required',
            'telefone' => 'required|digits:9',
            'telefone_opcional' => 'required|digits:9',
            'email' => 'required|email|max:191',
            'nacionalidade' => 'required|max:191',
            'tipo_documento_de_identificacao'  => 'required',
            'documento_de_identificacao' => 'required',
            'categoria_socio' => 'required|max:30',
            'valor_quota_anual' => 'required',
            'valor_quota_contribuido',
            'estado_socio',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages()
            ], 422);
        }else{
             $socio = Socio::create([
                'nome_completo' => $request->nome_completo,
                'endereco'=> $request->endereco,
                'genero' => $request->genero,
                'data_nasciemnto' => $request->data_nasciemnto,
                'telefone' => $request->telefone,
                'telefone_opcional' => $request->telefone_opcional,
                'email' => $request->email,
                'nacionalidade' => $request->nacionalidade,
                'tipo_documento_de_identificacao' => $request->tipo_documento_de_identificacao,
                'documento_de_identificacao' => $request->documento_de_identificacao,
                'categoria_socio' => $request->categoria_socio,
                'valor_quota_anual' => $request->valor_quota_anual,
                'valor_quota_contribuido' => $request->valor_quota_contribuido,
                'estado_socio' => $request->estado_socio
             ]);

             if($socio){
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
        $socio = Socio::find($id);

        if($socio){
            return response()->json([
                'status' => 200,
                'socio' => $socio
             ], 200); 
        }else{
            return response()->json([
                'status' => 404,
                'message' => "Opps, socio nao encontrado!"
             ], 404); 
        }
    }

    public function edit($id){
        $socio = Socio::find($id);

        if($socio){
            return response()->json([
                'status' => 200,
                'socio' => $socio
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
            'nome_completo' => 'required|max:191',
            'endereco'  => 'required|max:220',
            'genero'  => 'required|max:9',
            'data_nasciemnto'  => 'required',
            'telefone' => 'required|digits:9',
            'telefone_opcional' => 'required|digits:9',
            'email' => 'required|email|max:191',
            'nacionalidade' => 'required|max:191',
            'tipo_documento_de_identificacao'  => 'required',
            'documento_de_identificacao' => 'required',
            'categoria_socio' => 'required|max:30',
            'valor_quota_anual' => 'required',
            'valor_quota_contribuido',
            'estado_socio'
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages()
            ], 422);
        }else{
             $socio = Socio::find($id);
             $socio->update([
                'nome_completo' => $request->nome_completo,
                'endereco'=> $request->endereco,
                'genero' => $request->genero,
                'data_nasciemnto' => $request->data_nasciemnto,
                'telefone' => $request->telefone,
                'telefone_opcional' => $request->telefone_opcional,
                'email' => $request->email,
                'nacionalidade' => $request->nacionalidade,
                'tipo_documento_de_identificacao' => $request->tipo_documento_de_identificacao,
                'documento_de_identificacao' => $request->documento_de_identificacao,
                'categoria_socio' => $request->categoria_socio,
                'valor_quota_anual' => $request->valor_quota_anual,
                'valor_quota_contribuido' => $request->valor_quota_contribuido,
                'estado_socio' => $request->estado_socio
             ]);

             if($socio){
                return response()->json([
                   'status' => 200,
                   'message' => "Socio Actualizado com sucesso"
                ], 200);  
             }else{
                return response()->json([
                    'status' => 404,
                    'message' => "Opps, Registo nao encontrado!"
                 ], 500);  
             }
        }
    }

    public function destroy($id){
        $socio = Socio::find($id);
        if($socio){
           $socio->delete();
           return response()->json([
            'status' => 200,
            'message' => "Socio deletado com sucesso"
         ], 200); 
        } else{
            return response()->json([
                'status' => 404,
                'message' => "Opps, Registo nao encontrado!"
             ], 500);
        }
    }
}
