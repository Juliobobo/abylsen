<?php

namespace EasygestionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Proposition
 *
 * @ORM\Table(name="proposition")
 * @ORM\Entity(repositoryClass="EasygestionBundle\Repository\PropositionRepository")
 */
class Proposition
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
     * @var float
     *
     * @ORM\Column(name="id_besoin", type="float", unique=true)
     */
    private $idBesoin;

    /**
     * @var float
     *
     * @ORM\Column(name="id_solution", type="float", unique=true)
     */
    private $idSolution;


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
     * Set idBesoin
     *
     * @param float $idBesoin
     *
     * @return Proposition
     */
    public function setIdBesoin($idBesoin)
    {
        $this->idBesoin = $idBesoin;

        return $this;
    }

    /**
     * Get idBesoin
     *
     * @return float
     */
    public function getIdBesoin()
    {
        return $this->idBesoin;
    }

    /**
     * Set idSolution
     *
     * @param float $idSolution
     *
     * @return Proposition
     */
    public function setIdSolution($idSolution)
    {
        $this->idSolution = $idSolution;

        return $this;
    }

    /**
     * Get idSolution
     *
     * @return float
     */
    public function getIdSolution()
    {
        return $this->idSolution;
    }
}

