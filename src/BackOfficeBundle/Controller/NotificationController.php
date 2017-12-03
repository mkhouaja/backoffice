<?php

namespace BackOfficeBundle\Controller;

use BackOfficeBundle\Entity\Notification;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Notification controller.
 *
 */
class NotificationController extends Controller
{
    /**
     * @Route("/notifications", name="notifications")
    */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('BackOfficeBundle:Notification');
        $query = $repository->createQueryBuilder('u')
        ->select('u.id_notif', 'u.titre','u.texte','u.date_ajout','u.date_envoi','f.nom')
                ->innerJoin('BackOfficeBundle:Fiche', 'f')
                ->where('u.id_fiche = f.id_fiche')
                ->getQuery()->getResult();
        return $this->render('BackOfficeBundle:Notifications:notifications.html.twig', array(
            'notifications' => $query,
        ));
    }

    /**
    * @Route("/notifications/ajouter")
    */
    public function newAction(Request $request)
    {
        $notification = new Notification();
        $form = $this->createForm('BackOfficeBundle\Form\NotificationType', $notification);
        $form->handleRequest($request);
        $user = $this->getDoctrine()->getRepository('BackOfficeBundle:Administrateur')->find("1");
        $fiches = $this->getDoctrine()->getRepository('BackOfficeBundle:Fiche')->findAll();

        if ($form->isSubmitted() && $form->isValid()) {
            //Enregitrer Dates et infos utilisateur
            $date = date('Y-m-d');
            $date = new \DateTime($date);
            $notification->setDateAjout($date);
            $notification->setDateModification($date);
            $notification->setId($user);
             //EnregistrerFiche
            $id_fiche = $request->request->get('fiche');
            $fiche = $this->getDoctrine()->getRepository('BackOfficeBundle:Fiche')->find($id_fiche);
            $notification->setIdFiche($fiche);
            $em = $this->getDoctrine()->getManager();
            $em->persist($notification);
            $em->flush();

            return $this->redirectToRoute('notifications');
        }

        return $this->render('BackOfficeBundle:Notifications:ajouter-notification.html.twig', array(
            'notification' => $notification,
            'fiches'       => $fiches,
            'form' => $form->createView(),
        ));
    }

   

    
    /**
    * @Route("/notification/modifier/{notification}", name="modifier_notification")
    */
    public function editAction(Request $request, Notification $notification)
    {
        $fiches = $this->getDoctrine()->getRepository('BackOfficeBundle:Fiche')->findAll();
        $editForm = $this->createForm('BackOfficeBundle\Form\NotificationType', $notification);
        $editForm->handleRequest($request);
        $repository = $this->getDoctrine()->getRepository('BackOfficeBundle:Notification');
        $query = $repository->createQueryBuilder('u')
        ->select('u.id_notif', 'u.titre','u.texte','f.nom')
                ->innerJoin('BackOfficeBundle:Fiche', 'f','WITH','u.id_fiche = f.id_fiche')
                ->where('u.id_notif = :notification')
                ->setParameter('notification', $notification)
                ->getQuery()->getResult();
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $date = date('Y-m-d');
            $date = new \DateTime($date);
            $notification->setDateModification($date);
             //EnregistrerFiche
            $id_fiche = $request->request->get('fiche');
            $fiche = $this->getDoctrine()->getRepository('BackOfficeBundle:Fiche')->find($id_fiche);
            $notification->setIdFiche($fiche);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('notifications');
        }

        return $this->render('BackOfficeBundle:Notifications:modifier-notification.html.twig', array(
            'notification' => $query,
            'fiches'       => $fiches,
            'edit_form' => $editForm->createView()
        ));
    }

    
    /**
    * @Route("/notification/supprimer/{notification}", name="supprimer_notification")
    */
    public function deleteAction(Request $request, Notification $notification)
    {
        
        if ($notification) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($notification);
            $em->flush();
        }

        return $this->redirectToRoute('notifications');
    }

    /**
    * @Route("/notification/envoyer/{notification}", name="envoyer_notification")
    */
    private function createDeleteForm(Notification $notification)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('notification_delete', array('id_notif' => $notification->getId_notif())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
