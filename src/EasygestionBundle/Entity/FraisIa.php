<?php

namespace EasygestionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * FraisIa
 *
 * @ORM\Table(name="frais_ia")
 * @ORM\Entity(repositoryClass="EasygestionBundle\Repository\FraisIaRepository")
 */
class FraisIa
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="fraisFixe", type="integer")
     */
    private $fraisFixe;

    /**
     * @var string
     *
     * @ORM\Column(name="frais", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $frais;
    
    /**
     * @var int
     *
     * @ORM\Column(name="mois", type="integer", unique=true)
     */
    private $mois;
    
    /**
     * Frais constructor.
     */
    public function __construct()
    {
        $this->fraisFixe = 300;
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set fraisFixe
     *
     * @param integer $fraisFixe
     *
     * @return FraisIa
     */
    public function setFraisFixe($fraisFixe)
    {
        $this->fraisFixe = $fraisFixe;

        return $this;
    }

    /**
     * Get fraisFixe
     *
     * @return int
     */
    public function getFraisFixe()
    {
        return $this->fraisFixe;
    }

    /**
     * Set frais
     *
     * @param string $frais
     *
     * @return FraisIa
     */
    public function setFrais($frais)
    {
        $this->frais = $frais;

        return $this;
    }

    /**
     * Get frais
     *
     * @return string
     */
    public function getFrais()
    {
        return $this->frais;
    }
    
    /**
     * Get frais totaux
     *
     * @return string
     */
    public function getFraisTotaux()
    {
        return $this->frais + $this->fraisFixe;
    }
    
    /**
     * Set mois
     *
     * @param integer $mois
     *
     * @return FraisIa
     */
    public function setMois($mois)
    {
        $this->mois = $mois;

        return $this;
    }

    /**
     * Get mois
     *
     * @return integer
     */
    public function getMois()
    {
        return $this->mois;
    }
}
