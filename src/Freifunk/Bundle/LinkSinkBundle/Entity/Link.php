<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Freifunk\Bundle\LinkSinkBundle\Entity;

use Argentum\FeedBundle\Feed\FeedItemCategory;
use Argentum\FeedBundle\Feed\FeedItemGuid;
use Doctrine\ORM\Mapping as ORM;

use Argentum\FeedBundle\Feed\Feedable;
use Argentum\FeedBundle\Feed\FeedItem;
use Argentum\FeedBundle\Feed\FeedItemEnclosure;
use Argentum\FeedBundle\Feed\FeedItemSource;

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
class Link extends BaseEntity implements Feedable {

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
     *
     * @var string
     *
     * @ORM\Column(name="category", type="string", length=255, nullable=true)
     */
    protected $category;


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

    public function isValid() {
        return true;
    }

    /**
     * Returns FeedItem instance.
     *
     * @return FeedItem
     */
    public function getFeedItem(){
        $item = new FeedItem();

        $item
            //->setRouteName('tags'.$this->slug)
            ->setRouteParameters([
                'category' => $this->category,
                'id' => $this->id,
                'slug' => $this->slug,
            ])
            ->setTitle($this->title)
            ->addCategory(new FeedItemCategory($this->category))
            ->setDescription($this->description)
            ->setLink($this->url)
            ->setGuid(new FeedItemGuid($this->guid))
            ->setPubDate($this->pubdate);

       /* if ($this->getImageMedium()) {
            $item->addEnclosure(
                new FeedItemEnclosure($this->getImageMedium()['path'], 'image/jpeg')
            );
        }

        if ($this->getSourceTitle()) {
            $item->setSource(
                new FeedItemSource($this->getSourceTitle(), $this->getSourceUrl())
            );
        }*/

        return $item;
    }

}
