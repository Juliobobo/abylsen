<?php

namespace EasygestionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use EasygestionBundle\Entity;

/**
 * Besoin
 *
 * @ORM\Table(name="besoin")
 * @ORM\Entity(repositoryClass="EasygestionBundle\Repository\BesoinRepository")
 */
class Besoin
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
     * @ORM\Column(name="id_ia", type="integer")
     */
    private $idIa;

    /**
     * @var int
     *
     * @ORM\Column(name="id_client", type="integer")
     */
    private $idClient;

    /**
     * @var int
     *
     * @ORM\Column(name="status", type="integer")
     */
    private $status;

    /**
     * @var int
     *
     * @ORM\Column(name="priority", type="integer")
     */
    private $priority;

    /**
     * @var \Date
     *
     * @ORM\Column(name="date_creation", type="date")
     */
    private $dateCreation;

    /**
     * @var \Date
     *
     * @ORM\Column(name="start", type="date")
     */
    private $start;

    /**
     * @var int
     *
     * @ORM\Column(name="duration", type="integer")
     */
    private $duration;
    
    /**
     * @var string
     *
     * @ORM\Column(name="solution", type="string", length=255, nullable=true)
     */
    private $solution;
    
    /**
     * @var int
     *
     * @ORM\Column(name="archive", type="integer")
     */
    private $archive;
    
    /**
     * Many besoins have One ia.
     * @ORM\ManyToOne(targetEntity="Ia")
     * @ORM\JoinColumn(name="id_ia", referencedColumnName="id")
     */
    private $ia;
    
    /**
     * Many besoins have One client.
     * @ORM\ManyToOne(targetEntity="Client")
     * @ORM\JoinColumn(name="id_client", referencedColumnName="id")
     */
    private $client;

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
     * Set idIa
     *
     * @param integer $idIa
     *
     * @return Besoin
     */
    public function setIdIa($idIa)
    {
        $this->idIa = $idIa;

        return $this;
    }

    /**
     * Get idIa
     *
     * @return int
     */
    public function getIdIa()
    {
        return $this->idIa;
    }

    /**
     * Set idClient
     *
     * @param integer $idClient
     *
     * @return Besoin
     */
    public function setIdClient($idClient)
    {
        $this->idClient = $idClient;

        return $this;
    }

    /**
     * Get idClient
     *
     * @return int
     */
    public function getIdClient()
    {
        return $this->idClient;
    }

    /**
     * Set status
     *
     * @param integer $status
     *
     * @return Besoin
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set priority
     *
     * @param integer $priority
     *
     * @return Besoin
     */
    public function setPriority($priority)
    {
        $this->priority = $priority;

        return $this;
    }

    /**
     * Get priority
     *
     * @return int
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * Set dateCreation
     *
     * @param \DateTime $dateCreation
     *
     * @return Besoin
     */
    public function setDateCreation($dateCreation)
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    /**
     * Get dateCreation
     *
     * @return \DateTime
     */
    public function getDateCreation()
    {
        return $this->dateCreation;
    }

    /**
     * Set start
     *
     * @param \DateTime $start
     *
     * @return Besoin
     */
    public function setStart($start)
    {
        $this->start = $start;

        return $this;
    }

    /**
     * Get start
     *
     * @return \DateTime
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * Set duration
     *
     * @param \DateTime $duration
     *
     * @return Besoin
     */
    public function setDuration($duration)
    {
        $this->duration = $duration;

        return $this;
    }

    /**
     * Get duration
     *
     * @return \DateTime
     */
    public function getDuration()
    {
        return $this->duration;
    }
    
    /**
     * Set ia
     *
     * @param client $ia
     *
     * @return Besoin
     */
    public function setIa(Ia  $ia)
    {
        $this->ia = $ia;

        return $this;
    }
    
    /**
     * Get ia
     *
     * @return ia
     */
    public function getIa()
    {
        return $this->ia;
    }
    /**
     * Set client
     *
     * @param client $client
     *
     * @return Besoin
     */
    public function setClient(Client  $client)
    {
        $this->client = $client;

        return $this;
    }
    
    /**
     * Get client
     *
     * @return client
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Set archive
     *
     * @param integer $archive
     *
     * @return Besoin
     */
    public function setArchive($archive)
    {
        $this->archive = $archive;

        return $this;
    }

    /**
     * Get archive
     *
     * @return integer
     */
    public function getArchive()
    {
        return $this->archive;
    }

    /**
     * Set solution
     *
     * @param string $solution
     *
     * @return Besoin
     */
    public function setSolution($solution)
    {
        $this->solution = $solution;

        return $this;
    }

    /**
     * Get solution
     *
     * @return string
     */
    public function getSolution()
    {
        return $this->solution;
    }
}
