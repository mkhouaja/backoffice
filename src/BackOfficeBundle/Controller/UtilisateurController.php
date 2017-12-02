<?php

namespace BackOfficeBundle\Controller;

use BackOfficeBundle\Entity\Utilisateur;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * Utilisateur controller.
 *
 */
class UtilisateurController extends Controller
{
    /**
     * @Route("/utilisateurs", name="utilisateurs")
    */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $utilisateurs = $em->getRepository('BackOfficeBundle:Utilisateur')->findAll();

        return $this->render('BackOfficeBundle:Utilisateurs:utilisateurs.html.twig', array(
            'utilisateurs' => $utilisateurs,
        ));
    }
    /**
    * @Route("/utilisateur/modifier/{utilisateur}", name="modifier_utilisateur")
    */
    public function editAction(Request $request, Utilisateur $utilisateur)
    {
        $editForm = $this->createForm('BackOfficeBundle\Form\UtilisateurType', $utilisateur);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('utilisateurs');
        }

        return $this->render('BackOfficeBundle:Utilisateurs:modifier-utilisateur.html.twig', array(
            'utilisateur' => $utilisateur,
            'edit_form' => $editForm->createView()
        ));
    }

     /**
    * @Route("/utilisateur/supprimer/{utilisateur}", name="supprimer_utilisateur")
    */
    public function deleteAction(Utilisateur $utilisateur)
    {

        if ($utilisateur) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($utilisateur);
            $em->flush();
        }

        return $this->redirectToRoute('utilisateurs');
    }
    /**
     * @Route("/api/utilisateur/ajout", name="ajout-utilisateur")
     * @Method({"POST"})
     */
    public function addUtilisateur(Request $request)
    {
         $em = $this->getDoctrine()->getManager();
         $repository = $em->getRepository('BackOfficeBundle:Utilisateur');
       
        
        $entityBody = file_get_contents('php://input');
        $results = json_decode($entityBody);     
        $pseudo= $repository->findBy(array('pseudo' => $results->{'pseudo'}));
        $email = $repository->findBy(array('email' => $results->{'email'}));
        if(count($email) > 0 && $pseudo > 0) {
             $response = new Response(json_encode("pseudo + email"));
             return $response;    
             die(); 
        }
        elseif(count($email) > 0) {
             $response = new Response(json_encode("email"));
             return $response;    
             die();
        }  
        elseif (count($pseudo) > 0) {
             $response = new Response(json_encode("pseudo"));
             return $response;    
             die();
        }  
        else {
        $date = date('Y-m-d');
        $date = new \DateTime($date); 
        $user = new Utilisateur();
        $user->setEmail($results->{'email'})
                ->setMotDePasse(md5($results->{'password'}))
                ->setDateAjout($date)
                ->setDateModification($date)
                ->setIdDevice($results->{'device'})
                ->setPseudo($results->{'pseudo'});
        $em->persist($user);
        $em->flush();
 
        $response = new Response(json_encode($user->getIdUtilisateur()));
        }
      return $response;                   
    }
    /**
     * @Route("/api/utilisateur/login", name="login-utilisateur")
     * @Method({"POST"})
     */
    public function login(Request $request)
    {   
        $entityBody = file_get_contents('php://input');
        $results = json_decode($entityBody);
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('BackOfficeBundle:Utilisateur');
        $query = $repository->createQueryBuilder('u')
        ->select('u.email,u.mot_de_passe,u.id_utilisateur id')   
                ->where ('u.email = :email AND u.mot_de_passe = :password')
                ->setParameters(['email'=> $results->{'email'},'password'=> md5($results->{'password'})])           
                ->getQuery()->getResult();
        $user = $query;
    
        if(count($user) == 0) {
            $response = new Response(json_encode("ko"));
        }
        else {
            $response = new Response(json_encode($user[0]['id']));
        }
    
      return $response;                   
    }
}
