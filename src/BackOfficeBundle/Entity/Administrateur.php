<?php
namespace BackOfficeBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="administrateur")
 */
class Administrateur
{

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @ORM\Column(type="string", length=100)
     */
    private $email;
     /**
     * @ORM\Column(type="string", length=100)
     */
    private $mot_de_passe;
     /**
     * @ORM\Column(type="string", length=100)
     */
    private $nom;
     /**
     * @ORM\Column(type="string", length=100)
     */
    private $prenom;
    /**
     * @ORM\Column(type="date")
     */
    private $date_ajout;
    /**
     * @ORM\Column(type="date")
     */
    private $date_modification;
    /**
     * @ORM\OneToMany(targetEntity="Fiche", mappedBy="id")
     */
    private $fiches;
     /**
     * @ORM\OneToMany(targetEntity="Notification", mappedBy="id")
     */
    private $notifications;

    public function __construct()
    {
        $this->fiches = new ArrayCollection();
        $this->notifications = new ArrayCollection();
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
     * Set email
     *
     * @param string $email
     *
     * @return Administrateur
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set motDePasse
     *
     * @param string $motDePasse
     *
     * @return Administrateur
     */
    public function setMotDePasse($motDePasse)
    {
        $this->mot_de_passe = $motDePasse;

        return $this;
    }

    /**
     * Get motDePasse
     *
     * @return string
     */
    public function getMotDePasse()
    {
        return $this->mot_de_passe;
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return Administrateur
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
     * Set prenom
     *
     * @param string $prenom
     *
     * @return Administrateur
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set dateAjout
     *
     * @param \DateTime $dateAjout
     *
     * @return Administrateur
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
     * @return Administrateur
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
     * @return Administrateur
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

    /**
     * Add notification
     *
     * @param \BackOfficeBundle\Entity\Notification $notification
     *
     * @return Administrateur
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
}
