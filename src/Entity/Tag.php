<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity
 * @ORM\Table(name="tag")
 * @UniqueEntity(fields={"title"}, message="It looks like this tag already exists!")
 */
class Tag
{
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
     * @ORM\ManyToMany(targetEntity="App\Entity\Resource", mappedBy="tags")
     */
    public $resources;

    public function __construct()
    {
        $this->resources = new ArrayCollection();
    }

    public function __toString() : ?string
    {
        return $this->title;
    }
}
