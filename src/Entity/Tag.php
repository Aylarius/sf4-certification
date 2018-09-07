<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="tag")
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
