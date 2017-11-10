<?php  

class SessionController extends \Phalcon\Mvc\Controller { 
   public function indexAction() { 
      //Define a session variable 
      $this->session->set("username", "Omkar"); 
      
      //Check if the variable is defined 
      if ($this->session->has("username")) { 
         //Retrieve its value 
         $name = $this->session->get("username"); 
         echo($name); 
      } 
   } 
} 