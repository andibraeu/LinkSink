<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Freifunk\Bundle\LinkSinkBundle\Entity;

/**
 * Description of TagTrait
 *
 * @author andi
 */
use Doctrine\ORM\PersistentCollection;
use Doctrine\ORM\Mapping as ORM;

trait TagTrait {

    public function getTags() {
        return $this->tags;
    }

    public function clearTags() {
        if ($this->tags instanceof PersistentCollection) {
            $this->tags->clear();
        } elseif (is_array($this->tags)) {
            $this->tags = [];
        }
    }

    public function hasTag(Tag $tag) {
        if ($this->tags instanceof PersistentCollection) {
            return $this->tags->contains($tag);
        } elseif (is_array($this->tags)) {
            return in_array($tag, $this->tags);
        } else {
            return false;
        }
    }

    public function addTag(Tag $tag) {
        if (!$this->hasTag($tag)) {
            $this->tags[] = $tag;
        }
    }

    public function getTagsAsText() {
        if (count($this->tags) > 0) {
            $tags = [];
            foreach ($this->tags as $tag) {
                $tags[] = $tag->name;
            }
            return implode(',', $tags);
        } else {
            return '';
        }
    }
}
