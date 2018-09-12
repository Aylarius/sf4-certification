<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity
 * @ORM\Table(name="resource")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false, hardDelete=true)
 * @UniqueEntity(fields={"title"}, message="It looks like this resource already exists!")
 */
class Resource
{
    use TimestampableEntity;
    use SoftDeleteableEntity;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    public $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=100, nullable=false)
     */
    public $title;

    /**
     * @var string
     *
     * @Gedmo\Slug(fields={"title"})
     * @ORM\Column(name="slug", type="string", length=100, nullable=false)
     */
    public $slug;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text", nullable=false)
     */
    public $content;

    /**
     * @var string|null
     *
     * @ORM\Column(name="learn_more", type="text", nullable=true)
     */
    public $learnMore;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="published", type="boolean", nullable=true)
     */
    public $published = false;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="draft", type="boolean", nullable=true)
     */
    public $draft = false;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="resources")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id", nullable=false)
     */
    public $category;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Tag", inversedBy="resources")
     */
    public $tags;

    public function __construct()
    {
        $this->tags = new ArrayCollection();
    }

    public function __toString() : ?string
    {
        return $this->title;
    }
}
