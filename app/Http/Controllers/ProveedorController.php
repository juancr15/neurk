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
            $responseError = $this->validarDatosProveedor($request);
            if (count($responseError) > 0) {
                return response()->json([
                    'message' => 'Error al crear proveedor',
                    'error' => $responseError
                ], 400);
            }

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

    public function validarDatosProveedor($datos) {
        $responseError = [];
        if (!isset($datos->nit) or strlen($datos->nit) == 0 or strlen($datos->nit) > 15 or !is_numeric($datos->nit)) {
            $responseError['nit'] = 'El nit es obligatorio, debe tener máximo 15 caracteres y debe ser numérico.';
        }
        
        if (!isset($datos->nombre) or strlen($datos->nombre) == 0 or strlen($datos->nombre) > 100) {
            $responseError['nombre'] = 'El nombre es obligatorio y debe tener máximo 100 caracteres.';
        }

        if (!isset($datos->razon_social) or strlen($datos->razon_social) == 0 or strlen($datos->razon_social) > 100) {
            $responseError['razon_social'] = 'La razón social es obligatoria y debe tener máximo 100 caracteres.';
        }

        if (!isset($datos->categoria) or strlen($datos->categoria) == 0 or strlen($datos->categoria) > 20) {
            $responseError['categoria'] = 'La categoría es obligatoria y debe tener máximo 20 caracteres.';
        }

        if (!isset($datos->nombre_contacto) or strlen($datos->nombre_contacto) == 0 or strlen($datos->nombre_contacto) > 100) {
            $responseError['nombre_contacto'] = 'El nombre de contacto es obligatorio y debe tener máximo 100 caracteres.';
        }

        if (!isset($datos->telefono_contacto) or strlen($datos->telefono_contacto) == 0 or strlen($datos->telefono_contacto) > 15 or !is_numeric($datos->telefono_contacto)) {
            $responseError['telefono_contacto'] = 'El teléfono de contacto es obligatorio, debe tener máximo 15 caracteres y debe ser numérico.';
        }
        return $responseError;
    }

    public function actualizar(Request $request, $id) {
        try {
            $proveedor = Proveedor::find($id);
            if (!$proveedor) {
                return response()->json([
                    'message' => 'Proveedor no encontrado'
                ], 404);
            }

            $validacion = $this->validarDatosProveedorActualiza($request);
            if ($validacion['error']) {
                return response()->json([
                    'message' => 'Error al actualizar proveedor',
                    'error' => $validacion['response']
                ], 400);
            }

            Proveedor::where('nit' , $id)->update(
                $validacion['response']
            );

            $proveedor = Proveedor::find($id);
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

    public function validarDatosProveedorActualiza($datos) {
        $datosActualiza = [];
        $error = false;

        if (isset($datos->nombre)) {
            if (strlen($datos->nombre) > 0 and strlen($datos->nombre) < 100) {
                $datosActualiza['nombre'] = $datos->nombre;
            } else {
                $responseError['nombre'] = 'El nombre es obligatorio y debe tener máximo 100 caracteres.';
                $error = true;
            }
        } 

        if (isset($datos->razon_social)) {
            if (strlen($datos->razon_social) > 0 and strlen($datos->razon_social) < 100) {
                $datosActualiza['razon_social'] = $datos->razon_social;
            } else {
                $responseError['razon_social'] = 'La razón social es obligatoria y debe tener máximo 100 caracteres.';
                $error = true;
            }
        }
        
        if (isset($datos->categoria)) {
            if (strlen($datos->categoria) > 0 and strlen($datos->categoria) < 20) {
                $datosActualiza['categoria'] = $datos->categoria;
            } else {
                $responseError['categoria'] = 'La categoría es obligatoria y debe tener máximo 20 caracteres.';
                $error = true;
            }
        }
        
        if (isset($datos->nombre_contacto)) {
            if (strlen($datos->nombre_contacto) > 0 and strlen($datos->nombre_contacto) < 100) {
                $datosActualiza['nombre_contacto'] = $datos->nombre_contacto;
            } else {
                $responseError['nombre_contacto'] = 'El nombre de contacto es obligatorio y debe tener máximo 100 caracteres.';
                $error = true;
            }
        }
        
        if (isset($datos->telefono_contacto)) {
            if (strlen($datos->telefono_contacto) > 0 and strlen($datos->telefono_contacto) < 15 and is_numeric($datos->telefono_contacto)) {
                $datosActualiza['telefono_contacto'] = $datos->telefono_contacto;
            } else {
                $responseError['telefono_contacto'] = 'El teléfono de contacto es obligatorio, debe tener máximo 15 caracteres y debe ser numérico.';
                $error = true;
            }
        }
        

        if ($error) {
            return [
                'error' => true,
                'response' => $responseError
            ];
        } else {
            return [
                'error' => false,
                'response' => $datosActualiza
            ];
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
