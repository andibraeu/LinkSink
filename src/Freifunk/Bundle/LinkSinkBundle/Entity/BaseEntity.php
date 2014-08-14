<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Freifunk\Bundle\LinkSinkBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;

/**
 * Description of BaseEntity
 *
 * @author andibraeu
 */

/**
 * A baseclass for all other entities
 *
 * @property integer $id
 * @property string $slug
 *
 * @ORM\MappedSuperclass
 */
abstract class BaseEntity {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=255,options={"default" = ""})
     */
    protected $slug = '';

    public function __isset($name) {
        if (property_exists($this, $name)) {
            return true;
        } else {
            return false;
        }
    }

    public function __get($name) {
        if (property_exists($this, $name)) {
            return $this->$name;
        } else {
            throw new \Exception("Property {$name} does not Exists");
        }
    }

    public function __set($name, $value) {
        if (property_exists($this, $name)) {
            $this->$name = $value;
            return $this;
        } else {
            throw new \Exception("Property {$name} does not Exists");
        }
    }

}
