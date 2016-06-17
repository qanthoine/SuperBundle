<?php

namespace SuperBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Categorie
 *
 * @ORM\Table(name="categorie")
 * @ORM\Entity(repositoryClass="SuperBundle\Repository\CategorieRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Categorie
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\ManyToOne(targetEntity="SuperBundle\Entity\CustomPages", cascade={"persist"}))
     * @ORM\JoinColumn(name="categorie_f", referencedColumnName="categorie", onDelete="SET NULL")
     * @ORM\ManyToOne(targetEntity="SuperBundle\Entity\Versionnement", cascade={"persist"}))
     * @ORM\JoinColumn(name="categorie_s", referencedColumnName="categorie", onDelete="SET NULL")

     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=255, unique=true)
     */
    private $slug;


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
     * Set name
     *
     * @param string $name
     *
     * @return Categorie
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @ORM\PreUpdate
     * @ORM\PrePersist
     * @return Categorie
     */
    public function setSlug()
    {
        $caracs = array("¥" => "Y", "µ" => "u", "À" => "A", "Á" => "A",
            "Â" => "A", "Ã" => "A", "Ä" => "A", "Å" => "A",
            "Æ" => "A", "Ç" => "C", "È" => "E", "É" => "E",
            "Ê" => "E", "Ë" => "E", "Ì" => "I", "Í" => "I",
            "Î" => "I", "Ï" => "I", "Ð" => "D", "Ñ" => "N",
            "Ò" => "O", "Ó" => "O", "Ô" => "O", "Õ" => "O",
            "Ö" => "O", "Ø" => "O", "Ù" => "U", "Ú" => "U",
            "Û" => "U", "Ü" => "U", "Ý" => "Y", "ß" => "s",
            "à" => "a", "á" => "a", "â" => "a", "ã" => "a",
            "ä" => "a", "å" => "a", "æ" => "a", "ç" => "c",
            "è" => "e", "é" => "e", "ê" => "e", "ë" => "e",
            "ì" => "i", "í" => "i", "î" => "i", "ï" => "i",
            "ð" => "o", "ñ" => "n", "ò" => "o", "ó" => "o",
            "ô" => "o", "õ" => "o", "ö" => "o", "ø" => "o",
            "ù" => "u", "ú" => "u", "û" => "u", "ü" => "u",
            "ý" => "y", "ÿ" => "y", "(" => "", ")" => "",
            "!" => "", "?" => "", "¿" => "", "¡" => "",
            "," => "", ":" => "", ";" => "", "'" => "-", " " => "-"); // Formatage #1
        $pre_slug = strtolower(strtr($this->getName(), $caracs));
        $caracs_s = array("--" => "-"); // Casse double tiret
        $slug = strtr($pre_slug, $caracs_s);
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }
}

