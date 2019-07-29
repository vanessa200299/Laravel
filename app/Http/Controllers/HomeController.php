<?php

namespace App\Http\Controllers;
use App\Http\Requests\{UsuarioRequest,LoginRequest,ServiceRequest};
use Illuminate\Http\Request;
use Auth, DB, Exception, Log;
use App\Repositories\{HomeRepository};
class HomeController extends Controller
{
    protected $homeRepository;
    public function __construct(HomeRepository $homeRepository)
    {
        $this->homeRepository = $homeRepository;
    }
    function index(Request $request)
    {
        $mesaje = $request->message;
        $data= array(
            'messages' => '""'
        );
        if ($mesaje) {
           $data['messages'] = json_encode(array($mesaje));
        }

        return view('welcome',['data'=>$data]);   
    }
    function registrarUsuario(UsuarioRequest $request)
    {
        try {
            DB::beginTransaction();
            $this->homeRepository->registrarUsuario($request);
            DB::commit();
            
            return response()->json([
                'status' => 'OK',
                'message' => 'usuario registrado correctamente'
            ], 200);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Error: | $e->getMessage() | File: $e->getFile() | Line: $e->getLine()");
            return response()->json([
                'status' => 'error',
                'message' => 'Error al registrar usuario'
            ], 500);
        }
    }

    function login(LoginRequest $request)
    {
        try{
            $login = Auth::attempt([
                'email' => $request->email, 
                'password' => $request->password
            ]);
	    	if ($login) {
			    return response()->json([
			    	'status' => 'OK',
			    	'message' => 'Usuario logueado'
 			    ], 200);
			} else {
				return response()->json([
					'status' => 'error',
					'message' => 'Credenciales no válidas'
				], 401);
			}
    	} catch(Exception $e) {
    		Log::error("Error | No se pudo autenticar usuario: {$e->getMessage()} | File: {$e->getFile()} | Line: {$e->getLine()} ");
    		return response()->json([
				'status' => 'error',
				'message' => 'Error inesperado'
			], 500);
    	}
    }

    function services()
    {
        $user = $this->homeRepository->getDataSessionUser();
        if ($user->rol==2) {
            $services = $this->homeRepository->getServices();

            $data = array(
                'user' => json_encode($user),
                'services' => json_encode($services)
            );

            return view('services',['data'=>$data]);
        }
    }
    function addService(ServiceRequest $request)
    {
        try {
            DB::beginTransaction();
            $this->homeRepository->addService($request);
            $services = $this->homeRepository->getServices();
            DB::commit();
            
            return response()->json([
                'status' => 'OK',
                'message' => 'servicio registrado correctamente',
                'services' => $services
            ], 200);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Error: | $e->getMessage() | File: $e->getFile() | Line: $e->getLine()");
            return response()->json([
                'status' => 'error',
                'message' => 'Error al registrar servicio'
            ], 500);
        }
    }

    function updateService(ServiceRequest $request)
    {
        try {
            DB::beginTransaction();
            $this->homeRepository->updateService($request);
            $services = $this->homeRepository->getServices();
            DB::commit();
            
            return response()->json([
                'status' => 'OK',
                'message' => 'servicio actualizado correctamente',
                'services' => $services
            ], 200);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Error: | $e->getMessage() | File: $e->getFile() | Line: $e->getLine()");
            return response()->json([
                'status' => 'error',
                'message' => 'Error al actualizar servicio'
            ], 500);
        }
    }

    function deleteService(Request $request)
    {
        try {
            DB::beginTransaction();
            $this->homeRepository->deleteService($request->id);
            $services = $this->homeRepository->getServices();
            DB::commit();
            
            return response()->json([
                'status' => 'OK',
                'message' => 'servicio borrado correctamente',
                'services' => $services
            ], 200);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Error: | $e->getMessage() | File: $e->getFile() | Line: $e->getLine()");
            return response()->json([
                'status' => 'error',
                'message' => 'Error al borrar servicio'
            ], 500);
        }
    }

    function redirect()
    {
        $user = $this->homeRepository->getDataSessionUser();

        if ($user->rol==2) {
            return redirect('/services');
        }if ($user->rol==2) {
            return redirect('/admin');
        } 
        
    }

    function admin()
    {
        $users = $this->homeRepository->getUsers();

        $data = array(
            'users' => json_encode($users)
        );

        return view('admin',['data'=>$data]);
    }

    function switchStatusUser(Request $request)
    {
        try {
            DB::beginTransaction();
            $this->homeRepository->switchStatusUser($request);
            DB::commit();
            
            return response()->json([
                'status' => 'OK',
                'message' => 'usuario actualizado correctamente',
            ], 200);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Error: | $e->getMessage() | File: $e->getFile() | Line: $e->getLine()");
            return response()->json([
                'status' => 'error',
                'message' => 'Error al actualizar usuario'
            ], 500);
        }
    }

    function webServiceUsers()
    {
        try {
            $users = $this->homeRepository->webServiceUsers();
            
            return response()->json([
                'status' => 'OK',
                'data' => array(
                    'users'=>$users
                ),
            ], 200);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Error: | $e->getMessage() | File: $e->getFile() | Line: $e->getLine()");
            return response()->json([
                'status' => 'error',
                'message' => 'Error al actualizar usuario'
            ], 500);
        }
    }
}
