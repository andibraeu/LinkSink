<?php
/**
 * Created by PhpStorm.
 * User: andi
 * Date: 17.08.14
 * Time: 16:03
 */

namespace Freifunk\Bundle\LinkSinkBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @property string $url
 * @property int $length
 * @property string $type
 *
 * @ORM\Table(name="enclosure")
 * @ORM\Entity
 */
class Enclosure extends BaseEntity {

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
     * @ORM\Column(name="length", type="integer", nullable=true)
     */
    protected $length;

    /**
     *
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255)
     */
    protected $type;


    /**
     * Set url
     *
     * @param string $url
     * @return Enclosure
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
     * Set length
     *
     * @param integer $length
     * @return Enclosure
     */
    public function setLength($length)
    {
        $this->length = $length;

        return $this;
    }

    /**
     * Get length
     *
     * @return integer 
     */
    public function getLength()
    {
        return $this->length;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return Enclosure
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }
}
