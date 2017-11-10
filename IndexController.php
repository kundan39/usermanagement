<?php
use \Phalcon\Mvc\Controller;
use \Phalcon\Flash\Session;

class IndexController extends Controller
{

	public function indexAction()
	{
		//$this->session->set("username", "Michael");
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
		$this->assets->addJs('js/jquery.uniform.js');
		$this->assets->addJs('js/select2.min.js');
		$this->assets->addJs('js/matrix.js');
		$this->assets->addJs('js/matrix.tables.js');

		global $db;
		$collection = $db->usermanagement;
		$filter = array();
		$searchval = '';
		//searchval
		$posts = $this->request->getPost();
		if(isset($posts['searchval']))
		{
			if($posts['searchval']!='')
			{
				$searchval = $posts['searchval'];
				$filter = array( '$or' => array( array("firstname"=>$searchval), array("lastname"=>$searchval), array("companyname"=>$searchval) ) );
				//$filter = ["firstname"=>$searchval];
			}
		}
		$options = ['sort'=>['register_date'=>-1]];
		$result = $collection->find($filter,$options);
		
		$this->view->users = $result;
		$this->view->searchval = $searchval;
	}
}

?>