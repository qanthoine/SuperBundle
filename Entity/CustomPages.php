<?php

namespace SuperBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CustomPages
 *
 * @ORM\Table(name="custom_pages")
 * @ORM\Entity(repositoryClass="SuperBundle\Repository\CustomPagesRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class CustomPages
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
     * @Assert\NotBlank()
     * @ORM\Column(name="title", type="string", length=30, unique=true)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=255, unique=true)
     */
    private $slug;

    /**
     * @var string
     * @Assert\NotBlank()
     * @ORM\Column(name="content", type="text")
     */
    private $content;

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
     * @return CustomPages
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
     *
     * @ORM\PreUpdate
     * @ORM\PrePersist
     * @return CustomPages
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
     * @return CustomPages
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
}

