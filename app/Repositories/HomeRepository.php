<?php 

namespace App\Repositories;
use App\{Service,User};
use Auth, DB, Exception, Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Filesystem\Filesystem;
class HomeRepository
{
    public function registrarUsuario($usuario)
    {
        try{
            $data = [
                "name" => $usuario->name,
                "email" => $usuario->email,
                "password" => Hash::make($usuario->password),
                "age" => $usuario->age,
                'status' => 1,
                "gender" => $usuario->gender,
                "rol" => 2,
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ];
           
            DB::table('users')->insert($data);
            
        }catch (Exception $e){
            Log::error($e->getMessage());
        }
    }

    public function getServices()
    {
        try{
            $services = Service::get();
            return $services;
        }catch (Exception $e){
            Log::error($e->getMessage());
        }
    }

    /**
	 * Obtiene la información del usuario que ha iniciado sesión
	 */
	public function getDataSessionUser()
	{
		try {
            return DB::table('users')
            ->where('id', Auth::user()->id)
            ->first();
		} catch (Exception $e) {
			Log::error($e->getMessage());
		}
    }
    
    public function addService($service)
    {
        try{
            $data = [
                "name" => $service->name,
                "status" => $service->status,
                "user_id" => $service->user_id,
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ];
           
            DB::table('services')->insert($data);
            
        }catch (Exception $e){
            Log::error($e->getMessage());
        }
    }

    public function updateService($service)
    {
        try{
            $data = [
                "name" => $service->name,
                "status" => $service->status,
                "user_id" => $service->user_id,
                "updated_at" => date('Y-m-d H:i:s'),
            ];
           
            DB::table('services')
            ->where('id', $service->id)
            ->update($data);
            
        }catch (Exception $e){
            Log::error($e->getMessage());
        }
    }

    public function deleteService($id)
    {
        try{
           
            DB::table('services')
            ->where('id', $id)
            ->delete();
            
        }catch (Exception $e){
            Log::error($e->getMessage());
        }
    }

    public function getUsers()
    {
        try{
            $users = DB::table('users')
            ->get();
    
            for ($i=0; $i <count($users) ; $i++) { 
                $users[$i]->services = DB::table('services')
                ->where('user_id',$users[$i]->id)
                ->get();
            }
            return $users;
        }catch (Exception $e){
            Log::error($e->getMessage());
        }
    }

    public function switchStatusUser($user)
    {
        try{
            $data = [
                "status" => $user->status,
            ];
           
            DB::table('users')
            ->where('id', $user->id)
            ->update($data);
            
        }catch (Exception $e){
            Log::error($e->getMessage());
        }
    }

    public function webServiceUsers()
    {
        try{
            $users = DB::table('users')
            ->select('id','name')
            ->get();
    
            for ($i=0; $i <count($users) ; $i++) { 
                $users[$i]->services = DB::table('services')
                ->select('id','name')
                ->where('user_id',$users[$i]->id)
                ->get();
            }
            return $users;
        }catch (Exception $e){
            Log::error($e->getMessage());
        }
    }
}