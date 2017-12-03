<?php
namespace BackOfficeBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="categorie")
 */
class Categorie
{

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id_cat;
     /**
     * @ORM\Column(type="string", length=100)
     */
    private $nom;
    /**
     * @ORM\Column(type="date")
     */
    private $date_ajout;
    /**
     * @ORM\Column(type="date")
     */
    private $date_modification;

    /**
     * Get idCat
     *
     * @return integer
     */
    public function getIdCat()
    {
        return $this->id_cat;
    }
    
    
    public function __construct()
    {
        //$this->fiches = new ArrayCollection();
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return Categorie
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
     * Set dateAjout
     *
     * @param \DateTime $dateAjout
     *
     * @return Categorie
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
     * @return Categorie
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
     * Add fich
     *
     * @param \BackOfficeBundle\Entity\Fiche $fich
     *
     * @return Categorie
     */
    public function addFich(\BackOfficeBundle\Entity\Fiche $fich)
    {
        $this->fiches[] = $fich;

        return $this;
    }

    /**
     * Remove fich
     *
     * @param \BackOfficeBundle\Entity\Fiche $fich
     */
    public function removeFich(\BackOfficeBundle\Entity\Fiche $fich)
    {
        $this->fiches->removeElement($fich);
    }

    /**
     * Get fiches
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFiches()
    {
        return $this->fiches;
    }
}
