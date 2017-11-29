<?php
namespace BackOfficeBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="notification")
 */
class Notification
{

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id_notif;
    /**
     * @ORM\Column(type="string", length=150)
     */
    private $titre;
	/**
     * @ORM\Column(type="string", length=150)
     */
    private $texte;
    /**
     * @ORM\Column(type="date")
     */
    private $date_ajout;
    /**
     * @ORM\Column(type="date")
     */
    private $date_modification;
	/**
     * @ORM\Column(type="date", nullable=true)
     */
    private $date_envoi;
	 /**
     * @ORM\ManyToOne(targetEntity="Administrateur", inversedBy="notifications")
     * @ORM\JoinColumn(name="id", referencedColumnName="id")
     */
    private $id;
    /**
     * @ORM\ManyToOne(targetEntity="Fiche", inversedBy="notifications")
     * @ORM\JoinColumn(name="id_fiche", referencedColumnName="id_fiche")
     */
    private $id_fiche;

    /**
     * Get idNotif
     *
     * @return integer
     */
    public function getIdNotif()
    {
        return $this->id_notif;
    }

    /**
     * Set titre
     *
     * @param integer $titre
     *
     * @return Notification
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre
     *
     * @return integer
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set texte
     *
     * @param integer $texte
     *
     * @return Notification
     */
    public function setTexte($texte)
    {
        $this->texte = $texte;

        return $this;
    }

    /**
     * Get texte
     *
     * @return integer
     */
    public function getTexte()
    {
        return $this->texte;
    }

    /**
     * Set dateAjout
     *
     * @param \DateTime $dateAjout
     *
     * @return Notification
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
     * @return Notification
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
     * Set dateEnvoi
     *
     * @param \DateTime $dateEnvoi
     *
     * @return Notification
     */
    public function setDateEnvoi($dateEnvoi)
    {
        $this->date_envoi = $dateEnvoi;

        return $this;
    }

    /**
     * Get dateEnvoi
     *
     * @return \DateTime
     */
    public function getDateEnvoi()
    {
        return $this->date_envoi;
    }

    /**
     * Set id
     *
     * @param integer $id
     *
     * @return Notification
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
     * Set idFiche
     *
     * @param \BackOfficeBundle\Entity\Fiche $idFiche
     *
     * @return Notification
     */
    public function setIdFiche(\BackOfficeBundle\Entity\Fiche $idFiche = null)
    {
        $this->id_fiche = $idFiche;

        return $this;
    }

    /**
     * Get idFiche
     *
     * @return \BackOfficeBundle\Entity\Fiche
     */
    public function getIdFiche()
    {
        return $this->id_fiche;
    }
}
