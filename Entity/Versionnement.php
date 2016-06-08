<?php

namespace SuperBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Versionnement
 *
 * @ORM\Table(name="versionnement")
 * @ORM\Entity(repositoryClass="SuperBundle\Repository\VersionnementRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Versionnement
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
     * @var int
     *
     * @ORM\Column(name="page_id", type="integer")
     */
    private $pageId;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=30)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=255)
     */
    private $slug;

    /**
     * @var string
     * @Assert\NotBlank()
     * @ORM\Column(name="content", type="text")
     */
    private $content;
    /**
     * @var \SuperBundle\Entity\Categorie
     * @ORM\ManyToOne(targetEntity="SuperBundle\Entity\Categorie", cascade={"persist"}))
     */
    private $categorie;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string")
     */
    private $type;

    public function __construct()
    {
        $this->date = new \DateTime();
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
     * Set pageId
     *
     * @param integer $pageId
     *
     * @return Versionnement
     */
    public function setPageId($pageId)
    {
        $this->pageId = $pageId;

        return $this;
    }

    /**
     * Get pageId
     *
     * @return int
     */
    public function getPageId()
    {
        return $this->pageId;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Versionnement
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
     * Set slug
     *
     * @param string $slug
     * @ORM\PreUpdate
     * @ORM\PrePersist
     * @return Versionnement
     */
    public function setSlug($slug)
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
        $pre_slug = strtolower(strtr($this->getTitle(), $caracs));
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

    /**
     * Set content
     *
     * @param string $content
     *
     * @return Versionnement
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set categorie
     *
     * @param integer $categorie
     *
     * @return Versionnement
     */
    public function setCategorie($categorie)
    {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * Get categorie
     *
     * @return integer
     */
    public function getCategorie()
    {
        return $this->categorie;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Versionnement
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Versionnement
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }
}

