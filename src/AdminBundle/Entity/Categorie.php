<?php

namespace AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Categorie
 *
 * @ORM\Table(name="categorie")
 * @ORM\Entity(repositoryClass="AdminBundle\Repository\CategorieRepository")
 */
class Categorie
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
     * @ORM\Column(name="ordinateur", type="string", length=255)
     */
    private $ordinateur;

    /**
     * @var string
     *
     * @ORM\Column(name="tablette", type="string", length=255)
     */
    private $tablette;

    /**
     * @var string
     *
     * @ORM\Column(name="telephone", type="string", length=255)
     */
    private $telephone;


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
     * Set ordinateur
     *
     * @param string $ordinateur
     *
     * @return Categorie
     */
    public function setOrdinateur($ordinateur)
    {
        $this->ordinateur = $ordinateur;

        return $this;
    }

    /**
     * Get ordinateur
     *
     * @return string
     */
    public function getOrdinateur()
    {
        return $this->ordinateur;
    }

    /**
     * Set tablette
     *
     * @param string $tablette
     *
     * @return Categorie
     */
    public function setTablette($tablette)
    {
        $this->tablette = $tablette;

        return $this;
    }

    /**
     * Get tablette
     *
     * @return string
     */
    public function getTablette()
    {
        return $this->tablette;
    }

    /**
     * Set telephone
     *
     * @param string $telephone
     *
     * @return Categorie
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;

        return $this;
    }

    /**
     * Get telephone
     *
     * @return string
     */
    public function getTelephone()
    {
        return $this->telephone;
    }
}

