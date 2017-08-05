<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\I18n\Validator\Alpha;

class ServiceController extends AbstractActionController
{
    public function indexAction()
    {
        $nameValidator = new Alpha();

        $name = $this->params()->fromQuery('name', 'No name provided');

        $name = $nameValidator->isValid($name) ? $name : "Invalid name. Must be alphabetical";

        return new ViewModel(['name' => $name]);
    }

}
