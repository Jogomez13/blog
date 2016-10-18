<?php

namespace AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Etatpublication
 *
 * @ORM\Table(name="etatpublication")
 * @ORM\Entity(repositoryClass="AdminBundle\Repository\EtatpublicationRepository")
 */
class Etatpublication
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
     * @var string
     *
     * @ORM\Column(name="publie", type="string", length=255)
     */
    private $publie;

    /**
     * @var string
     *
     * @ORM\Column(name="brouillon", type="string", length=255)
     */
    private $brouillon;


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
     * Set publie
     *
     * @param string $publie
     *
     * @return Etatpublication
     */
    public function setPublie($publie)
    {
        $this->publie = $publie;

        return $this;
    }

    /**
     * Get publie
     *
     * @return string
     */
    public function getPublie()
    {
        return $this->publie;
    }

    /**
     * Set brouillon
     *
     * @param string $brouillon
     *
     * @return Etatpublication
     */
    public function setBrouillon($brouillon)
    {
        $this->brouillon = $brouillon;

        return $this;
    }

    /**
     * Get brouillon
     *
     * @return string
     */
    public function getBrouillon()
    {
        return $this->brouillon;
    }
}

