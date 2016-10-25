<?php

namespace AdminBundle\Entity;
//use Symfony\Component\Form\Extension\Core\Type\FileType;


use Doctrine\ORM\Mapping as ORM;
use Serializable;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="AdminBundle\Repository\UserRepository")
 */
class User implements UserInterface, Serializable {

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
     * @ORM\Column(name="pseudo", type="string", length=100)
     */
    private $pseudo;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=100)
     */
    private $nom;

    /**
     * 
     * @ORM\Column(name="avatar", type="string", length=600)
     * @Assert\File()
     *
     */
    private $avatar;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=100)
     */
    private $prenom;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=100)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=40)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="salt", type="string", length=255)
     */
    private $salt;

    /**
     * @var array
     *
     * @ORM\Column(name="roles", type="array")
     */
    private $roles;

    /**
     * Get id
     *
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Get nom
     *
     * @return string
     */
    function getNom() {
        return $this->nom;
    }

    /**
     * Get prenom
     *
     * @return string
     */
    function getPrenom() {
        return $this->prenom;
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return User
     */
    function setNom($nom) {
        $this->nom = $nom;
    }

    /**
     * Set prenom
     *
     * @param string prenom
     *
     * @return User
     */
    function setPrenom($prenom) {
        $this->prenom = $prenom;
    }

    /**
     * Set username
     *
     * @param string $username
     *
     * @return User
     */
    public function setUsername($username) {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername() {
        return $this->username;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password) {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword() {
        return $this->password;
    }

    /**
     * Set salt
     *
     * @param string $salt
     *
     * @return User
     */
    public function setSalt($salt) {
        $this->salt = $salt;

        return $this;
    }

    /**
     * Get salt
     *
     * @return string
     */
    public function getSalt() {
        return $this->salt;
    }

    /**
     * Get pseudo
     *
     * @return string
     */
    function getPseudo() {
        return $this->pseudo;
    }

    /**
     * Get avatar
     *
     * @return string
     */
    function getAvatar() {
        return $this->avatar;
    }

    /**
     * Set pseudo
     *
     * @param string $pseudo
     *
     * @return User
     */
    function setPseudo($pseudo) {
        $this->pseudo = $pseudo;
    }

    /**
     * Set avatar
     *
     * @param UploadedFile $avatar
     *
     * @return User
     */
    function setAvatar($uploadedFile) {
        $this->avatar = $uploadedFile ;
    }

    /**
     * Set roles
     *
     * @param array $roles
     *
     * @return User
     */
    public function setRoles($roles) {
        $this->roles = $roles;

        return $this;
    }

    /**
     * Get roles
     *
     * @return array
     */
    public function getRoles() {
        return $this->roles;
    }

    public function eraseCredentials() {
        
    }

    public function serialize() {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
            $this->roles
        ));
    }

    public function unserialize($serialized) {
        list(
                $this->id,
                $this->username,
                $this->password,
                $this->roles
                ) = unserialize($serialized);
    }

}
