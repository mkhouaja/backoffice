<?php
namespace BackOfficeBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
/**
 * @ORM\Entity
 * @ORM\Table(name="fiche")
 */
class Fiche
{

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id_fiche;
     /**
     * @ORM\Column(type="string", length=100)
     */
    private $nom;
	/**
     * @ORM\Column(type="string", length=300)
     */
    private $decription;
    /**
     * @ORM\Column(type="date")
     */
    private $date_ajout;
    /**
     * @ORM\Column(type="date")
     */
    private $date_modification;
     /**
     * @ORM\ManyToOne(targetEntity="Administrateur", inversedBy="fiches")
     * @ORM\JoinColumn(name="id", referencedColumnName="id")
     */
    private $id;
    /**
     * @ORM\ManyToOne(targetEntity="Categorie", inversedBy="fiches")
     * @ORM\JoinColumn(name="id_cat", referencedColumnName="id_cat")
     */
     
    private $id_cat;
    /**
    * @ORM\OneToOne(targetEntity="Adresse",cascade={"persist"})
    * @ORM\JoinColumn(name="id_adresse", referencedColumnName="id_adresse")
    */
    protected $adresse;
    
    /**

     * @ORM\OneToMany(targetEntity="Image", mappedBy="id_fiche")
     */
    private $image;
    /**
     * @ORM\OneToMany(targetEntity="Commentaire", mappedBy="id_fiche")
     */
    private $commentaires;
     /**
     * @ORM\OneToMany(targetEntity="Notification", mappedBy="id_fiche")
     */
    private $notifications
    ;
    public function __construct()
    {
        //$this->images = new ArrayCollection();
        $this->commentaires = new ArrayCollection();
        $this->notifications = new ArrayCollection();
    }
    /**
     * Get idFiche
     *
     * @return integer
     */
    public function getIdFiche()
    {
        return $this->id_fiche;
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return Fiche
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set decription
     *
     * @param string $decription
     *
     * @return Fiche
     */
    public function setDecription($decription)
    {
        $this->decription = $decription;

        return $this;
    }

    /**
     * Get decription
     *
     * @return string
     */
    public function getDecription()
    {
        return $this->decription;
    }

    /**
     * Set dateAjout
     *
     * @param \DateTime $dateAjout
     *
     * @return Fiche
     */
    public function setDateAjout($dateAjout)
    {
        $this->date_ajout = $dateAjout;

        return $this;
    }

    /**
     * Get dateAjout
     *
     * @return \DateTime
     */
    public function getDateAjout()
    {
        return $this->date_ajout;
    }

    /**
     * Set dateModification
     *
     * @param \DateTime $dateModification
     *
     * @return Fiche
     */
    public function setDateModification($dateModification)
    {
        $this->date_modification = $dateModification;

        return $this;
    }

    /**
     * Get dateModification
     *
     * @return \DateTime
     */
    public function getDateModification()
    {
        return $this->date_modification;
    }

    /**
     * Set id
     *
     * @param integer $id
     *
     * @return Fiche
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
 

    /**
     * Set idCat
     *
     * @param integer $idCat
     *
     * @return Fiche
     */
    public function setIdCat($idCat)
    {
        $this->id_cat = $idCat;

        return $this;
    }

    /**
     * Get idCat
     *
     * @return integer
     */
    public function getIdCat()
    {
        return $this->id_cat;
    }

    /**
     * Set adresse
     *
     * @param \BackOfficeBundle\Entity\Adresse $adresse
     *
     * @return Fiche
     */
    public function setAdresse(\BackOfficeBundle\Entity\Adresse $adresse = null)
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * Get adresse
     *
     * @return \BackOfficeBundle\Entity\Adresse
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * Add image
     *
     * @param UploadedFile $image
     *
     * @return Fiche
     */
    public function addImage(UploadedFile $image)
    {
        $this->images[] = $image;

        return $this;
    }

    /**
     * Remove image
     *
     * @param \BackOfficeBundle\Entity\Image $image
     */
    public function removeImage(\BackOfficeBundle\Entity\Image $image)
    {
        var_dump($this->images);
        $this->images->removeElement($image);
    }

    /**
     * Get images
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * Add commentaire
     *
     * @param \BackOfficeBundle\Entity\Commentaire $commentaire
     *
     * @return Fiche
     */
    public function addCommentaire(\BackOfficeBundle\Entity\Commentaire $commentaire)
    {
        $this->commentaires[] = $commentaire;

        return $this;
    }

    /**
     * Remove commentaire
     *
     * @param \BackOfficeBundle\Entity\Commentaire $commentaire
     */
    public function removeCommentaire(\BackOfficeBundle\Entity\Commentaire $commentaire)
    {
        $this->commentaires->removeElement($commentaire);
    }

    /**
     * Get commentaires
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCommentaires()
    {
        return $this->commentaires;
    }

    /**
     * Add notification
     *
     * @param \BackOfficeBundle\Entity\Notification $notification
     *
     * @return Fiche
     */
    public function addNotification(\BackOfficeBundle\Entity\Notification $notification)
    {
        $this->notifications[] = $notification;

        return $this;
    }

    /**
     * Remove notification
     *
     * @param \BackOfficeBundle\Entity\Notification $notification
     */
    public function removeNotification(\BackOfficeBundle\Entity\Notification $notification)
    {
        $this->notifications->removeElement($notification);
    }

    /**
     * Get notifications
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getNotifications()
    {
        return $this->notifications;
    }
      //
    // Partie qui gère l'envoi d'image depuis le form
    //
 
    //private $image;
     
    private $tempFilename;
 
    public function getImage()
    {
        return $this->image;
    }
 
    public function setImage(UploadedFile $image)
    {
        $this->image = $image;
 
        if (null !== $this->url) {
            $this->tempFilename = $this->url;
 
            $this->url = null;
        }
    }
}
