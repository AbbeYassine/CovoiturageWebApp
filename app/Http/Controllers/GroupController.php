<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Metier\GestGroup ;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class GroupController extends Controller
{
	protected $gestGroup ;
	public function __construct(GestGroup $gestGroup){
          $this->gestGroup = $gestGroup;
    }	
    public function index($groupId=null){
    	if($groupId==null){
    		return $this->gestGroup->getGroups();
    	}else {
    		return $this->gestGroup->getGroup($groupId);
    	}
    }

}
