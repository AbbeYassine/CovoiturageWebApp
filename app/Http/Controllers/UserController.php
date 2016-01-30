<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Metier\GestGroup ;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
	protected $gestGroup ;
	public function __construct(GestGroup $gestGroup){
          $this->gestGroup = $gestGroup;
    }	
    public function index(){
    	//Retrive User Information
    	return $this->gestGroup->getUserInfo();
    }

   
}
