<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * categorie
 *
 * @ORM\Table(name="categories")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\categorieRepository")
 */
class categorie
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
     * @ORM\Column(name="categorieName", type="string", length=100)
     */
    private $categorieName;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="annonce",mappedBy="categorie")
     *
     */
    private $annonces;

    /**
     * @return ArrayCollection
     */
    public function getAnnonces()
    {
        return $this->annonces;
    }

    /**
     * @param ArrayCollection $annonces
     * @return categorie
     */
    public function setAnnonces($annonces)
    {
        $this->annonces = $annonces;
        return $this;
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
     * Set categorieName
     *
     * @param string $categorieName
     *
     * @return categorie
     */
    public function setCategorieName($categorieName)
    {
        $this->categorieName = $categorieName;

        return $this;
    }

    /**
     * Get categorieName
     *
     * @return string
     */
    public function getCategorieName()
    {
        return $this->categorieName;
    }


    public function __toString()
{
    return $this->categorieName;
}




}

