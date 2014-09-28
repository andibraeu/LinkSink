<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Freifunk\Bundle\LinkSinkBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;


/**
 * Description of Tag
 *
 * @author andi
 * 
 * @ORM\Table(name="tags")
 * @ORM\Entity(repositoryClass="Freifunk\Bundle\LinkSinkBundle\Entity\TagRepository")
 */
class Tag extends BaseEntity {

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    protected $name;

    /**
     * Set name
     *
     * @param string $name
     * @return Tag
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
     * @ORM\ManyToMany(targetEntity="Link", mappedBy="tags")
     */
    protected $links;

    /**
     * Add links
     *
     * @param Link $links
     * @return Category
     */
    public function addLink(Link $links)
    {
        $this->links[] = $links;

        return $this;
    }

    /**
     * Remove links
     *
     * @param Link $links
     */
    public function removeLink(Link $links)
    {
        $this->links->removeElement($links);
    }

    /**
     * Get links
     *
     * @return Collection
     */
    public function getLinks()
    {
        return $this->links;
    }

    public function isValid() {
        return true;
    }

}
