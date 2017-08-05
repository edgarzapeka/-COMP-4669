<?php
/**
 * Created by PhpStorm.
 * User: edz
 * Date: 2017-06-02
 * Time: 2:54 PM
 */

namespace Application\Controller;


use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class GalleryController extends AbstractActionController
{
    public function indexAction()
    {
        $data = [
            '1505465478',
            '1800180867',
            '4961840325',
            '5065071803',
            '5665772016',
            '6214183289',
            '6563995309',
            '6897469293',
            '7787767022',
            '9191892931',
            '9655789441'
        ];

        return new ViewModel(['data' => $data]);
    }

    public function detailsAction()
    {
        $image = $this->params()->fromRoute('id');

        return new ViewModel(['data' => $image]);
    }
}