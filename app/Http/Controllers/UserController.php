<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public $validacion = [];

    public $mensajes = [
        'usuario.required' => 'Este campo es obligatorio',
        'usuario.min' => 'Debes ingresar al menos 4 carácteres',
    ];

    public $permisos = [
        'ADMINISTRADOR' => [
            'usuarios.index',
            'usuarios.create',
            'usuarios.edit',
            'usuarios.destroy',

            'tarifarios.index',
            'tarifarios.create',
            'tarifarios.edit',
            'tarifarios.destroy',

            'ingreso_salidas.index',
            'ingreso_salidas.create',
            'ingreso_salidas.edit',
            'ingreso_salidas.destroy',

            'reportes.espacios_disponibles',
            "reportes.ingresos_salidas"
        ],
        "OPERADOR" => [
            'tarifarios.index',
            'tarifarios.create',
            'tarifarios.edit',
            'tarifarios.destroy',

            'ingreso_salidas.index',
            'ingreso_salidas.create',
            'ingreso_salidas.edit',
            'ingreso_salidas.destroy',

            'reportes.espacios_disponibles',
            "reportes.ingresos_salidas"
        ],
    ];


    public function index(Request $request)
    {
        $usuarios = User::where('id', '!=', 1)->get();
        return response()->JSON(['usuarios' => $usuarios, 'total' => count($usuarios)], 200);
    }

    public function store(Request $request)
    {
        $this->validacion["usuario"] = "required|min:4|unique:users,usuario";
        $this->validacion["password"] = "required|min:6";
        $request->validate($this->validacion, $this->mensajes);
        DB::beginTransaction();
        $request["password"] = "123456";
        try {
            // crear el Usuario
            $nuevo_usuario = User::create(array_map('mb_strtoupper', $request->all()));
            $nuevo_usuario->password = Hash::make($request->password);
            $nuevo_usuario->save();
            DB::commit();
            return response()->JSON([
                'sw' => true,
                'usuario' => $nuevo_usuario,
                'msj' => 'El registro se realizó de forma correcta',
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->JSON([
                'sw' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(Request $request, User $usuario)
    {
        $this->validacion["usuario"] = "required|min:4|unique:users,usuario," . $usuario->id;
        if (isset($request->password) && trim($request->password) != "") {
            $this->validacion["password"] = "required|min:6";
        } else {
            unset($request["password"]);
        }
        $request->validate($this->validacion, $this->mensajes);
        DB::beginTransaction();
        try {
            $usuario->update(array_map('mb_strtoupper', $request->all()));
            if (isset($request->password) && trim($request->password) != "") {
                $usuario->password = Hash::make($request->password);
                $usuario->save();
            }
            DB::commit();
            return response()->JSON([
                'sw' => true,
                'usuario' => $usuario,
                'msj' => 'El registro se actualizó de forma correcta'
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->JSON([
                'sw' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function show(User $usuario)
    {
        return response()->JSON([
            'sw' => true,
            'usuario' => $usuario
        ], 200);
    }

    public function actualizaContrasenia(User $usuario, Request $request)
    {
        $request->validate([
            'password_actual' => ['required', function ($attribute, $value, $fail) use ($usuario, $request) {
                if (!\Hash::check($request->password_actual, $usuario->password)) {
                    return $fail(__('La contraseña no coincide con la actual.'));
                }
            }],
            'password' => 'required|confirmed|min:4',
            'password_confirmation' => 'required|min:4'
        ]);


        DB::beginTransaction();
        try {
            $usuario->password = Hash::make($request->password);
            $usuario->save();
            DB::commit();
            return response()->JSON([
                'sw' => true,
                'msj' => 'La contraseña se actualizó correctamente'
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->JSON([
                'sw' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy(User $usuario)
    {
        DB::beginTransaction();
        try {
            $antiguo = $usuario->foto;
            if ($antiguo != 'default.png') {
                \File::delete(public_path() . '/imgs/users/' . $antiguo);
            }
            $usuario->delete();
            DB::commit();
            return response()->JSON([
                'sw' => true,
                'msj' => 'El registro se eliminó correctamente'
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->JSON([
                'sw' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function getPermisos(User $usuario)
    {
        $tipo = $usuario->tipo;
        return response()->JSON($this->permisos[$tipo]);
    }

    public function getInfoBox()
    {
        $tipo = Auth::user()->tipo;
        $array_infos = [];
        if (in_array('usuarios.index', $this->permisos[$tipo])) {
            $array_infos[] = [
                'label' => 'Usuarios',
                'cantidad' => count(User::where('id', '!=', 1)->get()),
                'color' => 'bg-info',
                'icon' => 'fas fa-users',
            ];
        }
        return response()->JSON($array_infos);
    }

    public function userActual()
    {
        return response()->JSON(Auth::user());
    }

    public function getUsuario(User $usuario)
    {
        return response()->JSON($usuario);
    }

    public function getUsuarioTipo(Request $request)
    {
        $tipo = $request->tipo;
        $usuarios = [];
        if ($tipo != "todos") {
            if (is_array($tipo)) {
                $usuarios = User::where("id", "!=", 1)->whereIn("tipo", $tipo)->get();
            } else {
                $usuarios = User::where("id", "!=", 1)->where("tipo", $tipo)->get();
            }
        } else {
            $usuarios = User::where("id", "!=", 1)->get();
        }
        return response()->JSON($usuarios);
    }
}
