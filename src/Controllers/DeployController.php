<?php

namespace Ertomy\Gitlab\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Ertomy\Gitlab\Models\Deploy;
use Ertomy\Gitlab\Requests\UpdateRequest;

class DeployController extends Controller
{

    public function index()
    {
        return view('gitdeploy::index');
    }

    /* devuelve los ficheros pendientes de subir */
    public function updates (Request $request){

        $deploy = new Deploy();        
        if($deploy->count() == 0){ 
            // no se ha hecho ningun despliegue aun , se mostraran todos los ficheros subidos al repositorio
            $files = $deploy->getAllFiles();
        }else{
            // solo sacamos los ficheros desde el ultimo commit desplegado           
            $last_commit = $deploy->getLastCommit();
            $files = $deploy->getFilesFromCommit($deploy->latest()->first()->commit, $last_commit); 
        }

        if($request->ajax()){
            return response()->json($files);
        }else{
            return view('gitdeploy::updates', compact('files'));
        }        
    }

    public function update (UpdateRequest $request){
        if($request->status == 'delete'){
            if(file_exists(base_path($request->path))){
                unlink(base_path($request->path));
            }
        }else{
            $deploy = new Deploy();  
            $deploy->downloadFile($request->path);
        }
        return response()->json(true);       
    }

    public function updateCommit(){
        $deploy = new Deploy();  
        $deploy->user_id = auth()->user()->id;
        $deploy->commit = $deploy->getLastCommit();
        $deploy->save(); 
    }




    public function logs(){

        $deploys = Deploy::with('user')->orderBy('created_at', 'desc')->get();

        return view('gitdeploy::logs', compact('deploys'));

    }

   



    




}