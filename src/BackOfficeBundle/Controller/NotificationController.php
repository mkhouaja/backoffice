<?php

namespace BackOfficeBundle\Controller;

use BackOfficeBundle\Entity\Notification;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * Notification controller.
 *
 */
class NotificationController extends Controller
{
    /**
     * @Route("/notifications", name="notifications")
    */
    public function indexAction(SessionInterface $session)
    {
        if($session->get('id')==''){
             return $this->redirectToRoute('admin');
        }
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
    public function newAction(Request $request,SessionInterface $session)
    {
        if($session->get('id')==''){
             return $this->redirectToRoute('admin');
        }
        $notification = new Notification();
        $form = $this->createForm('BackOfficeBundle\Form\NotificationType', $notification);
        $form->handleRequest($request);
        $user = $this->getDoctrine()->getRepository('BackOfficeBundle:Administrateur')->find($session->get('id'));
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
            $envoi = $request->request->get('envoyer');
            if($envoi == "envoyer") {
                 $this->SendNotification($notification);
            }
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
    public function editAction(Request $request, Notification $notification,SessionInterface $session)
    {
        if($session->get('id')==''){
             return $this->redirectToRoute('admin');
        }
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
    public function SendNotification(Notification $notification)
    
    {
    // écupérer les devices id 
    $repository = $this->getDoctrine()->getRepository('BackOfficeBundle:Utilisateur');
    $query = $repository->createQueryBuilder('u')
    ->select('u.id_device')
    ->getQuery()->getResult();
 
    for($i = 0;$i<count($query);$i++)
    {
        $data[] = $query[0]["id_device"];
    }
 
    $url = 'https://fcm.googleapis.com/fcm/send';

    $fields = array (
            'registration_ids' => $data,
            'data' => array (
                    "title"   => $notification->getTitre(),
                    "message" => $notification->getTexte()
            )
    );
    $fields = json_encode ( $fields );

    $headers = array (
            'Authorization: key=' . "AAAAhmt3EeU:APA91bEubKrJEtDr48HbDe2vwYgEM2lQK0sB1V16rqGf2BhnPH5sdK1dccHjFaEpTxs-efcxCFdxuHt3-sa-eU0mc6_nZ2msY1hF8FksLf0Blup_AUveO5oyr9fWyd6x4Xoj5AzNMNe3",
            'Content-Type: application/json'
    );

    $ch = curl_init();
    curl_setopt ( $ch, CURLOPT_URL, $url );
    curl_setopt ( $ch, CURLOPT_POST, true );
    curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
    curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
    curl_setopt ( $ch, CURLOPT_POSTFIELDS, $fields );

    $result = curl_exec ( $ch );
    //Enregistrement de la date d'envoi dans la base
    $repository = $this->getDoctrine()->getRepository('BackOfficeBundle:Notification');
    $date = date('Y-m-d');
    $date = new \DateTime($date);
    $notification->setDateEnvoi($date);
    $this->getDoctrine()->getManager()->flush();

    curl_close ( $ch );
    
    return $this->redirectToRoute("notifications");
    }

}
