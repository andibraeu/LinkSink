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
     * @Route("/{slug}/delete", name="category_delete")
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
     * @Route("/{slug}/deleteconfirmed", name="category_deleteconfirmed")
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
