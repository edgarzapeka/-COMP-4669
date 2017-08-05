<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Application\Database\TokenTable;
use Zend\Json\Json;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Mvc\Controller\Plugin\Redirect;
use Zend\View\Helper\Url;
use Zend\View\Model\ViewModel;
use Instagram\Auth;
use Instagram\Instagram;
use Zend\View\Model\JsonModel;

class IndexController extends AbstractActionController
{

    private $auth;
    private $tokenTable;

    public function __construct()
    {
        $this->tokenTable = new TokenTable('php_lesson', 'root', 'simple123pass');

        $this->auth = new Auth([
            'client_id' => 'e5858c939d1440b19cc8f05dfd63bbb6',
            'client_secret' => '21f43dbea0984b4ca9f18694815304a6',
            'redirect_uri' => 'http://localhost:8888/authorize',
            'scope' => ['public_content']
        ]);
    }

    public function indexAction()
    {
        return new ViewModel();
    }

    public function loginAction(){
        $this->auth->authorize();
    }

    public function authorizeAction(){
        $data = [];

        $code = $this->getRequest()->getQuery('code');

        $token = $this->auth->getAccessToken($code);

        $this->tokenTable->insertToken(['login_id' => 0, 'token' => $token]);

        return $this->redirect()->toRoute('picture');
    }

    public function pictureAction(){

        $data = [];
        $comments = [];
        $photos = [];

        $tokens = $this->tokenTable->getTokens();
        foreach($tokens as $token)
        {
            $data[] = ['login_id' => $token['login_id'], 'token' => $token['token']];
        }

        $token = array_pop($data)['token'];

        if ($token == null){
            return new ViewModel( array('picture' => 'img/hqdefault.jpg'));
        }

        $instagram = new Instagram();
        $instagram->setAccessToken($token);

        $user = $instagram->getCurrentUser();
        $media = $user->getMedia();

        $data = [];
        foreach ($media as $picture){
            //$data[] = $picture->images;
            /*if ($picture->getComments()->getData() != []){
                $comments[] = $picture->getComments()->getData()[0]->text;
            }*/
            //$photos[] = $picture->getStandardRes()->url;
            $comments[] = $picture->getUser()->getFullName();
        }

        //$url = $data[0]->standard_resolution->url;
        //var_dump($photos);

        /*foreach ($comments as $comment){
            echo "<br/>";
            echo print_r($comment, true);
            echo "<br/>";
        }*/
        return new JsonModel($comments);
    }
}
