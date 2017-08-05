<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Validator\Digits;
use Zend\Validator\EmailAddress;
use Zend\Validator\StringLength;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        $request = $this->getRequest();
        $data = [];

        if ($request->isPost()){
            $userName = $request->getPost('userName');
            $email = $request->getPost('email');
            $age = $request->getPost('age');

            $validateEmail = new EmailAddress();
            $validateAge = new Digits();
            $validateName = new StringLength(['max' => 25]);

            if ($validateName->isValid($userName) && $validateAge->isValid($age) && $validateEmail->isValid($email)){
                $data = ['message' => 'Success!', 'userName' => $userName, 'email' => $email, 'age' => $age];
            } else{
                $message = $validateName->getMessages();
                $data = ['message' => 'Invalid data'];
            }
        }

        return new ViewModel($data);
    }

    public function menuFirstAction(){
        return new ViewModel();
    }

    public function menuSecondAction(){
        return new ViewModel();
    }

    public function menuThirdAction(){
        return new ViewModel();
    }
}
