<?php

namespace BackOfficeBundle\Controller;

use BackOfficeBundle\Entity\Administrateur;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
 
class DefaultController extends Controller 
{
    /**
     * @Route("/index", name="index")
     */
    public function indexAction(SessionInterface $session)
    {
    
        if($session->get('id')==''){
             return $this->redirectToRoute('admin');
        }
       
        $user = $this->getDoctrine()->getRepository('BackOfficeBundle:Administrateur')->find($session->get('id'));
        $em = $this->getDoctrine()->getManager();
        
        $utilisateurs = $em->getRepository('BackOfficeBundle:Utilisateur')->findAll(); 
        $fiches = $em->getRepository('BackOfficeBundle:Fiche')->findAll();
        $commentaires = $em->getRepository('BackOfficeBundle:Commentaire')->findAll();  
        $notifications = $em->getRepository('BackOfficeBundle:Notification')->findAll();   
           
        $this->get('session')->set('administrateur', $user->getPrenom());
        return $this->render('BackOfficeBundle:Default:index.html.twig', array(
            'administrateur' => $user->getPrenom(),
            'nb_u'=> count($utilisateurs),
            'nb_f'=> count($fiches),
            'nb_c'=> count($commentaires),
            'nb_n'=> count($notifications)));
    }
    
    /**
     * @Route("/profil/{administrateur}" ,name="profil")
    */
    public function editAction(Request $request, Administrateur $administrateur,SessionInterface $session)
    {
        if($session->get('id')==''){
             return $this->redirectToRoute('admin');
        }
        $editForm = $this->createForm('BackOfficeBundle\Form\AdministrateurType', $administrateur);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('index',array("msg" => "Modification réussie"));
        }

        return $this->render('BackOfficeBundle:Administrateurs:profil.html.twig', array(
            'administrateur' => $administrateur,
            'edit_form' => $editForm->createView()
        ));
    }
}