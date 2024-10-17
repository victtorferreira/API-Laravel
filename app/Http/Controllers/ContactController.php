<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;



class ContactController extends Controller
{

    public function index(Request $request)
    {
        // Verifica se o usuário está autenticado
        if (!$request->user()) {
            return response()->json(['error' => 'Usuário não autenticado'], 401);
        }

        // Aqui você pode buscar os contatos do usuário autenticado
        $userId = $request->user()->id;
        $contacts = Contact::where('user_id', $userId)->get();

        return response()->json($contacts);
    }

    public function showContact(Request $request, $id) {
        $contact = Contact::find($id);
        
        if (!$contact) {
            return response()->json(['error' => 'Contato não encontrado'], 404);
        }
        
        return response()->json($contact);
    }
    


    public function addContact(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'phone' => 'required|string|max:20',
            ]);

            
            $userId = auth()->id();
            if (!$userId) {
                return response()->json([
                    'message' => 'Usuário não autenticado',
                ], 401);
            }

            $contacts = new Contact();
            $contacts->name = $request->name;
            $contacts->email = $request->email;
            $contacts->phone = $request->phone;
            $contacts->user_id = $userId; 

            if ($contacts->save()) {
                return response()->json([
                    'message' => 'Contato adicionado com sucesso',
                    'contact' => $contacts
                ], 201);
            } else {
                return response()->json([
                    'message' => 'Falha ao adicionar contato'
                ], 500);
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Erro na validação',
                'errors' => $e->errors(),
            ], 422);
        }
    }


    public function editContact(Request $request, $id)
    {
        $validadeData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
        ]);

        $contact = Contact::find($id);

        if(!$contact) {
            return response()->json([
                'error' => 'Contato nao encontrado'
            ], 404);
        }

        $contact->name = $validadeData['name'];
        $contact->email = $validadeData['email'];
        $contact->phone = $validadeData['phone'];
        $contact->save();

        return response()->json($contact, 200);
    }
    
    public function deleteContact(Request $request, $id)
    {
        $contacts = Contact::find($id);
        $contacts->delete();
    }
}
