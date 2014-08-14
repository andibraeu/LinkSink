<?php

namespace Freifunk\Bundle\LinkSinkBundle\Controller;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Freifunk\Bundle\LinkSinkBundle\Entity\Link;
use Freifunk\Bundle\LinkSinkBundle\Entity\Tag;


/**
 * Link controller.
 *
 * @Route("/")
 */
class LinkController extends Controller
{

    /**
     * Lists all Event entities.
     *
     * @Route("/", name="")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $qb = $em->createQueryBuilder();
        $qb ->select(array('e'))
            ->from('LinkSinkBundle:Link', 'e')
            ->orderBy('e.pubdate');
        $entities = $qb->getQuery()->execute();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Displays a form to create a new Event entity.
     *
     * @Route("/link/neu", name="_new")
     * @Method("GET")
     * @Template()
    */
    public function newAction()
    {
        $entity = new Link();
        return array(
            'entity' => $entity,
        );
    }
}
