<?php

namespace EasygestionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ConsultantInformations
 *
 * @ORM\Table(name="consultant_informations")
 * @ORM\Entity(repositoryClass="EasygestionBundle\Repository\ConsultantInformationsRepository")
 */
class ConsultantInformations
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
     * Many infos have One consultant.
     * 
     * @ORM\ManyToOne(targetEntity="Consultant")
     * @ORM\JoinColumn(nullable=false)
     */
    private $consultant;
    
    /**
     *
     * @ORM\OneToOne(targetEntity="Besoin", cascade={"persist"})
     */
    private $besoin;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datePrevisionnelle", type="datetime")
     */
    private $datePrevisionnelle;

    /**
     * @var string
     *
     * @ORM\Column(name="tjm", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $tjm;

    /**
     * @var string
     *
     * @ORM\Column(name="nbFact", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $nbFact;

    /**
     * @var string
     *
     * @ORM\Column(name="inter", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $inter;

    /**
     * @var int
     *
     * @ORM\Column(name="absNr", type="integer", nullable=true)
     */
    private $absNr;

    /**
     * @var int
     *
     * @ORM\Column(name="salaire", type="integer")
     */
    private $salaire;

    /**
     * @var string
     *
     * @ORM\Column(name="fraisJour", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $fraisJour;

    /**
     * @var string
     *
     * @ORM\Column(name="fraisOne", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $fraisOne;

    /**
     * @var string
     *
     * @ORM\Column(name="fraisTwo", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $fraisTwo;

    /**
     * @var int
     *
     * @ORM\Column(name="primeBrute", type="integer", nullable=true)
     */
    private $primeBrute;

    /**
     * @var int
     *
     * @ORM\Column(name="mois", type="integer")
     */
    private $mois;
    
    /**
     * @var int
     *
     * @ORM\Column(name="annee", type="integer")
     */
    private $annee;
    
    /**
     * @var string
     *
     * @ORM\Column(name="valeur", type="decimal", precision=10, scale=2)
     */
    private $valeur;
    
    /**
     * info constructor.
     */
    public function __construct()
    {
        $this->annee = (int) date("Y");
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
     * Set datePrevisionnelle
     *
     * @param \DateTime $datePrevisionnelle
     *
     * @return ConsultantInformations
     */
    public function setDatePrevisionnelle($datePrevisionnelle)
    {
        $this->datePrevisionnelle = $datePrevisionnelle;

        return $this;
    }

    /**
     * Get datePrevisionnelle
     *
     * @return \DateTime
     */
    public function getDatePrevisionnelle()
    {
        return $this->datePrevisionnelle;
    }

    /**
     * Set tjm
     *
     * @param string $tjm
     *
     * @return ConsultantInformations
     */
    public function setTjm($tjm)
    {
        $this->tjm = $tjm;

        return $this;
    }

    /**
     * Get tjm
     *
     * @return string
     */
    public function getTjm()
    {
        return $this->tjm;
    }

    /**
     * Set nbFact
     *
     * @param string $nbFact
     *
     * @return ConsultantInformations
     */
    public function setNbFact($nbFact)
    {
        $this->nbFact = $nbFact;

        return $this;
    }

    /**
     * Get nbFact
     *
     * @return string
     */
    public function getNbFact()
    {
        return $this->nbFact;
    }

    /**
     * Set inter
     *
     * @param string $inter
     *
     * @return ConsultantInformations
     */
    public function setInter($inter)
    {
        $this->inter = $inter;

        return $this;
    }

    /**
     * Get inter
     *
     * @return string
     */
    public function getInter()
    {
        return $this->inter;
    }

    /**
     * Set absNr
     *
     * @param integer $absNr
     *
     * @return ConsultantInformations
     */
    public function setAbsNr($absNr)
    {
        $this->absNr = $absNr;

        return $this;
    }

    /**
     * Get absNr
     *
     * @return int
     */
    public function getAbsNr()
    {
        return $this->absNr;
    }

    /**
     * Set salaire
     *
     * @param integer $salaire
     *
     * @return ConsultantInformations
     */
    public function setSalaire($salaire)
    {
        $this->salaire = $salaire;

        return $this;
    }

    /**
     * Get salaire
     *
     * @return int
     */
    public function getSalaire()
    {
        return $this->salaire;
    }

    /**
     * Set fraisJour
     *
     * @param string $fraisJour
     *
     * @return ConsultantInformations
     */
    public function setFraisJour($fraisJour)
    {
        $this->fraisJour = $fraisJour;

        return $this;
    }

    /**
     * Get fraisJour
     *
     * @return string
     */
    public function getFraisJour()
    {
        return $this->fraisJour;
    }

    /**
     * Set fraisOne
     *
     * @param string $fraisOne
     *
     * @return ConsultantInformations
     */
    public function setFraisOne($fraisOne)
    {
        $this->fraisOne = $fraisOne;

        return $this;
    }

    /**
     * Get fraisOne
     *
     * @return string
     */
    public function getFraisOne()
    {
        return $this->fraisOne;
    }

    /**
     * Set fraisTwo
     *
     * @param string $fraisTwo
     *
     * @return ConsultantInformations
     */
    public function setFraisTwo($fraisTwo)
    {
        $this->fraisTwo = $fraisTwo;

        return $this;
    }

    /**
     * Get fraisTwo
     *
     * @return string
     */
    public function getFraisTwo()
    {
        return $this->fraisTwo;
    }

    /**
     * Set primeBrute
     *
     * @param integer $primeBrute
     *
     * @return ConsultantInformations
     */
    public function setPrimeBrute($primeBrute)
    {
        $this->primeBrute = $primeBrute;

        return $this;
    }

    /**
     * Get primeBrute
     *
     * @return int
     */
    public function getPrimeBrute()
    {
        return $this->primeBrute;
    }

    /**
     * Set mois
     *
     * @param \DateTime $mois
     *
     * @return ConsultantInformations
     */
    public function setMois($mois)
    {
        $this->mois = $mois;

        return $this;
    }

    /**
     * Get mois
     *
     * @return \DateTime
     */
    public function getMois()
    {
        return $this->mois;
    }

    /**
     * Set consultant
     *
     * @param \EasygestionBundle\Entity\Consultant $consultant
     *
     * @return ConsultantInformations
     */
    public function setConsultant(\EasygestionBundle\Entity\Consultant $consultant)
    {
        $this->consultant = $consultant;

        return $this;
    }

    /**
     * Get consultant
     *
     * @return \EasygestionBundle\Entity\Consultant
     */
    public function getConsultant()
    {
        return $this->consultant;
    }

    /**
     * Set besoin
     *
     * @param \EasygestionBundle\Entity\Besoin $besoin
     *
     * @return ConsultantInformations
     */
    public function setBesoin(\EasygestionBundle\Entity\Besoin $besoin = null)
    {
        $this->besoin = $besoin;

        return $this;
    }

    /**
     * Get besoin
     *
     * @return \EasygestionBundle\Entity\Besoin
     */
    public function getBesoin()
    {
        return $this->besoin;
    }
    
    /**
     * Set valeur
     *
     * @param string $valeur
     *
     * @return ConsultantInformations
     */
    public function setValeur($valeur)
    {
        $this->valeur = $valeur;

        return $this;
    }

    /**
     * Get valeur
     *
     * @return string
     */
    public function getValeur()
    {
        return $this->valeur;
    }
          
    /**
     * Get CA produit
     *
     * @return string
     */
    public function getCa()
    {
        $ca = 0;
        
        if($this->tjm == 0){
            return 0;
        }else{
            return $ca = $this->nbFact * $this->tjm;
        }
    }
    
    /**
     * Get Marge
     *
     * @return string
     */
    public function getMarge()
    {
        return (
       ($this->nbFact * $this->tjm) 
                    - (((($this->salaire * 2.02) / 218)*($this->nbFact + $this->inter + $this->absNr))
                    + ($this->fraisJour * ($this->nbFact + $this->inter)) 
                    + $this->fraisOne + $this->fraisTwo) * $this->valeur
                    - 2 * $this->valeur * $this->primeBrute
                );
    }
    
    /**
     * Get Marge
     *
     * @return string
     */
    public function getPmarge()
    {
        return (
        number_format(($this->getMarge() / $this->getCa()) * 100, 0));
    }

    /**
     * Set annee
     *
     * @param integer $annee
     *
     * @return ConsultantInformations
     */
    public function setAnnee($annee)
    {
        $this->annee = $annee;

        return $this;
    }

    /**
     * Get annee
     *
     * @return integer
     */
    public function getAnnee()
    {
        return $this->annee;
    }

    /**
     * Set frais
     *
     * @param \EasygestionBundle\Entity\FraisIa $frais
     *
     * @return ConsultantInformations
     */
    public function setFrais(\EasygestionBundle\Entity\FraisIa $frais = null)
    {
        $this->Frais = $frais;

        return $this;
    }

    /**
     * Get frais
     *
     * @return \EasygestionBundle\Entity\FraisIa
     */
    public function getFrais()
    {
        return $this->Frais;
    }
}
