<?php
namespace BackOfficeBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
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
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\Column(type="integer")
     */
    private $id_cat;

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
}
