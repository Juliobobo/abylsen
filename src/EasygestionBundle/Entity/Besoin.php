<?php

namespace EasygestionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\ArrayCollection;


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
     * @var \datetime
     *
     * @ORM\Column(name="date_creation", type="datetime")
     */
    private $dateCreation;

    /**
     * @var \datetime
     *
     * @ORM\Column(name="start", type="datetime")
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
     * @var Ia
     *
     * @Gedmo\Blameable(on="create")
     * @ORM\ManyToOne(targetEntity="Ia", inversedBy="besoins")
     */
    private $createdBy;
    
    /**
     * Many besoins have One client.
     * @ORM\ManyToOne(targetEntity="Client")
     * @ORM\JoinColumn(name="id_client", referencedColumnName="id")
     */
    private $client;
    
    /**
     * Besoin constructor.
     */
    public function __construct()
    {
        $this->dateCreation = new \DateTime();
        $this->archive = 0;
    }
    
     /**
     * Is the given Ia the owner of this need
     *
     * @param Ia $ia
     *
     * @return bool
     */
    public function isOwner(Ia $ia)
    {
        return $ia === $this->getCreatedby();
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
     * Set createdBy
     *
     * @param Ia $createdBy
     *
     * @return Besoin
     */
    public function setCreatedBy(Ia  $createdBy = null)
    {
        $this->createdBy = $createdBy;

        return $this;
    }
    
    /**
     * Get createdBy
     *
     * @return ia
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
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
