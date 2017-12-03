<?php

namespace BackOfficeBundle\Controller;

use BackOfficeBundle\Entity\Administrateur;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Administrateur controller.
 *
 */
class AdministrateurController extends Controller
{
    
    /**
     * @Route("/", name="admin")
     
    */
    public function loginAction(Request $request)
    {
        $session = new Session();
        //$session->start();
        $administrateur = new Administrateur();
        $form = $this->createForm('BackOfficeBundle\Form\AdministrateurType', $administrateur, array(
            'action' => $this->generateUrl('admin'),
            'method' => 'POST'
        ));
        $error = 'Vérifiez vos identifiants';
        $form->handleRequest($request);
        if ($form->isSubmitted()) 
         {
              $em = $this->getDoctrine()->getManager();
              $repository = $em->getRepository('BackOfficeBundle:Administrateur');
              $email =$request->request->get('backofficebundle_administrateur')['email'];
              $mp =$request->request->get('backofficebundle_administrateur')['mot_de_passe'];
              $query = $repository->createQueryBuilder('u')
                ->select('u.email,u.mot_de_passe,u.id')   
                ->where ('u.email = :email AND u.mot_de_passe = :password')
                ->setParameters(['email'=> $email,'password'=> $mp])           
                ->getQuery()->getResult();
                $user = $query;
 
                if(count($user) == 0) {
                    return $this->render('BackOfficeBundle:Pages:login.html.twig', array(
                    'administrateur' => $administrateur,
                     'form' => $form->createView(),
                     'error'=> $error
        ));
                }
                else {
                    $error="";
                    $session->set('id', $user[0]['id']);
                    return $this->redirectToRoute('index');
                }
         }
         return $this->render('BackOfficeBundle:Pages:login.html.twig', array(
            'administrateur' => $administrateur,
            'form' => $form->createView(),
            'error'=> $error
        ));
    }
}