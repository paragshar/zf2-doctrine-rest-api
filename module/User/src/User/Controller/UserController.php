<?php
namespace User\Controller;

use User\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

class UserController extends AbstractRestfulJsonController{

    protected $em;

    public function getEntityManager(){
        if (null === $this->em) {
            $this->em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
        }
        return $this->em;
    }

    public function indexAction(){
        $users = $this->getEntityManager()->getRepository('User\Entity\User')->findAll();
        
        $users = array_map(function($user){
            return $user->toArray();
        }, $users);
        return new JsonModel($users);
    }
	
    public function getList(){   
        // Action used for GET requests without resource Id
        $users = $this->getEntityManager()->getRepository('User\Entity\User')->findAll();
        $users = array_map(function($user){
            return $user->toArray();
        }, $users);
        return new JsonModel($users);
    }

    public function get($id){   
        // Action used for GET requests with resource Id
        $user = $this->getEntityManager()->getRepository('User\Entity\User')->find($id);
        return new JsonModel(
    		$user->toArray()
    	);
    }

    public function getMyUsersAction(){
        return $this->getList();
    }

    public function create($data){
        $this->getEntityManager();
        $user = new \User\Entity\User($data);
        $user->validate($this->em);
        
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
        
        return new JsonModel($user->toArray());
    }

    public function update($id, $data){
        // Action used for PUT requests
        $user = $this->getEntityManager()->getRepository('User\Entity\User')->find($id);
        $user->set($data);
        $user->validate($this->em);
        
        $this->getEntityManager()->flush();
        
        return new JsonModel($user->toArray());
    }

    public function delete($id){
        // Action used for DELETE requests
        $user = $this->getEntityManager()->getRepository('User\Entity\User')->find($id);
        $this->getEntityManager()->remove($user);
        
        $this->getEntityManager()->flush();
        
        return new JsonModel($user->toArray());
    }
}
