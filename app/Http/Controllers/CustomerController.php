<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clientes = Customer::all();
        return view('welcome', compact('clientes'));
    }

    public function crear(Request $request)
    {
        $id = $request->input('id');
        // dd($request); // MAPEO
        $customer = Customer::updateOrCreate(
            ['id' => $id],
            [
                'name' => $request->input('nombre'),
                'last_name' => $request->input('apellido'),
                'email' => $request->input('email'),
                'phone' => $request->input('telefono'),
                'direction' => $request->input('direccion'),
                'city' => $request->input('ciudad'),
                'country' => $request->input('pais'),
                'zip_code' => $request->input('cp'),
                'date_register' => $request->input('fecha_registro'),
            ]
        );

        if ($customer) {
            $lastId = $customer->id;
            $lastName = $customer->last_name;
            $name = $customer->name;
            return response()->json(['error' => false, 'id_last' => $lastId, 'lastName' => $lastName, 'name' => $name]);
        }

    }

    public function editar(Request $request)
    {
        $id = $request->input('id');
        $customer = Customer::find($id);
        return response()->json($customer);
    }
}
