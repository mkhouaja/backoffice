<?php
namespace BackOfficeBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="note")
 */
class Note
{

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id_note;
    /**
     * @ORM\Column(type="integer")
     */
    private $note;
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
    private $id_utilisateur;
	/**
     * @ORM\Column(type="integer")
     */
    private $id_fiche;

    /**
     * Get idNote
     *
     * @return integer
     */
    public function getIdNote()
    {
        return $this->id_note;
    }

    /**
     * Set note
     *
     * @param integer $note
     *
     * @return Note
     */
    public function setNote($note)
    {
        $this->note = $note;

        return $this;
    }

    /**
     * Get note
     *
     * @return integer
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * Set dateAjout
     *
     * @param \DateTime $dateAjout
     *
     * @return Note
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
     * @return Note
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
     * Set idUtilisateur
     *
     * @param integer $idUtilisateur
     *
     * @return Note
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

    /**
     * Set idFiche
     *
     * @param integer $idFiche
     *
     * @return Note
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
