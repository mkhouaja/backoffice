<?php

namespace BackOfficeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class CommentairesController extends Controller 
{
    /**
     * @Route("/commentaires", name="commentaires")
     */
    public function commentairessAction()
    {
        return $this->render('BackOfficeBundle:Pages:commentaires.html.twig');
    }
}