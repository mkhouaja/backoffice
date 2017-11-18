<?php
    
namespace BackOfficeBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;  
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class LoginController extends Controller
{
    /**
     * @Route("/login")
     */
    public function loginAction()
    {


         return $this->render('BackOfficeBundle:Pages:login.html.twig');
    }
}