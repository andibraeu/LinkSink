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
            ->from('FreifunkLinkSinkBundle:Link', 'e')
            ->orderBy('e.pubdate');
        $entities = $qb->getQuery()->execute();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Displays a form to add a new link
     *
     * @Route("/links/neu", name="_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction() {
        $entity = new Link();

        return array(
            'entity' => $entity,
        );
    }

    /**
     * Creates a new Link entity.
     *
     * @Route("/links/", name="_create")
     * @Method("POST")
     * @Template("FreifunkLinkSinkBundle:Link:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Link();

        $em = $this->saveLink($request, $entity);


        if ($entity->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('_show', array('slug' => $entity->slug)));
        }

        return array(
            'entity' => $entity,
        );
    }

    /**
     * Finds and displays a Link entity.
     *
     * @Route("/links/{slug}", name="_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($slug)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        /** @var EntityRepository $repo */
        $repo = $em->getRepository('FreifunkLinkSinkBundle:Link');

        /** @var Link $entity */
        $entity = $repo->findOneBy(['slug' => $slug]);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Link entity.');
        }

        return array(
            'entity'      => $entity
        );
    }

    /**
     * Displays a form to edit an existing Link entity.
     *
     * @Route("/links/{slug}/edit", name="_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($slug)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        /** @var EntityRepository $repo */
        $repo = $em->getRepository('FreifunkLinkSinkBundle:Link');

        /** @var Link $entity */
        $entity = $repo->findOneBy(['slug' => $slug]);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Link entity.');
        }

        return array(
            'entity'      => $entity,
        );
    }

    /**
     * Edits an existing Link entity.
     *
     * @Route("/links/{slug}", name="_update")
     * @Method("POST")
     * @Template("FreifunkLinkSinkBundle:Link:edit.html.twig")
     */
    public function updateAction(Request $request, $slug)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        /** @var EntityRepository $repo */
        $repo = $em->getRepository('FreifunkLinkSinkBundle:Link');

        /** @var Link $entity */
        $entity = $repo->findOneBy(['slug' => $slug]);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Link entity.');
        }

        $em = $this->saveLink($request, $entity);


        if ($entity->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('_show', array('slug' => $entity->slug)));
        }

        return array(
            'entity'      => $entity,

        );
    }

    /**
     * @param Request $request
     * @param $entity
     * @return EntityManager
     */
    public function saveLink(Request $request, Link $entity)
    {

        $pubdate = $request->get('pubdate');
        $pubdate = new \DateTime($pubdate);
        $entity->pubdate = $pubdate;
        $entity->guid = $request->get('guid');
        $entity->description = $request->get('description');
        $entity->title = $request->get('title');
        $entity->url = $request->get('url');
        $entity->enclosure = $request->get('enclosure');

        $entity->slug = \URLify::filter($entity->title, 255, 'de');

        $tags = $request->get('tags');
        if (strlen($tags) > 0) {
            $tags = explode(',', $tags);
            $em = $this->getDoctrine()->getManager();
            $repo = $em->getRepository('FreifunkLinkSinkBundle:Tag');
            $entity->clearTags();
            foreach ($tags as $tag) {
                $tag = trim($tag);
                $results = $repo->findBy(['name' => $tag]);
                if (count($results) > 0) {
                    $entity->addTag($results[0]);
                } else {
                    $tag_obj = new Tag();
                    $tag_obj->name = $tag;
                    $tag_obj->slug = \URLify::filter($tag_obj->name, 255, 'de');
                    $em->persist($tag_obj);
                    $em->flush();
                    $entity->addTag($tag_obj);
                }
            }
            return $em;
        }
        //return $em;
    }


}
