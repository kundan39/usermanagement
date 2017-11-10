<?php
use \Phalcon\Mvc\Controller;
use \Phalcon\Flash\Session;

class LoginController extends Controller
{

	public function indexAction()
	{
		//$this->session->set("username", "Michael");
		if (!$this->session->has("username")) 
		{
            return $this->response->redirect("login/");
		}
		else
		{
			return $this->response->redirect("/");
		}	
		$this->assets->addCss('css/style.css');
		$this->assets->addCss('css/bootstrap.min.css');
		$this->assets->addCss('css/bootstrap-responsive.min.css');
		$this->assets->addCss('css/matrix-login.css');
		$this->assets->addCss('font-awesome/css/font-awesome.css');
		$this->assets->addCss('http://fonts.googleapis.com/css?family=Open+Sans:400,700,800',false);

		$this->assets->addJs('js/jquery.min.js',true);
		$this->assets->addJs('js/matrix.login.js.js');
	}

	public function checkLoginAction()
	{
		//$this->session->set("username", "Michael");
		global $db;
		$collection = $db->usermanagement;
		$filter = array();
		$searchval = '';
		//searchval
		$posts = $this->request->getPost();
		$username = $posts['username'];
		$password = $posts['password'];
		
		$filter = array('$and'=>array( array("firstname"=>$username), array("password"=>$password)) );
		$results= $collection->find($filter);
		
		foreach ($results as $result) {
			 $username_session =  $result['firstname'];
		}

		if($username_session)
		{
			$this->session->set("username", $username);
			$this->response->redirect("/");
		}	
		else
		{
			$this->flashSession->success("Invalid username or password...!");			
			$this->response->redirect("login/");
		}	
	}

	public function logoutAction()
	{
		$this->session->destroy();
        return $this->response->redirect("login/");	
	}
}

?>