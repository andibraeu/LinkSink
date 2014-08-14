<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Freifunk\Bundle\LinkSinkBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Description of Tag
 *
 * @author andi
 * 
 * @ORM\Table(name="tags")
 * @ORM\Entity
 */
class Tag extends BaseEntity {

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    protected $name;

}
