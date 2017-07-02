<?php

namespace EasygestionBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Ia
 *
 * @ORM\Table(name="ia")
 * @ORM\Entity(repositoryClass="EasygestionBundle\Repository\IaRepository")
 */
class Ia extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="initials", type="string", length=3, nullable=true)
     */
    private $initials;
    
    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Besoin", mappedBy="createdBy")
     */
    protected $besoins;
    
    /**
     * Ia constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->besoins = new ArrayCollection();
    }
        
    /**
     * Set initials
     *
     * @param string $initials
     *
     * @return Ia
     */
    public function setInitials($initials)
    {
        $this->initials = $initials;

        return $this;
    }

    /**
     * Get initials
     *
     * @return string
     */
    public function getInitials()
    {
        return $this->initials;
    }
    
    /**
     * Add besoin.
     *
     * @param Besoin $besoin
     *
     * @return $this
     */
    public function addBesoin(Besoin $besoin)
    {
        $this->besoins[] = $besoin;

        return $this;
    }

    /**
     * Remove besoin.
     *
     * @param Besoin $besoin
     *
     * @return $this
     */
    public function removePost(Besoin $besoin)
    {
        $this->besoins->removeElement($besoin);

        return $this;
    }

    /**
     * Get besoins.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getBesoins()
    {
        return $this->besoins;
    }
    
}

