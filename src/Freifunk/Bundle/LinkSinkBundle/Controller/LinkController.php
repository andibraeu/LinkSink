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

        $now = new \DateTime();
        $now->setTime(0,0,0);
        /** @var QueryBuilder $qb */
        /**$qb = $em->createQueryBuilder();
        $qb ->select(array('e'))
            ->from('CalciferBundle:Event', 'e')
            ->where('e.startdate >= :startdate')
            ->orderBy('e.startdate')
            ->setParameter('startdate',$now);
        $entities = $qb->getQuery()->execute();*/

        return array(
            'entities' => 'empty',
        );
    }

    /**
     * Displays a form to create a new Event entity.
     *
     * @Route("/termine/neu", name="_new")
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
