<?php
/**
 * Created by PhpStorm.
 * User: andi
 * Date: 02.09.14
 * Time: 15:50
 */

namespace Freifunk\Bundle\LinkSinkBundle;


class TwigContentExtension extends \Twig_Extension
{
    public function getName()
    {
        return 'content_extension';
    }

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('content', array($this, 'getContent')),
        );
    }

    public function getContent($link)
    {
        $content = file_get_contents($link);
        if ($content) {
            return $content;
        } else {
            return "";
        }
    }
} 