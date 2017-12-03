<?php

namespace BackOfficeBundle\Controller;

use BackOfficeBundle\Entity\Image;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Image controller.
 *
 */
class ImageController extends Controller
{  
   /**
    * @Route("/image/supprimer/{image}", name="supprimer_image")
    */
    public function deleteAction(Request $request, Image $image)
    {
        if ($image) {
            $em = $this->getDoctrine()->getManager();
            unlink($image->getChemin());
            $em->remove($image);
            $em->flush();
        }
        return $this->redirectToRoute('modifier_fiche', array('fiche' => $image->getIdFiche()->getIdFiche()));
    }
}
