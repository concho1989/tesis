<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Likespos;
use App\User;
use App\Post;

class LikesposController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function like($post_id){
        //Recoger los datos del suario
        $user = \Auth::user();
        //Comprobamos si el like existe en la BD.
        $isset_like = Likespos::where('user_id', $user->id)
                            ->where('post_id', $post_id)
                            ->count();
                            //var_dump($isset_like);
                          //  dd($isset_like);
            
        if($isset_like == 0){
        $like = new Likespos();
        $like->user_id = $user->id;
        $like->post_id = (int) $post_id;
        //Guardar likes en BD
        $like->save();
        //var_dump($like); 
            return response()->json([
                'like' => $like
            ]);
           
        
        }else{
            return response()->json([
                'message' => 'El like ya existe'
            ]);
        }

    }



    public function dislike($post_id){
        //Recoger los datos del suario
        $user = \Auth::user();
        //Comprobamos si el like existe en la BD.
        $like = Likespos::where('user_id', $user->id)
                            ->where('post_id', $post_id)
                            ->first();
            
        if($like){
        //Eliminar likes en BD
        $like->delete();
            return response()->json([
                'like' => $like,
                'message' => 'Has dado Dislike'
            ]);
        //var_dump($like);
        //dd($like);
        }else{
            return response()->json([
                'message' => 'El like no existe'
            ]);
        }

    }
}
