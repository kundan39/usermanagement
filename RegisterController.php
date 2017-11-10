<?php
use \Phalcon\Mvc\Controller;
use \Phalcon\Flash\Session;

class RegisterController extends Controller
{

	public function indexAction()
	{
		
		if (!$this->session->has("username")) 
		{
            return $this->response->redirect("login/");
		}

		$this->assets->addCss('css/style.css');
		$this->assets->addCss('css/bootstrap.min.css');
		$this->assets->addCss('css/bootstrap-responsive.min.css');
		$this->assets->addCss('css/uniform.css');
		$this->assets->addCss('css/select2.css');
		$this->assets->addCss('css/matrix-style.css');
		$this->assets->addCss('css/matrix-media.css');
		$this->assets->addCss('font-awesome/css/font-awesome.css');
		$this->assets->addCss('http://fonts.googleapis.com/css?family=Open+Sans:400,700,800',false);

		$this->assets->addJs('js/jquery.min.js',true);
		$this->assets->addJs('js/jquery.ui.custom.js');
		$this->assets->addJs('js/bootstrap.min.js');
		$this->assets->addJs('js/bootstrap-colorpicker.js');
		$this->assets->addJs('js/bootstrap-datepicker.js');
		$this->assets->addJs('js/jquery.toggle.buttons.js');
		$this->assets->addJs('js/masked.js');
		$this->assets->addJs('js/jquery.uniform.js');
		$this->assets->addJs('js/select2.min.js');
		$this->assets->addJs('js/matrix.js');
		$this->assets->addJs('js/matrix.form_common.js');
		$this->assets->addJs('js/wysihtml5-0.3.0.js');
		$this->assets->addJs('js/jquery.peity.min.js');
		$this->assets->addJs('js/bootstrap-wysihtml5.js');


	}

	public function adduserAction()
	{
		
		if (!$this->session->has("username")) 
		{
            return $this->response->redirect("login/");
		}

		$posts = $this->request->getPost();
		
		global $db;
		$collection = $db->usermanagement;

		//$client = new MongoDB\Client("mongodb://localhost:27017");

		//$usermodel = new Usermanagement();
		

		$firstname = $posts['firstname'];
	    $lastname = $posts['lastname'];
	    $password = $posts['password'];
	    $description = $posts['description'];
	    $message = $posts['message'];
	    $companyname = $posts['companyname'];
	    $register_date = date("Y-m-d H:i:s");

	    

		$result = $collection->insertOne( [ 'firstname' => $firstname, 'lastname' => $lastname, 'password' => $password, 'companyname' => $companyname, 'description' => $description, 'message' => $message, 'register_date' => $register_date ] );

		//echo "Inserted with Object ID '{$result->getInsertedId()}'";

		if($result->getInsertedId())
		{
			$this->flashSession->success("User has been added successfully!");
			return $this->response->redirect("/");
		}
		else
		{
			$this->flashSession->error("Unable to add user");
			return $this->response->redirect("/register");
		}

	    //$usermodel->save();

	    // if ($usermodel->save() == false) {
	    //     echo "Umh, We can't store robots right now: \n";
	    //     foreach ($usermodel->getMessages() as $message) {
	    //         echo $message, "\n";
	    //     }
	    // } else {
	    //     echo "Great, a new robot was saved successfully!";
	    // }

		//die;
	}

	public function editUserAction()
	{
		if (!$this->session->has("username")) 
		{
            return $this->response->redirect("login/");
		}

		$this->assets->addCss('css/style.css');
		$this->assets->addCss('css/bootstrap.min.css');
		$this->assets->addCss('css/bootstrap-responsive.min.css');
		$this->assets->addCss('css/uniform.css');
		$this->assets->addCss('css/select2.css');
		$this->assets->addCss('css/matrix-style.css');
		$this->assets->addCss('css/matrix-media.css');
		$this->assets->addCss('font-awesome/css/font-awesome.css');
		$this->assets->addCss('http://fonts.googleapis.com/css?family=Open+Sans:400,700,800',false);

		$this->assets->addJs('js/jquery.min.js',true);
		$this->assets->addJs('js/jquery.ui.custom.js');
		$this->assets->addJs('js/bootstrap.min.js');
		$this->assets->addJs('js/bootstrap-colorpicker.js');
		$this->assets->addJs('js/bootstrap-datepicker.js');
		$this->assets->addJs('js/jquery.toggle.buttons.js');
		$this->assets->addJs('js/masked.js');
		$this->assets->addJs('js/jquery.uniform.js');
		$this->assets->addJs('js/select2.min.js');
		$this->assets->addJs('js/matrix.js');
		$this->assets->addJs('js/matrix.form_common.js');
		$this->assets->addJs('js/wysihtml5-0.3.0.js');
		$this->assets->addJs('js/jquery.peity.min.js');
		$this->assets->addJs('js/bootstrap-wysihtml5.js');

		global $db;
		$collection = $db->usermanagement;
		$searchval = $this->request->get('ref');
		$filter = array("_id"=>new MongoDB\BSON\ObjectID($searchval));
		$result = $collection->find($filter);
		$this->view->users = $result;
	}


	public function updateUserAction()
	{
		if (!$this->session->has("username")) 
		{
            return $this->response->redirect("login/");
		}

		$posts = $this->request->getPost();
		
		global $db;
		$collection = $db->usermanagement;

		//$client = new MongoDB\Client("mongodb://localhost:27017");

		//$usermodel = new Usermanagement();
		
		$firstname = $posts['firstname'];
	    $lastname = $posts['lastname'];
	    $password = $posts['password'];
	    $description = $posts['description'];
	    $message = $posts['message'];
	    $companyname = $posts['companyname'];
	    
	    $data = array(
        		'$set' => array(
        			"firstname" => $firstname,
        			"lastname" => $lastname,
        			"password" => $password,
        			"companyname" => $firstname,
        			"description" => $description,
        			"message" => $message
        			)
    		);


	    global $db;
		$collection = $db->usermanagement;
		$searchval = $this->request->get('ref');
		
		$filter = array("_id"=>new MongoDB\BSON\ObjectID($searchval));
	    //$result = $collection->insertOne( [ 'firstname' => $firstname, 'lastname' => $lastname, 'password' => $password, 'companyname' => $companyname, 'description' => $description, 'message' => $message, 'register_date' => $register_date ] );
	    $result = $collection->updateOne($filter,$data,array("upsert" => true));

	    if($result)
		{
			$this->flashSession->success("User has been updated successfully!");
			return $this->response->redirect("/");
		}
		else
		{
			$this->flashSession->error("Unable to update user");
			return $this->response->redirect("/");
		}

	}

	public function deleteUserAction()
	{
		if (!$this->session->has("username")) 
		{
            return $this->response->redirect("login/");
		}
		
		$posts = $this->request->getPost();
		
		global $db;
		$collection = $db->usermanagement;

		//$client = new MongoDB\Client("mongodb://localhost:27017");

		//$usermodel = new Usermanagement();
		global $db;
		$collection = $db->usermanagement;
		$searchval = $this->request->get('ref');
		
		$filter = array("_id"=>new MongoDB\BSON\ObjectID($searchval));
	    $result = $collection->deleteOne($filter);

	    if($result)
		{
			$this->flashSession->success("User has been deleted successfully!");
			return $this->response->redirect("/");
		}
		else
		{
			$this->flashSession->error("Unable to delete user");
			return $this->response->redirect("/");
		}
	}


}

?>