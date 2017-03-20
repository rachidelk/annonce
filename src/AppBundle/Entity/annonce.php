<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * annonce
 *
 * @ORM\Table(name="annonces")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\annonceRepository")
 */
class annonce
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
     * @Assert\NotBlank(message="Veuillez renseigner le titre")
     * @ORM\Column(name="title", type="string", length=100)
     */
    private $title;

    /**
     * @var string
     * @Assert\NotBlank(message="Veuillez renseigner le texte de l'annonce")
     * @ORM\Column(name="textAnnonce", type="text")
     */
    private $textAnnonce;


    /**
     * @var annonce
     * @Assert\NotBlank(message="Veuillez choisir une catégorie")
     * @ORM\ManyToOne(targetEntity="categorie",inversedBy="annonces")
     */
    private $categorie;

    /**
     * @return annonce
     */
    public function getCategorie()
    {
        return $this->categorie;
    }

    /**
     * @param annonce $categorie
     * @return annonce
     */
    public function setCategorie($categorie)
    {
        $this->categorie = $categorie;
        return $this;
    }

    /**
     * @return annonce
     */
    public function getUtilisateur()
    {
        return $this->utilisateur;
    }

    /**
     * @param annonce $utilisateur
     * @return annonce
     */
    public function setUtilisateur($utilisateur)
    {
        $this->utilisateur = $utilisateur;
        return $this;
    }

    /**
     * @var annonce
     * @ORM\ManyToOne(targetEntity="utilisateur",inversedBy="annonces", cascade={"persist"})
     */
    private $utilisateur;

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
     * Set title
     *
     * @param string $title
     *
     * @return annonce
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set textAnnonce
     *
     * @param string $textAnnonce
     *
     * @return annonce
     */
    public function setTextAnnonce($textAnnonce)
    {
        $this->textAnnonce = $textAnnonce;

        return $this;
    }

    /**
     * Get textAnnonce
     *
     * @return string
     */
    public function getTextAnnonce()
    {
        return $this->textAnnonce;
    }
}

