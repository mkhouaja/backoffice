<?php
namespace BackOfficeBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="utilisateur")
 */
class Utilisateur
{

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id_utilisateur;
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
    private $pseudo;
    /**
     * @ORM\Column(type="string", length=1000)
     */
    private $id_device;
    /**
     * @ORM\Column(type="date")
     */
    private $date_ajout;
    /**
     * @ORM\Column(type="date")
     */
    private $date_modification;

    /**
     * Get idUtilisateur
     *
     * @return integer
     */
    public function getIdUtilisateur()
    {
        return $this->id_utilisateur;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Utilisateur
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
     * @return Utilisateur
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
     * Set idDevice
     *
     * @param string $idDevice
     *
     * @return Utilisateur
     */
    public function setIdDevice($idDevice)
    {
        $this->id_device = $idDevice;

        return $this;
    }

    /**
     * Get idDevice
     *
     * @return string
     */
    public function getIdDevice()
    {
        return $this->id_device;
    }

    /**
     * Set dateAjout
     *
     * @param \DateTime $dateAjout
     *
     * @return Utilisateur
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
     * @return Utilisateur
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
     * Set pseudo
     *
     * @param string $pseudo
     *
     * @return Utilisateur
     */
    public function setPseudo($pseudo)
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    /**
     * Get pseudo
     *
     * @return string
     */
    public function getPseudo()
    {
        return $this->pseudo;
    }
}
