<?php

namespace BackOfficeBundle\Controller;

use BackOfficeBundle\Entity\Note;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
/**
 * Note controller.
 *
 */
class NoteController extends Controller
{
    /**
     * Displays a form to edit an existing note entity.
     *
     */
    public function editAction(Request $request, Note $note)
    {
        $deleteForm = $this->createDeleteForm($note);
        $editForm = $this->createForm('BackOfficeBundle\Form\NoteType', $note);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('note_edit', array('id_note' => $note->getId_note()));
        }

        return $this->render('note/edit.html.twig', array(
            'note' => $note,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a note entity.
     *
     */
    public function deleteAction(Request $request, Note $note)
    {
        $form = $this->createDeleteForm($note);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($note);
            $em->flush();
        }

        return $this->redirectToRoute('note_index');
    }
    /**
     * @Route("/api/note/ajout", name="ajout_note")
     * @Method({"POST"})
     */
    public function addNote(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('BackOfficeBundle:Note');
        $entityBody = file_get_contents('php://input');
        $results = json_decode($entityBody);
         $date = date('Y-m-d');
        $date = new \DateTime($date); 
        //vérifier si l'utilisateur a déjà noté la fiche
        $trouve = $repository->findBy(array('id_fiche' => $results->{'id_fiche'},'id_utilisateur'=> $results->{'id_utilisateur'}));
       if (count($trouve) > 0 ){
           $note = $this->getDoctrine()->getRepository('BackOfficeBundle:Note')->find($trouve[0]->getIdNote());
           $editForm = $this->createForm('BackOfficeBundle\Form\NoteType', $note);     
           $note->setNote($results->{'note'})
           ->setDateModification($date);
       }
       else {
       
        $note = new Note();
        $note->setNote($results->{'note'})
                    ->setIdFiche($results->{'id_fiche'})
                    ->setDateAjout($date)
                    ->setDateModification($date) 
                    ->setIdUtilisateur($results->{'id_utilisateur'});
  
        }
        $em->persist($note);
        $em->flush();
       
        $response = new Response(json_encode($entityBody));
        
      return $response;                   
    }
}
