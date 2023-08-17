<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class TestController extends Controller
{
    public function testOrm(){
        $posts = User::all();
        foreach($posts as $post){
             echo "<h2>".$post->user_login."</h1>";
             echo "<hr>";
         }
         
        
     }
}
