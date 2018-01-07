<?php
namespace BackOfficeBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="adresse")
 */
class Adresse
{

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id_adresse;
      /**
     * @ORM\Column(type="integer")
     */
    private $numero;
     /**
     * @ORM\Column(type="string", length=150)
     */
    private $rue;
      /**
     * @ORM\Column(type="integer")
     */
    private $code_postal;
     /**
     * @ORM\Column(type="string", length=150)
     */
    private $ville;
     /**
     * @ORM\Column(type="string", length=150)
     */
    private $pays;
     /**
     * @ORM\Column(type="string", length=150)
     */
    private $langitude;
     /**
     * @ORM\Column(type="string", length=150)
     */
    private $latitude;

    /**
     * Get idAdresse
     *
     * @return integer
     */
    public function getIdAdresse()
    {
        return $this->id_adresse;
    }

    /**
     * Set numero
     *
     * @param integer $numero
     *
     * @return Adresse
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;

        return $this;
    }

    /**
     * Get numero
     *
     * @return integer
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * Set rue
     *
     * @param string $rue
     *
     * @return Adresse
     */
    public function setRue($rue)
    {
        $this->rue = $rue;

        return $this;
    }

    /**
     * Get rue
     *
     * @return string
     */
    public function getRue()
    {
        return $this->rue;
    }

    /**
     * Set codePostal
     *
     * @param integer $codePostal
     *
     * @return Adresse
     */
    public function setCodePostal($codePostal)
    {
        $this->code_postal = $codePostal;

        return $this;
    }

    /**
     * Get codePostal
     *
     * @return integer
     */
    public function getCodePostal()
    {
        return $this->code_postal;
    }

    /**
     * Set ville
     *
     * @param string $ville
     *
     * @return Adresse
     */
    public function setVille($ville)
    {
        $this->ville = $ville;

        return $this;
    }

    /**
     * Get ville
     *
     * @return string
     */
    public function getVille()
    {
        return $this->ville;
    }

    /**
     * Set pays
     *
     * @param string $pays
     *
     * @return Adresse
     */
    public function setPays($pays)
    {
        $this->pays = $pays;

        return $this;
    }

    /**
     * Get pays
     *
     * @return string
     */
    public function getPays()
    {
        return $this->pays;
    }

    /**
     * Set langitude
     *
     * @param string $langitude
     *
     * @return Adresse
     */
    public function setLangitude($langitude)
    {
        $this->langitude = $langitude;

        return $this;
    }

    /**
     * Get langitude
     *
     * @return string
     */
    public function getLangitude()
    {
        return $this->langitude;
    }

    /**
     * Set latitude
     *
     * @param string $latitude
     *
     * @return Adresse
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * Get latitude
     *
     * @return string
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set idFiche
     *
     * @param integer $idFiche
     *
     * @return Adresse
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
