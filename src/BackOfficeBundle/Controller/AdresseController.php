<?php

namespace BackOfficeBundle\Controller;

use BackOfficeBundle\Entity\Adresse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Adresse controller.
 *
 */
class AdresseController extends Controller
{
	 /**
     * @Route("/api/adresse/{adresse}", name="adresse")
     * @Method({"GET"})
    */
    public function getAdresse(Int $adresse)
    {
	    $em = $this->getDoctrine()->getManager();
        $adresse = $em->getRepository('BackOfficeBundle:Adresse')->find($adresse);
        $formatted = [
               'latitude' => $adresse->getLatitude(),
               'longitude' => $adresse->getLangitude(),
            ];
         return new JsonResponse($formatted);
     }	
}
