<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\Proveedor;

class ProveedorController extends Controller
{
    public function listar($id = null) {
        try {
            if ($id) {
                $respuesta = Proveedor::find($id);
                if ($respuesta)
                    return response()->json($respuesta, 200);
                else
                    return response()->json([
                        'message' => 'Proveedor no encontrado'
                    ], 404);
            } else
                return response()->json(Proveedor::all(), 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Error al obtener proveedores',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function insertar(Request $request) {
        try {
            $proveedor = new Proveedor();
            $proveedor->nit = $request->nit;
            $proveedor->nombre = $request->nombre;
            $proveedor->razon_social = $request->razon_social;
            $proveedor->categoria = $request->categoria;
            $proveedor->nombre_contacto = $request->nombre_contacto;
            $proveedor->telefono_contacto = $request->telefono_contacto;
            $proveedor->save();
            return response()->json([
                'message' => 'Proveedor creado correctamente',
                'proveedor' => $proveedor
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Error al crear proveedor',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function actualizar(Request $request, $id) {
        try {
            $proveedor = Proveedor::find($id);
            $proveedor->nombre = $request->nombre;
            $proveedor->razon_social = $request->razon_social;
            $proveedor->categoria = $request->categoria;
            $proveedor->nombre_contacto = $request->nombre_contacto;
            $proveedor->telefono_contacto = $request->telefono_contacto;
            Proveedor::where('nit' , $id)->update(
                [
                    'nombre' => $proveedor->nombre,
                    'razon_social' => $proveedor->razon_social,
                    'categoria' => $proveedor->categoria,
                    'nombre_contacto' => $proveedor->nombre_contacto,
                    'telefono_contacto' => $proveedor->telefono_contacto
                ]
            );
            return response()->json([
                'message' => 'Proveedor actualizado correctamente',
                'proveedor' => $proveedor
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Error al actualizar proveedor',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function eliminar($id) {
        try {
            $proveedor = Proveedor::find($id);
            $proveedor->delete();
            return response()->json([
                'message' => 'Proveedor eliminado correctamente',
                'proveedor' => $proveedor
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Error al eliminar proveedor',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
