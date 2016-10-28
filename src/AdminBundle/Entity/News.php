<?php

namespace AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * News
 *
 * @ORM\Table(name="news")
 * @ORM\Entity(repositoryClass="AdminBundle\Repository\NewsRepository")
 */
class News
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
     * @ORM\Column(name="titre", type="string", length=255)
     */
    private $titre;

    /**
     *
     *@ORM\Column(name="image", type="string", length=600)
     * @Assert\File()
     */
    private $image;
    
    /**
     * @var string
     *
     * @ORM\Column(name="article", type="string", length=600)
     */
    private $article;

    /**
     *
     * @ORM\ManyToOne(targetEntity="AdminBundle\Entity\Categorie")
     * @ORM\JoinColumn(name="categorie_id", referencedColumnName="id")
     *
     */
    private $categorie;

    /**
     *@var datetime
     * 
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="auteur", type="string", length=255)
     */
    private $auteur;

    /**
     * @ORM\ManyToOne(targetEntity="AdminBundle\Entity\Etatpublication")
     * @ORM\JoinColumn(name="etatpublication_id", referencedColumnName="id")
     */
    private $etatpublication;


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
     * Set titre
     *
     * @param string $titre
     *
     * @return News
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre
     *
     * @return string
     */
    public function getTitre()
    {
        return $this->titre;
    }
    
    /**
     * Set image
     *
     * @param UploadedFile $image
     *
     * @return News
     */
    function setImage($uploadedFile) {
        $this->image = $uploadedFile ;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }
    
    /**
     * Set article
     *
     * @param string $article
     *
     * @return News
     */
    public function setArticle($article)
    {
        $this->article = $article;

        return $this;
    }
    
     /**
     * Get article
     *
     * @return string
     */
    public function getArticle()
    {
        return $this->article;
    }

    /**
     * Set categorie
     *
     * @param string $categorie
     *
     * @return News
     */
    public function setCategorie($categorie)
    {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * Get categorie
     *
     * @return string
     */
    public function getCategorie()
    {
        return $this->categorie;
    }

    /**
     * Set date
     *
     * @param string $date
     *
     * @return News
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return string
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set auteur
     *
     * @param string $auteur
     *
     * @return News
     */
    public function setAuteur($auteur)
    {
        $this->auteur = $auteur;

        return $this;
    }

    /**
     * Get auteur
     *
     * @return string
     */
    public function getAuteur()
    {
        return $this->auteur;
    }

    /**
     * Set etatpublication
     *
     * @param string $etatpublication
     *
     * @return News
     */
    public function setEtatpublication($etatpublication)
    {
        $this->etatpublication = $etatpublication;

        return $this;
    }

    /**
     * Get etatpublication
     *
     * @return string
     */
    public function getEtatpublication()
    {
        return $this->etatpublication;
    }
}

