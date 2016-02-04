<?php

namespace App\Metier ;
use App\Models\Admin;
use App\Models\User;
use App\Models\Groups;
use App\Models\Post;
use Facebook ;
use Illuminate\Support\Facades\DB;
class GestGroup 
{
		public function getFromFacebook($url){
			 $access_token = $this->getAccessToken();
       			 
       	     $fb = $this->config_facebook();
			
			
       	     // Sets the default fallback access token so we don't have to pass it to each request
       		 $fb->setDefaultAccessToken($access_token);

			 try {
       		       // Returns a `Facebook\FacebookResponse` object
       			   $response = $fb->get($url);

       			 } catch(Facebook\Exceptions\FacebookResponseException $e) {
       			   return "Erreur Graph";
       			   
       			 } catch(Facebook\Exceptions\FacebookSDKException $e) {
       			   return "Erreur Facebook SDK";
       			 }
       			 return $response;

		}
		public function config_facebook(){
			return new Facebook\Facebook([
  			'app_id' => '1686368228268658',
  			'app_secret' => 'ad92ce6f23ec518b5effa727a64da22e',
  			'default_graph_version' => 'v2.5',
			]);
		}

		public function saveToken($access_token){

			Admin::truncate();
			
			$admin = new Admin ;
			$admin->access_token = $access_token ;
			$admin->save();
				
		}
		public function getAccessToken(){
			$admin = Admin::all()->first();

			return $admin->access_token ;
		}
		public function saveFeeds($groupId){
       		 
       		$id_Group = $this->getIdGroup($groupId);
       		$feeds = $this->getFeeds($groupId);
       		//Verif number Posts ;
       		$number_Feeds = $this->getNumberFeeds();
       		$feedSaved = array();
       		for($i=0;$i<count($feeds)-$number_Feeds;$i++){
       			$feedSaved[$i] = $feeds[$i]; 	
       			$this->saveFeed($feeds[$i],$id_Group);
       			
       		}
       			
       		return $feedSaved;
       			
		}
		
		public function saveFeed($post,$id_Group){
			/**** User Identificator ****/
			 $response =$this->getFromFacebook('/'.$post['id'].'?fields=from');
			 $user = $response->getGraphNode();
       			
       		 $id_User =$this->saveUser($user['from']);
       		 $postt= new Post ;
       		 if(isset($post['message'])){
       		 	$postt->message = $post['message'];
       		}else {
       			$postt->message = "Admin Update";
       		}
       			$postt->identifiant = $post['id'];
       		 	$postt->id_Groups=$id_Group;
       		 	$postt->id_User=$id_User;
       		 	$postt->save();

		}
		public function getNumberFeeds(){
			return count(Post::all());
		}
		public function saveUser($user){
			$u = User::where('identifiant','=',$user['id'])->first();

			if(!$u){
				$u = new User ;
				$u->identifiant = $user['id'];
				$u->prenom= substr($user['name'],0,strlen($user['name'])-strpos($user['name'],' '));
				$u->nom = substr($user['name'],strlen($user['name'])-strpos($user['name'],' ')+1);
				$u->save();
			}

			return $u->id_User ;

			
		}
		
		public function getUserInfo(){
			$response =$this->getFromFacebook('/me');

			return $response->getGraphNode();
		}

		public function getGroups(){
			$response =$this->getFromFacebook('/me/groups');

			if(is_string($response)){
				return response()->json(['error' => $response]);
			}else {
				return $response->getGraphEdge();
			}
		}

		public function getGroup($groupId){
			$response =$this->getFromFacebook('/'.$groupId);

			if(is_string($response)){
				return response()->json(['error' => $response]);
			}else {
				return $response->getGraphNode();
			}
			 
		}

		public function getFeeds($groupId){
			$response =$this->getFromFacebook('/'.$groupId.'/Feed');
			if(is_string($response)){
				return response()->json(['error' => $response]);
			}else {
				return $response->getGraphEdge();
			}
		}
		public function getIdGroup($groupId){
			$group = Groups::where('identifiant','=',$groupId)->first();

			if(!$group){
				$responseGroup = $this->getGroup($groupId);
				$group = new Groups ;
				$group->identifiant = $groupId;
				$group->nom = $responseGroup['name']; 
				$group->save();
			}
			 
			return $group->id_Groups;
		}
		public function getAllPost(){
			return Post::where('created_at','>=',DB::raw('DATE_SUB(NOW(), INTERVAL 1 DAY)'))
				->get();
		}
		public function storeUser($Arrays){
			$user = User::where('login','=',$Arrays['login'])
				->get();

			if(count($user)==0){
				$user = new User ;

				$user->nom = $Arrays['nom'];
				$user->prenom= $Arrays['prenom'];
				$user->login = $Arrays['login'];
				$user->password = bcrypt($Arrays['password']);

				$user->save();

				return response()->json([
					'success' => 'User add' ,
					'user' => $user ]);
			}else {
				return response()->json(['success' => 'User exist']);
			}
		}

}