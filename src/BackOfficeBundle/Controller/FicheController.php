<?php

namespace BackOfficeBundle\Controller;

use BackOfficeBundle\Entity\Fiche;
use BackOfficeBundle\Entity\Image;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;


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
                 $img = new Image();
                 $em2 = $this->getDoctrine()->getManager();
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
                
                 $em2->persist($img);
                 $em2->flush();
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
    
    /*********** Liste des fonctions appelées par l'application*************/
    /**
     * @Route("/api/fiches-list/{categorie}", name="fiches_list")
     * @Method({"GET"})
     */
    public function getFiches(Int $categorie)
    {
       $em = $this->getDoctrine()->getManager();
       $repository = $em->getRepository('BackOfficeBundle:Fiche');
        $query = $repository->createQueryBuilder('u')
        ->select('g.nom nom_image,u.id_fiche,u.nom,u.decription') 
                ->innerjoin('BackOfficeBundle:Image', 'g' ,'WITH', 'u.id_fiche = g.id_fiche')            
                ->where ('u.id_cat = :idCat')
                ->setParameters(['idCat'=> $categorie])
                ->getQuery()->getResult();
        $fiches = $query;
        /* @var $fiches Fiche[] */

        $formatted = [];
        foreach ($fiches as $fiche) {
            $formatted[] = [
               'id'             => $fiche['id_fiche'],
               'nom'            => $fiche['nom'],
               'description'    => $fiche['decription'],
               'url_image'      => 'http://127.0.0.1:8000/uploads/images/'.$fiche['nom_image']
            ];
        }

        return new JsonResponse($formatted);
    }
    /**
     * @Route("/api/fiche/{fiche}", name="fiche_details")
     * @Method({"GET"})
     */
    public function getFiche(Int $fiche)
    {
       $em = $this->getDoctrine()->getManager();
       $repository = $em->getRepository('BackOfficeBundle:Fiche');
       
       // Calculer note finale de la fiche
       $repository2 = $em->getRepository('BackOfficeBundle:Note');
        $query2 = $repository2->createQueryBuilder('g')
            ->select("avg(g.note) as note")
            ->where ('g.id_fiche = :idFiche')
            ->setParameters(['idFiche'=> $fiche])
            ->getQuery();
        $somme = $query2->getSingleScalarResult(); 
        
       // Récupérer l'adresse
       $repository3 = $em->getRepository('BackOfficeBundle:Adresse');
       $query3 = $repository3->createQueryBuilder('u')
        ->select('u.numero,u.rue,u.code_postal,u.ville,u.pays') 
                ->innerjoin('BackOfficeBundle:Fiche', 'g' ,'WITH', 'g.adresse = u.id_adresse')   
                ->where ('g.id_fiche = :idFiche')
                ->setParameters(['idFiche'=> $fiche])           
                ->getQuery()->getResult();
        $adresse = $query3;
  
       // Récupérer Fiche    
        $query = $repository->createQueryBuilder('u')
        ->select('g.nom nom_image,u.id_fiche,u.nom,u.decription') 
                ->innerjoin('BackOfficeBundle:Image', 'g' ,'WITH', 'u.id_fiche = g.id_fiche')            
                ->where ('u.id_fiche = :idFiche')
                ->setParameters(['idFiche'=> $fiche])
                ->getQuery()->getResult();
        $fiche = $query;
        /* @var $fiches Fiche[] */
            $adresse = $adresse[0]['numero'].' '.$adresse[0]['rue'].' '.$adresse[0]['code_postal'].' '.$adresse[0]['ville'].' '.$adresse[0]['pays'];
            $formatted = [];
            if ((int)$somme > 0) 
               $somme = round($somme);
            else 
                $somme = "-";
           
            $formatted[] = [
               'id'             => $fiche[0]['id_fiche'],
               'nom'            => $fiche[0]['nom'],
               'description'    => $fiche[0]['decription'],
               'url_image'      => 'http://127.0.0.1:8000/uploads/images/'.$fiche[0]['nom_image'],
               'note_finale'    => $somme,
               'adresse'        => $adresse
            ];


        return new JsonResponse($formatted);
    }
}
