<?php
namespace BackOfficeBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="commentaire")
 */
class Commentaire
{

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id_com;
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
     * @ORM\Column(type="integer")
     */
    private $id_fiche;
    /**
     * @ORM\Column(type="integer")
     */
    private $id_utilisateur;

    /**
     * Get idCom
     *
     * @return integer
     */
    public function getIdCom()
    {
        return $this->id_com;
    }

    /**
     * Set texte
     *
     * @param string $texte
     *
     * @return Commentaire
     */
    public function setTexte($texte)
    {
        $this->texte = $texte;

        return $this;
    }

    /**
     * Get texte
     *
     * @return string
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
     * @return Commentaire
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
     * @return Commentaire
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
     * @return Commentaire
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

    /**
     * Set idUtilisateur
     *
     * @param integer $idUtilisateur
     *
     * @return Commentaire
     */
    public function setIdUtilisateur($idUtilisateur)
    {
        $this->id_utilisateur = $idUtilisateur;

        return $this;
    }

    /**
     * Get idUtilisateur
     *
     * @return integer
     */
    public function getIdUtilisateur()
    {
        return $this->id_utilisateur;
    }
}
