<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Freifunk\Bundle\LinkSinkBundle\Entity;

use Argentum\FeedBundle\Feed\Feedable;
use Argentum\FeedBundle\Feed\FeedItem;
use Argentum\FeedBundle\Feed\FeedItemCategory;
use Argentum\FeedBundle\Feed\FeedItemEnclosure;
use Argentum\FeedBundle\Feed\FeedItemGuid;
use Doctrine\ORM\Mapping as ORM;

/**
 * Description of Link
 *
 * @author andi
 */

/**
 * @property \DateTime $pubdate
 * @property integer $pubyear
 * @property string $guid
 * @property string $description
 * @property string $title
 * @property string $url
 * @property Enclosure $enclosure
 * @property string $category
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
     * @var integer
     *
     * @ORM\Column(name="pubyear", type="integer", nullable=true)
     */
    private $pubyear;

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
     * @ORM\Column(name="enclosure_id", type="integer", nullable=true)
     **/
    protected $enclosure_id;

    /**
     * @ORM\OneToOne(targetEntity="Enclosure")
     * @ORM\JoinColumn(name="enclosure_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $enclosure;

    /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="links")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    protected $category;


    /**
     * @var array
     *
     * @ORM\ManyToMany(targetEntity="Tag", inversedBy="links")
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
                'category' => $this->getCategory(),
                'id' => $this->getId(),
                'slug' => $this->getSlug(),
            ])
            ->setTitle($this->getTitle())
            ->addCategory(new FeedItemCategory($this->getCategory()->getName()))
            ->setDescription($this->getDescription())
            ->setLink($this->getUrl())
            ->setGuid(new FeedItemGuid($this->getGuid()))
            ->setPubDate($this->getPubdate());

       if ($this->getEnclosure()) {
            $enclosure = $this->getEnclosure();
            if ($enclosure->getLength() > 0) {
                $item->addEnclosure(
                    new FeedItemEnclosure($enclosure->getUrl(), $enclosure->getType(), $enclosure->getLength())
                );
            }
        }

        /*
        if ($this->getSourceTitle()) {
            $item->setSource(
                new FeedItemSource($this->getSourceTitle(), $this->getSourceUrl())
            );
        }*/

        return $item;
    }


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->tags = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set pubdate
     *
     * @param \DateTime $pubdate
     * @return Link
     */
    public function setPubdate($pubdate)
    {
        $this->pubdate = $pubdate;

        return $this;
    }

    /**
     * Get pubdate
     *
     * @return \DateTime 
     */
    public function getPubdate()
    {
        return $this->pubdate;
    }

    /**
     * Set guid
     *
     * @param string $guid
     * @return Link
     */
    public function setGuid($guid)
    {
        $this->guid = $guid;

        return $this;
    }

    /**
     * Get guid
     *
     * @return string 
     */
    public function getGuid()
    {
        return $this->guid;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Link
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Link
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
     * Set url
     *
     * @param string $url
     * @return Link
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string 
     */
    public function getUrl()
    {
        return $this->url;
    }

    

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return Link
     */
    public function setSlug($slug)
    {
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
     * Set enclosure
     *
     * @param Enclosure $enclosure
     * @return Link
     */
    public function setEnclosure(Enclosure $enclosure = null)
    {
        $this->enclosure = $enclosure;

        return $this;
    }

    /**
     * Get enclosure
     *
     * @return \Freifunk\Bundle\LinkSinkBundle\Entity\Enclosure 
     */
    public function getEnclosure()
    {
        return $this->enclosure;
    }

    /**
     * Add tags
     *
     * @param Tag $tags
     * @return Link
     */
    public function addTag(Tag $tags)
    {
        $this->tags[] = $tags;

        return $this;
    }

    /**
     * Remove tags
     *
     * @param Tag $tags
     */
    public function removeTag(Tag $tags)
    {
        $this->tags->removeElement($tags);
    }

    /**
     * Get tags
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTags()
    {
        return $this->tags;
    }

   

    /**
     * Set enclosure_id
     *
     * @param integer $enclosureId
     * @return Link
     */
    public function setEnclosureId($enclosureId)
    {
        $this->enclosure_id = $enclosureId;

        return $this;
    }

    /**
     * Get enclosure_id
     *
     * @return integer 
     */
    public function getEnclosureId()
    {
        return $this->enclosure_id;
    }

    /**
     * Set category
     *
     * @param \Freifunk\Bundle\LinkSinkBundle\Entity\Category $category
     * @return Link
     */
    public function setCategory(Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set pubyear
     *
     * @param integer $pubyear
     * @return Link
     */
    public function setPubyear($pubyear)
    {
        $this->pubyear = $pubyear;

        return $this;
    }

    /**
     * Get pubyear
     *
     * @return integer 
     */
    public function getPubyear()
    {
        return $this->pubyear;
    }
}
