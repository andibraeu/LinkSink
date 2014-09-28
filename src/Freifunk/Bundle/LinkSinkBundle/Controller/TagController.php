<?php

namespace Freifunk\Bundle\LinkSinkBundle\Controller;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Freifunk\Bundle\LinkSinkBundle\Entity\Tag;
use Freifunk\Bundle\LinkSinkBundle\Entity\Category;
use Freifunk\Bundle\LinkSinkBundle\Entity\TagRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Freifunk\Bundle\LinkSinkBundle\Entity\Link;
use Freifunk\Bundle\LinkSinkBundle\Form\LinkType;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Validator\Constraints\DateTime;

/**
 * Tag controller.
 *
 * @Route("/tags")
 */
class TagController extends Controller
{
    /**
     * Finds and displays a Event entity.
     *
     * @Route("/{slug}.{format}", defaults={"format" = "html"}, name="tag_show")
     * @Method("GET")
     * @Template("FreifunkLinkSinkBundle:Link:index.html.twig")
     */
    public function showAction($slug, $format)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        /** @var EntityRepository $repo */
        $repo = $em->getRepository('FreifunkLinkSinkBundle:Category');

        /** @var Category $allCategories */
        $allCategories = $repo->findAll();

        /** @var EntityRepository $repo */
        $repo = $em->getRepository('FreifunkLinkSinkBundle:Tag');

        /** @var Tag $allTags */
        $allTags = $repo->findAllOrderedBySlug();

        /** @var Tag $location */
        $tag = $repo->findOneBy(['slug' => $slug]);

        if (!$tag) {
            throw $this->createNotFoundException('Unable to find tag entity.');
        }

        /** @var QueryBuilder $qb */
        $qb = $em->createQueryBuilder();
        $qb->select(array('e.pubyear'))
            ->from('FreifunkLinkSinkBundle:Link', 'e')
            ->orderBy('e.pubyear', 'desc')
            ->groupBy('e.pubyear');
        $years = $qb->getQuery()->execute();
        $qb = $em->createQueryBuilder();

        $qb->select(array('e'))
            ->from('FreifunkLinkSinkBundle:Link', 'e')
            ->join('e.tags', 't', 'WITH', $qb->expr()->in('t.id', $tag->id))
            ->orderBy('e.pubdate', 'desc');
        $entities = $qb->getQuery()->execute();

        if ($format == 'rss') {
            $rss = $this->get('argentum_feed.factory')
                ->createFeed('news')
                ->addFeedableItems($entities)
                ->render();

            $response = new Response($rss);
            $response->headers->set('Content-Type', 'text/xml');
            return $response;
        } else {
            return array(
                'entities' => $entities,
                'tag' => $tag,
                'categories' => $allCategories,
                'tags' => $allTags,
                'years' => $years,
            );
        }
    }

    /**
     * @Route("/", name="tag_list")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        /** @var EntityRepository $repo */
        $repo = $em->getRepository('FreifunkLinkSinkBundle:Tag');
        $entities = $repo->findAll();
        return [
            'entities' => $entities,
        ];
    }

    /**
     * Provides a form to delete an existing link from database
     *
     * @Route("/{slug}/delete", name="tag_delete")
     * @Method("GET")
     * @Template()
     */
    public function deleteAction($slug)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        /** @var EntityRepository $repo */
        $repo = $em->getRepository('FreifunkLinkSinkBundle:Tag');

        /** @var Category $entity */
        $entity = $repo->findOneBy(['slug' => $slug]);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Tag entity.');
        }

        if ($entity->getLinks()->count() > 0 ) {
            return $this->redirect($this->generateUrl('tag_list', array('haslinksname' => $entity->getName())));
        }

        return array(
            'entity'      => $entity,

        );
    }

    /**
     * Deletes an existing link from database
     *
     * @Route("/{slug}/deleteconfirmed", name="tag_deleteconfirmed")
     * @Method("POST")
     * @Template()
     */
    public function deleteConfirmedAction(Request $request, $slug)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        /** @var EntityRepository $repo */
        $repo = $em->getRepository('FreifunkLinkSinkBundle:Tag');

        /** @var Category $entity */
        $entity = $repo->findOneBy(['slug' => $slug]);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Tag entity.');
        }
        if ($entity->isValid()) {
            $name = $entity->getName();
            $em = $this->getDoctrine()->getManager();
            $em->remove($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('tag_list', array('deletedname' => $name)));
        }

        return array(
            'entity'      => $entity,

        );
    }
}
