<?php

namespace Freifunk\Bundle\LinkSinkBundle\Controller;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Freifunk\Bundle\LinkSinkBundle\Entity\Category;
use Freifunk\Bundle\LinkSinkBundle\Entity\Enclosure;
use Freifunk\Bundle\LinkSinkBundle\Entity\Link;
use Freifunk\Bundle\LinkSinkBundle\Entity\Tag;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


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

        $em = $this->getDoctrine()->getManager();

        /** @var EntityRepository $catRepo */
        $catRepo = $em->getRepository('FreifunkLinkSinkBundle:Category');

        /** @var Category[] $categories */
        $categories = $catRepo->findAll();

        return array(
            'entity' => $entity,
            'categories' => $categories,
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

        /** @var EntityRepository $catRepo */
        $catRepo = $em->getRepository('FreifunkLinkSinkBundle:Category');

        /** @var Category[] $categories */
        $categories = $catRepo->findAll();

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Link entity.');
        }

        return array(
            'entity'      => $entity,
            'categories'  => $categories,
        );
    }

    /**
     * Provides a form to delete an existing link from database
     *
     * @Route("links/{slug}/delete", name="_delete")
     * @Method("GET")
     * @Template()
     */
    public function deleteAction($slug)
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
     * Deletes an existing link from database
     *
     * @Route("links/{slug}/deleteconfirmed", name="_deleteconfirmed")
     * @Method("POST")
     * @Template()
     */
    public function deleteConfirmedAction(Request $request, $slug)
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
       if ($entity->isValid()) {
           $title = $entity->getTitle();
           $em = $this->getDoctrine()->getManager();
           $em->remove($entity);
           $em->flush();

           return $this->redirect($this->generateUrl('', array('deletedtitle' => $title)));
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
        $entity->setPubdate($pubdate);
        $entity->setGuid($request->get('url'));
        $entity->setDescription($request->get('description'));
        $entity->setTitle($request->get('title'));
        $entity->setUrl($request->get('url'));

        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('FreifunkLinkSinkBundle:Category');
        $results = $repo->findOneBy(array( 'slug' => $request->get('category')));

        $entity->setCategory($results[0]);

        $entity->setSlug(\URLify::filter($entity->title, 255, 'de'));


        if ($request->get('enclosureurl')) {
            $repo = $em->getRepository('FreifunkLinkSinkBundle:Enclosure');
            $results = $repo->findBy(array( 'id' => $request->get('enclosureid')));
            if (count($results) > 0) {
                $enclosure = $results[0];
            } else {
                $enclosure = new Enclosure();
            }
            $info = $this->getUrlHeader($request->get('enclosureurl'));
            $enclosure->setUrl($request->get('enclosureurl'));
            if (! is_null($info['download_content_length'])) {
                $enclosure->setLength($info['download_content_length']);
            } else {
                $enclosure->setLength($request->get('enclosurelength'));
            }
            if (! is_null($info['content_type'])) {
                $enclosure->setType($info['content_type']);
            } else if (! is_null($request->get('enclosuretype'))) {
                $enclosure->setType($request->get('enclosuretype'));
            } else {
                $enclosure->setType('application/octet-stream');
            }

            $em->persist($enclosure);
            $em->flush();
            $entity->setEnclosure($enclosure);

        }

        $tags = $request->get('tags');
        if (strlen($tags) > 0) {
            $tags = explode(',', $tags);
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
        return $em;
    }


    /**
     * @param $url
     * @return mixed
     */
    private function getUrlHeader($url) {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLINFO_CONTENT_TYPE, true);
        curl_setopt($curl, CURLINFO_CONTENT_LENGTH_UPLOAD, true);
        curl_setopt($curl, CURLOPT_NOBODY, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_exec($curl);
        $info = curl_getinfo($curl);
        curl_close($curl);
        return $info;
    }


}
