<?php
    
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;  
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class LoginController extends Controller
{
    /**
     * @Route("/login")
     */
    public function numberAction()
    {
        $number = mt_rand(0, 100);

         return $this->render('login.html.twig', array(
            'number' => $number,
        ));
    }
}