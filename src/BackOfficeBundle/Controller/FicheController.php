<?php

namespace BackOfficeBundle\Controller;

use BackOfficeBundle\Entity\Fiche;
use BackOfficeBundle\Entity\Image;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


/**
 * Fiche controller.
 *
 */
class FicheController extends Controller
{
    /**
     * @Route("/fiches", name="fiches")
    */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $repository = $em->getRepository('BackOfficeBundle:Fiche');
        $query = $repository->createQueryBuilder('u')
        ->select('g.prenom', 'u.nom','u.decription','u.id_fiche','u.date_ajout')
                ->innerJoin('BackOfficeBundle:Administrateur', 'g')
                ->where('g.id = u.id')
                ->getQuery()->getResult();
        return $this->render('BackOfficeBundle:Fiches:fiches.html.twig', array(
            'fiches' => $query,
        ));
    }

    /**
     * @Route("/fiche/ajout")
    */
    public function newAction(Request $request)
    {
        $fiche = new Fiche();
        $img = new Image();
        $form = $this->createForm('BackOfficeBundle\Form\FicheType', $fiche);
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();
        $user = $this->getDoctrine()->getRepository('BackOfficeBundle:Administrateur')->find("1");
        $categories = $em->getRepository('BackOfficeBundle:Categorie')->findAll();
        
        if ($form->isSubmitted() && $form->isValid()) {
            //Enregitrer Dates et infos utilisateur
            $date = date('Y-m-d');
            $date = new \DateTime($date);
            $fiche->setDateAjout($date);
            $fiche->setDateModification($date);
            $fiche->setId($user);
            //Enregistrer Categorie
            $id_cat = $request->request->get('categorie');
            $categorie = $this->getDoctrine()->getRepository('BackOfficeBundle:Categorie')->find($id_cat);
            $fiche->setIdCat($categorie);         
            $em->persist($fiche);
            $em->flush();
            
            //Upload des images          
             $images = $fiche->getImages();
             foreach ($images as $image) {
                 
                 $imageName = $image->getClientOriginalName();
                 $image->move(
                     $this->getParameter('images_directory'),
                     $imageName
                 );
                 $img->setChemin( $this->getParameter('images_directory').'/'.$image->getClientOriginalName());
                 $img->setTaille($image->getClientSize());
                 $img->setNom($image->getClientOriginalName());
                 $img->setDateAjout($date);
                 $img->setDateModification($date);
                 $img->setIdFiche($fiche);
                
                 $em->persist($img);
            }
            $em->flush();

            return $this->redirectToRoute('fiches');
        }

        return $this->render('BackOfficeBundle:Fiches:ajouter-fiche.html.twig', array(
            'fiche' => $fiche,
            'categories' => $categories,
            'form' => $form->createView(),
        ));
    }

 

    /**
    * @Route("/fiche/modifier/{fiche}", name="modifier_fiche")
    */
    public function editAction(Request $request, Fiche $fiche)
    {
        $img = new Image();
        $editForm = $this->createForm('BackOfficeBundle\Form\FicheType', $fiche);
        $editForm->handleRequest($request);
        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository('BackOfficeBundle:Categorie')->findAll();
        
        // Calculer note finale
        $somme = $this->finalNote($fiche);

        //Récupérer les commentaires reliés a la fiche
        $repository = $em->getRepository('BackOfficeBundle:Commentaire');
        $query = $repository->createQueryBuilder('u')
        ->select('g.email,u.texte,u.id_com,u.date_ajout')
                ->innerjoin('BackOfficeBundle:Utilisateur', 'g' ,'WITH', 'u.id_utilisateur = g.id_utilisateur')
                ->where ('u.id_fiche = :idFiche')
                ->setParameters(['idFiche'=> $fiche->getIdFiche()])
                ->getQuery()->getResult();
                
        // Récupérer les notes de la fiche 
         $repository2 = $em->getRepository('BackOfficeBundle:Note');
         $query2 = $repository2->createQueryBuilder('u')
        ->select('g.email,u.note,u.id_note,u.date_ajout')
                ->innerjoin('BackOfficeBundle:Utilisateur', 'g' ,'WITH', 'u.id_utilisateur = g.id_utilisateur')
                ->where ('u.id_fiche = :idFiche')
                ->setParameters(['idFiche'=> $fiche->getIdFiche()])
                ->getQuery()->getResult();
       
        // Récupérer les images de la fiche
        $repository3 = $em->getRepository('BackOfficeBundle:Image');
        $query3 = $repository3->createQueryBuilder('u')
        ->select('u.id_image,u.nom')
                ->where ('u.id_fiche = :idFiche')
                ->setParameters(['idFiche'=> $fiche->getIdFiche()])
                ->getQuery()->getResult();
        
   
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $date = date('Y-m-d');
            $date = new \DateTime($date); 
            $fiche->setDateModification($date);
             //EnregistrerCategorie
            $id_cat = $request->request->get('categorie');
            $cat = $this->getDoctrine()->getRepository('BackOfficeBundle:Categorie')->find($id_cat);
            $fiche->setIdCat($cat);
            $this->getDoctrine()->getManager()->flush();
            //Upload des images          
             $images = $fiche->getImages();
             foreach ($images as $image) {
                 
                 $imageName = $image->getClientOriginalName();
                 $image->move(
                     $this->getParameter('images_directory'),
                     $imageName
                 );
                 $img->setChemin( $this->getParameter('images_directory').'/'.$image->getClientOriginalName());
                 $img->setTaille($image->getClientSize());
                 $img->setNom($image->getClientOriginalName());
                 $img->setDateAjout($date);
                 $img->setDateModification($date);
                 $img->setIdFiche($fiche);
                
                 $em->persist($img);
             }
              $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('modifier_fiche', array('fiche' => $fiche->getIdFiche()));
        }

        return $this->render('BackOfficeBundle:Fiches:consulter-fiche.html.twig', array(
            'fiche'         => $fiche,
            'edit_form'     => $editForm->createView(),
            'commentaires'  => $query,
            'notes'         => $query2,
            'categories'    => $categories,
            'images'        => $query3,
            'note'          =>$somme,
        ));
    }

     /**
    * @Route("/fiche/supprimer/{fiche}", name="supprimer_fiche")
    */
    public function deleteAction(Request $request, Fiche $fiche)
    {
        if ($fiche) {
            $em = $this->getDoctrine()->getManager();
            
             //Supprimer les commentaires reliés a la fiche 
            $query =  $em->createQuery(
                        'DELETE 
                            BackOfficeBundle:Commentaire u 
                            WHERE 
                            u.id_fiche = :idFiche'
                         )
                    ->setParameters(['idFiche'=> $fiche->getIdFiche()]);
                    $query->execute();
                    
            // Supprimer les notes de la fiche 
            $query2 =  $em->createQuery(
                        'DELETE 
                            BackOfficeBundle:Note u
                            WHERE 
                            u.id_fiche = :idFiche'
                         )
                    ->setParameters(['idFiche'=> $fiche->getIdFiche()]);
                    $query2->execute();
          
            // Supprimer les images de la fiche
            $query3 = $em->createQuery(
                        'DELETE 
                            BackOfficeBundle:Image u
                            WHERE 
                            u.id_fiche = :idFiche'
                        )   
                    ->setParameters(['idFiche'=> $fiche->getIdFiche()]);
                    $query3->execute();
            // Supprimer les notifications 
             $query4 =  $em->createQuery(
                        'DELETE 
                            BackOfficeBundle:Notification u
                            WHERE 
                            u.id_fiche = :idFiche'
                         )
                    ->setParameters(['idFiche'=> $fiche->getIdFiche()]);
                    $query4->execute();
                $em->remove($fiche);
                $em->flush();
            }
           
           

        return $this->redirectToRoute('fiches');
    }

    /**
     * Creates a form to delete a fiche entity.
     *
     * @param Fiche $fiche The fiche entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Fiche $fiche)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('fiche_delete', array('id_fiche' => $fiche->getId_fiche())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
    public function finalNote(fiche $fiche) {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('BackOfficeBundle:Note');
        $query = $repository->createQueryBuilder('g')
            ->select("avg(g.note) as note")
            ->where ('g.id_fiche = :idFiche')
            ->setParameters(['idFiche'=> $fiche->getIdFiche()])
            ->getQuery();
        $somme = $query->getSingleScalarResult();      
        return $somme;
    }
}
