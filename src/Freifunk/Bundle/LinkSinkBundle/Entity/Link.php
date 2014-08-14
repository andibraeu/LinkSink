<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Freifunk\Bundle\LinkSinkBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Description of Link
 *
 * @author andi
 */

/**
 * @property \DateTime $pubdate
 * @property string $guid
 * @property string $description
 * @property string $title
 * @property string $url
 * @property string $enclosure
 * @property array $tags
 *
 * @ORM\Table(name="links")
 * @ORM\Entity
 */
class Link extends BaseEntity {

    use TagTrait;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="pubdate", type="datetimetz")
     */
    protected $pubdate;
    
    /** 
     *
     * @var string
     * 
     * @ORM\Column(name="guid", type="string", length=255)
     */
    protected $guid;
    
    /**
     *
     * @var string 
     * 
     * @ORM\Column(name="description", type="text")
     */
    protected $description;
    
    /** 
     *
     * @var string
     * 
     * @ORM\Column(name="title", type="string", length=255, nullable=true)
     */
    protected $title;
    
    /** 
     *
     * @var string
     * 
     * @ORM\Column(name="url", type="string", length=255)
     */
    protected $url;
    
    /** 
     *
     * @var string
     * 
     * @ORM\Column(name="enclosure", type="string", length=255, nullable=true)
     */
    protected $enclosure;

    /**
     * @var array
     *
     * @ORM\ManyToMany(targetEntity="Tag")
     * @ORM\JoinTable(name="links2tags",
     * joinColumns={@ORM\JoinColumn(name="links_id", referencedColumnName="id")},
     * inverseJoinColumns={@ORM\JoinColumn(name="tags_id", referencedColumnName="id")}
     * )
     */
    protected $tags = [];

}
