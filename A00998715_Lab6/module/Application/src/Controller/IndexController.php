<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Application\Database\UserTable;
use Application\Model\User;
use Instagram\Instagram;
use Instagram\Auth;

class IndexController extends AbstractActionController
{

    private $auth;

    public function __construct()
    {
        $this->auth = new Auth([
            'client_id' => 'f21753353d9e491db1f6229610769119',
            'client_secret' => '3d3584bda39942c4bc357214f4376174',
            'redirect_uri' => 'http://localhost:8888/authorize',
            'scope' => ['public_content']
        ]);
    }

    public function indexAction()
    {
        return new ViewModel();
    }

    public function usersAction(){

        $data = [];
        $userTable = new UserTable('php_lesson', 'root', '');
        $users = $userTable->getUsers();
        foreach($users as $user)
        {
            $userModel = new User();
            $userModel->setAge($user['users_age']);
            $userModel->setFullName($user['users_firstname'] . ' ' .
                $user['users_lastname']);
            $data[] = $userModel->getArray();
        }

        return new JsonModel(
            $data);

    }

    public function loginAction(){
        $this->auth->authorize();
    }

    public function authorizeAction(){
        $data = [];

        $code = $this->getRequest()->getQuery('code');

        $token = $this->auth->getAccessToken($code);

        $instagram = new Instagram();
        $instagram->setAccessToken($token);

        $user = $instagram->getCurrentUser();
        $media = $user->getMedia();

        foreach ($media as $picture){
            $data[] = $picture->images;
        }

        return new JsonModel($data);
    }
}