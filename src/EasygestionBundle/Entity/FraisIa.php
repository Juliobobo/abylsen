<?php

namespace EasygestionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     *
     * @ORM\OneToOne(targetEntity="ConsultantInformations", cascade={"persist"})
     */
    private $infos;
    
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
        return $this->frais + $this->fraisFixe;
    }

    /**
     * Set infos
     *
     * @param \EasygestionBundle\Entity\ConsultantInformations $infos
     *
     * @return FraisIa
     */
    public function setInfos(\EasygestionBundle\Entity\ConsultantInformations $infos = null)
    {
        $this->infos = $infos;

        return $this;
    }

    /**
     * Get infos
     *
     * @return \EasygestionBundle\Entity\ConsultantInformations
     */
    public function getInfos()
    {
        return $this->infos;
    }
}
