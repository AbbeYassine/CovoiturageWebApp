<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Metier\GestGroup ;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class FeedController extends Controller
{

		protected $gestGroup ;
		public function __construct(GestGroup $gestGroup){
    	      $this->gestGroup = $gestGroup;
    	}
    	public function index($groupId){
    		return $this->gestGroup->getFeeds($groupId);
    	}

    	public function store($groupId){
       		return $this->gestGroup->saveFeeds($groupId); 	
    	}
    	
}
