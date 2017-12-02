<?php
namespace BackOfficeBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity
 * @ORM\Table(name="image")
 */
class Image
{

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id_image;
     /**
     * @ORM\Column(type="string", length=100)
     */
    private $nom;
	/**
     * @ORM\Column(type="string", length=300)
     */
    private $chemin;
	/**
     * @ORM\Column(type="string", length=300)
     */
    private $taille;
    /**
     * @ORM\Column(type="date")
     */
    private $date_ajout;
    /**
     * @ORM\Column(type="date")
     */
    private $date_modification;
    /**
     * @ORM\ManyToOne(targetEntity="Fiche", inversedBy="images")
     * @ORM\JoinColumn(name="id_fiche", referencedColumnName="id_fiche")
     */
    private $id_fiche;

    /**
     * Get idImage
     *
     * @return integer
     */
    public function getIdImage()
    {
        return $this->id_image;
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return Image
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
     * Set chemin
     *
     * @param string $chemin
     *
     * @return Image
     */
    public function setChemin($chemin)
    {
        $this->chemin = $chemin;

        return $this;
    }

    /**
     * Get chemin
     *
     * @return string
     */
    public function getChemin()
    {
        return $this->chemin;
    }

    /**
     * Set taille
     *
     * @param string $taille
     *
     * @return Image
     */
    public function setTaille($taille)
    {
        $this->taille = $taille;

        return $this;
    }

    /**
     * Get taille
     *
     * @return string
     */
    public function getTaille()
    {
        return $this->taille;
    }

    /**
     * Set dateAjout
     *
     * @param \DateTime $dateAjout
     *
     * @return Image
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
     * @return Image
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
     * Set idFiche
     *
     * @param integer $idFiche
     *
     * @return Image
     */
    public function setIdFiche($idFiche)
    {
        $this->id_fiche = $idFiche;

        return $this;
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
}
