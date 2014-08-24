<?php

namespace Freifunk\Bundle\LinkSinkBundle\Controller;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Freifunk\Bundle\LinkSinkBundle\Entity\Category;
use Freifunk\Bundle\LinkSinkBundle\Entity\Link;
use Doctrine\ORM\QueryBuilder;
use Freifunk\Bundle\LinkSinkBundle\Entity\Tag;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class CategoryController
 * @package Freifunk\Bundle\LinkSinkBundle\Controller
 * @Route("/kategorie")
 */
class CategoryController extends Controller
{

    /**
     * @Route("/s/{category}.{format}", defaults={"year" = "", "tag" = "", "format"="html"}, name="category_filter")
     * @Route("/s/{category}/{year}.{format}", requirements={"year" = "\d{4}"}, defaults={"tag" = "", "format"="html"}, name="category_filter_year")
     * @Route("/s/{category}/{year}/{tag}.{format}", requirements={"year" = "\d{4}"}, defaults={"format"="html"}, name="category_filter_year_tag")
     * @Route("/s/{category}/{tag}.{format}", requirements={"tag" = "[A-Za-z0-9\-]+"}, defaults={"year" = "", "format"="html"}, name="category_filter_tag")
     * @Method("GET")
     * @Template("FreifunkLinkSinkBundle:Link:index.html.twig")
     */
    public function showAction($category, $year, $tag, $format)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        /** @var EntityRepository $repo */
        $repo = $em->getRepository('FreifunkLinkSinkBundle:Category');

        /** @var Category $category */
        $myCategory = $repo->findOneBy(['slug' => $category]);

        /** @var Category $allCategories */
        $allCategories = $repo->findAll();
        
        $repo = $em->getRepository('FreifunkLinkSinkBundle:Tag');

        /** @var Tag $allTags */
        $allTags = $repo->findAll();

        if (!$myCategory) {
            throw $this->createNotFoundException('Unable to find category entity.');
        }

        /** @var Tag $location */
        $myTag = $repo->findOneBy(['slug' => $tag]);

        if ($tag && !$myTag) {
            throw $this->createNotFoundException('Unable to find tag entity.');
        }

        /** @var QueryBuilder $qb */
        $qb = $em->createQueryBuilder();
        $qb->select(array('e.pubyear'))
            ->from('FreifunkLinkSinkBundle:Link', 'e')
            ->groupBy('e.pubyear');
        $years = $qb->getQuery()->execute();
        $qb = $em->createQueryBuilder();


        $qb->select(array('e'))
            ->from('FreifunkLinkSinkBundle:Link', 'e')
            ->join('e.category', 'c', 'WITH', $qb->expr()->in('c.id', $myCategory->id));
	if ($myTag) {
            $qb->join('e.tags', 't', 'WITH', $qb->expr()->in('t.id', $myTag->id));
	}
	if ($year) {
	    $qb->where('e.pubyear = :year');
	    $qb->setParameter('year', $year);
	}
        $qb->orderBy('e.pubdate', 'desc');
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
                'tag' => $myTag,
                'tags' => $allTags,
		        'category' => $myCategory,
                'categories' => $allCategories,
		        'year' => $year,
                'years' => $years,
            );
        }

    }

    /**
     * @Route("/", name="category_show")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        /** @var EntityRepository $repo */
        $repo = $em->getRepository('FreifunkLinkSinkBundle:Category');
        $entities = $repo->findAll();
        return [
            'entities' => $entities,
        ];
    }

    /**
     * @Route("/{slug}/bearbeiten", name="category_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($slug)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        /** @var EntityRepository $repo */
        $repo = $em->getRepository('FreifunkLinkSinkBundle:Category');

        /** @var Link $entity */
        $entity = $repo->findOneBy(['slug' => $slug]);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Category entity.');
        }

        return array(
            'entity'      => $entity,
        );
    }

    /**
     * @Route("/{slug}/update", name="category_update")
     * @Method("POST")
     * @Template()
     */
    public function updateAction(Request $request, $slug)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        /** @var EntityRepository $repo */
        $repo = $em->getRepository('FreifunkLinkSinkBundle:Category');
        /** @var Category $entity */
        $entity = $repo->findOneBy(['slug' => $slug]);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Category entity.');
        }
        if ($entity->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('category_show'));
        }
        return [
            'entity' => $entity,
        ];
    }

    /**
     * @Route("/create", name="category_create")
     * @Method("POST")
     * @Template()
     */
    public function createAction(Request $request)
    {
        $entity = new Category();

        $em = $this->saveCategory($request, $entity);

        if ($entity->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('category_show'));
        }

        return [
            'entity' => $entity,
        ];
    }

    /**
     * @Route("/neu", name="category_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Category();

        return array(
            'entity' => $entity,
        );
    }


    /**
     * Provides a form to delete an existing link from database
     *
     * @Route("kategorie/{slug}/delete", name="category_delete")
     * @Method("GET")
     * @Template()
     */
    public function deleteAction($slug)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        /** @var EntityRepository $repo */
        $repo = $em->getRepository('FreifunkLinkSinkBundle:Category');

        /** @var Category $entity */
        $entity = $repo->findOneBy(['slug' => $slug]);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Category entity.');
        }

        if ($entity->getLinks()->count() > 0 ) {
            return $this->redirect($this->generateUrl('category_show', array('haslinksname' => $entity->getName())));
        }

        return array(
            'entity'      => $entity,

        );
    }

    /**
     * Deletes an existing link from database
     *
     * @Route("kategorie/{slug}/deleteconfirmed", name="category_deleteconfirmed")
     * @Method("POST")
     * @Template()
     */
    public function deleteConfirmedAction(Request $request, $slug)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        /** @var EntityRepository $repo */
        $repo = $em->getRepository('FreifunkLinkSinkBundle:Category');

        /** @var Category $entity */
        $entity = $repo->findOneBy(['slug' => $slug]);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Category entity.');
        }
        if ($entity->isValid()) {
            $name = $entity->getName();
            $em = $this->getDoctrine()->getManager();
            $em->remove($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('category_show', array('deletedname' => $name)));
        }

        return array(
            'entity'      => $entity,

        );
    }


    private function saveCategory(Request $request, Category $entity) {

        $entity->setName($request->get('name'));
        $entity->setSlug(\URLify::filter($entity->getName(), 255, 'de'));

        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        return $em;
    }

}
