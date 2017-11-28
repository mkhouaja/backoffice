<?php
namespace BackOfficeBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
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
    private $images;

    public function __construct()
    {
        $this->images = new ArrayCollection();
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
     * @param \BackOfficeBundle\Entity\Image $image
     *
     * @return Fiche
     */
    public function addImage(\BackOfficeBundle\Entity\Image $image)
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
}
