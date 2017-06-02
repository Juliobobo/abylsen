<?php

namespace EasygestionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Solution
 *
 * @ORM\Table(name="solution")
 * @ORM\Entity(repositoryClass="EasygestionBundle\Repository\SolutionRepository")
 */
class Solution
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
     * @ORM\Column(name="id_type", type="integer")
     */
    private $idType;

    /**
     * @var string
     *
     * @ORM\Column(name="lastname", type="string", length=100)
     */
    private $lastname;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=100)
     */
    private $name;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="availability", type="datetime")
     */
    private $availability;

    /**
     * @var string
     *
     * @ORM\Column(name="mobility", type="string", length=100)
     */
    private $mobility;

    /**
     * @var float
     *
     * @ORM\Column(name="pay", type="float")
     */
    private $pay;


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
     * Set idType
     *
     * @param integer $idType
     *
     * @return Solution
     */
    public function setIdType($idType)
    {
        $this->idType = $idType;

        return $this;
    }

    /**
     * Get idType
     *
     * @return int
     */
    public function getIdType()
    {
        return $this->idType;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     *
     * @return Solution
     */
    public function setNom($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname
     *
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Solution
     */
    public function setPrenom($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set availability
     *
     * @param \DateTime $availability
     *
     * @return Solution
     */
    public function setAvailability($availability)
    {
        $this->availability = $availability;

        return $this;
    }

    /**
     * Get availability
     *
     * @return \DateTime
     */
    public function getAvailability()
    {
        return $this->availability;
    }

    /**
     * Set mobility
     *
     * @param string $mobility
     *
     * @return Solution
     */
    public function setMobility($mobility)
    {
        $this->mobility = $mobility;

        return $this;
    }

    /**
     * Get mobility
     *
     * @return string
     */
    public function getMobility()
    {
        return $this->mobility;
    }

    /**
     * Set pay
     *
     * @param float $pay
     *
     * @return Solution
     */
    public function setPay($pay)
    {
        $this->pay = $pay;

        return $this;
    }

    /**
     * Get pay
     *
     * @return float
     */
    public function getPay()
    {
        return $this->pay;
    }
}

