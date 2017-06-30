<?php

namespace EasygestionBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

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
    
    public function __construct()
    {
        parent::__construct();
        // your own logic
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
}

