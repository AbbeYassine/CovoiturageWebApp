<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Metier\GestGroup ;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Facebook\FacebookRequest;

class LoginController extends Controller
{


    public function __construct(GestGroup $gestGroup){
          $this->gestGroup = $gestGroup;
    }	

    public function index(){
      session_start();
      $fb = $this->gestGroup->config_facebook();

      $helper = $fb->getRedirectLoginHelper();
  
      $loginUrl = $helper->getLoginUrl('http://localhost/login/callback',array('scope' => 'user_managed_groups','user_posts'));

      echo "<a href= ".$loginUrl . ">Get Token </a>";
     
    }
    
    
    

  //En sauvgarde l'access de l'admin dans la table Admin
	public function callback(){
      		session_start();
          $fb = $this->gestGroup->config_facebook();
      
      		$helper = $fb->getRedirectLoginHelper();
          try {
              $accessToken = $helper->getAccessToken();
          }catch(Facebook\Exceptions\FacebookResponseException $e) {
            return response()->json(['error' => 'Graph']);
          } catch(Facebook\Exceptions\FacebookSDKException $e) {
            return response()->json(['error' => 'Facebook SDK']);
          }
      
          if (isset($accessToken)) {
              $this->gestGroup->saveToken($accessToken); 
               return response()->json(['success' => 'true']);
          }
    }
}
