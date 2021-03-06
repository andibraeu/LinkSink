<?php

namespace Freifunk\Bundle\LinkSinkBundle\Controller;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Freifunk\Bundle\LinkSinkBundle\Entity\Category;
use Freifunk\Bundle\LinkSinkBundle\Entity\Enclosure;
use Freifunk\Bundle\LinkSinkBundle\Entity\Link;
use Freifunk\Bundle\LinkSinkBundle\Entity\Tag;
use Freifunk\Bundle\LinkSinkBundle\Entity\TagRepository;
use Doctrine\ORM\QueryBuilder;
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

        /** @var EntityRepository $repo */
        $repo = $em->getRepository('FreifunkLinkSinkBundle:Category');

        /** @var Category $allCategories */
        $allCategories = $repo->findAll();

        /** @var EntityRepository $repo */
        $repo = $em->getRepository('FreifunkLinkSinkBundle:Tag');

        /** @var Tag $allTags */
        $allTags = $repo->findAllOrderedBySlug();

        $qb = $em->createQueryBuilder();
        $qb->select(array('e.pubyear'))
            ->from('FreifunkLinkSinkBundle:Link', 'e')
            ->orderBy('e.pubyear', 'desc')
            ->groupBy('e.pubyear');
        $years = $qb->getQuery()->execute();
        $qb = $em->createQueryBuilder();

        $qb ->select(array('e'))
            ->from('FreifunkLinkSinkBundle:Link', 'e')
            ->where('e.deleted is null')
            ->orderBy('e.pubdate', 'desc');
        $entities = $qb->getQuery()->execute();

        return array(
            'entities' => $entities,
            'categories' => $allCategories,
            'tags' => $allTags,
            'years' => $years,
        );
    }

    /**
     * filters links
     *
     * @Route("/filter", name="_filter")
     * @Method("POST")
     * @Template()
     */
    public function filterAction(Request $request) {
        if ($request->get('category') && $request->get('tag') && $request->get('year')) {
            return $this->redirect($this->generateUrl('category_filter_year_tag', array(
                'category' => $request->get('category'),
                'tag' => $request->get('tag'),
                'year' => $request->get('year'),
            )));
        } elseif ($request->get('category') && $request->get('year')) {
            return $this->redirect($this->generateUrl('category_filter_year', array(
                'category' => $request->get('category'),
                'year' => $request->get('year'),
            )));
        } elseif ($request->get('category') && $request->get('tag')) {
            return $this->redirect($this->generateUrl('category_filter_tag', array(
                'category' => $request->get('category'),
                'tag' => $request->get('tag'),
            )));
        } elseif ($request->get('tag') && $request->get('year')) {
            return $this->redirect($this->generateUrl('year_tag_filter', array(
                'year' => $request->get('year'),
                'tag' => $request->get('tag'),
            )));
        } elseif ($request->get('category')) {
            return $this->redirect($this->generateUrl('category_filter', array(
                'category' => $request->get('category'),
            )));
        } elseif ($request->get('tag')) {
            return $this->redirect($this->generateUrl('tag_show', array(
                'slug' => $request->get('tag'),
            )));
        } elseif ($request->get('year')) {
            return $this->redirect($this->generateUrl('year_filter', array(
                'year' => $request->get('year'),
            )));
        }
        else {
            return $this->redirect($this->generateUrl(''));
        }

    }

    /**
     * Displays a form to add a new link
     *
     * @Route("/links/neu", name="_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction(Request $request) {
        $entity = new Link();

        if ($request->get('url') != null) {
            $entity->setUrl($request->get('url'));
        }
        if ($request->get('date') != null) {
            $pubdate = new \DateTime("@".$request->get('date'));
            $entity->setPubdate($pubdate);
        }
        if ($request->get('title') != null) {
            $entity->setTitle($request->get('title'));
        }
        if ($request->get('description') != null) {
            $entity->setDescription($request->get('description'));
        }

        $em = $this->getDoctrine()->getManager();

        /** @var EntityRepository $catRepo */
        $catRepo = $em->getRepository('FreifunkLinkSinkBundle:Category');

        /** @var Category[] $categories */
        $categories = $catRepo->findAll();

        /** @var EntityRepository $repo */
        $repo = $em->getRepository('FreifunkLinkSinkBundle:Tag');

        /** @var Tag $allTags */
        $allTags = $repo->findAllOrderedBySlug();


        return array(
            'entity' => $entity,
            'categories' => $categories,
            'tags' => $allTags,
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

        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('FreifunkLinkSinkBundle:Category');
        $category = $repo->findOneBy(array( 'slug' => $request->get('ls_category')));

        if ($entity->isValid() && (! $request->get('ls_origin')) && (! is_null($category))) {
            $em = $this->saveLink($request, $entity);
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('_show', array('slug' => $entity->slug)));
        } else {
            return $this->redirect($this->generateUrl(''));
        }
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

        /** @var EntityRepository $repo */
        $repo = $em->getRepository('FreifunkLinkSinkBundle:Tag');

        /** @var Tag $allTags */
        $allTags = $repo->findAllOrderedBySlug();

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Link entity.');
        }

        return array(
            'entity'      => $entity,
            'categories'  => $categories,
            'tags'        => $allTags,
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
           $entity->setDeleted(true);
           $entity->setDeletedAt(new \DateTime());
           $em = $this->getDoctrine()->getManager();
           $em->persist($entity);
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

        $repo = $em->getRepository('FreifunkLinkSinkBundle:Category');
        $category = $repo->findOneBy(array( 'slug' => $request->get('ls_category')));

        if ($entity->isValid() && (! $request->get('ls_origin')) && (! is_null($category))) {
            $em = $this->saveLink($request, $entity);
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('_show', array('slug' => $entity->slug)));
        } else {
            return $this->redirect($this->generateUrl(''));
        }
    }

    /**
     * @param Request $request
     * @param $entity
     * @return EntityManager
     */
    public function saveLink(Request $request, Link $entity)
    {

        $pubdate = $request->get('ls_pubdate');
        $pubdate = new \DateTime($pubdate);
        $entity->setPubdate($pubdate);
        $entity->setPubyear($pubdate->format("Y"));
        $entity->setGuid($request->get('ls_url'));
        $entity->setDescription($request->get('ls_description'));
        $entity->setTitle($request->get('ls_title'));
        $entity->setUrl($request->get('ls_url'));

        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('FreifunkLinkSinkBundle:Category');
        $result = $repo->findOneBy(array( 'slug' => $request->get('ls_category')));

        $entity->setCategory($result);

        $entity->setSlug(\URLify::filter($entity->title, 255, 'de'));


        if ($request->get('ls_enclosureurl')) {
            $repo = $em->getRepository('FreifunkLinkSinkBundle:Enclosure');
            $results = $repo->findBy(array( 'id' => $request->get('ls_enclosureid')));
            if (count($results) > 0) {
                $enclosure = $results[0];
            } else {
                $enclosure = new Enclosure();
            }
            $info = $this->getUrlHeader($request->get('ls_enclosureurl'));
            $enclosure->setUrl($request->get('ls_enclosureurl'));
            if (! is_null($info['download_content_length'])) {
                $enclosure->setLength($info['download_content_length']);
            } else {
                $enclosure->setLength($request->get('ls_enclosurelength'));
            }
            if (! is_null($info['content_type'])) {
                $enclosure->setType($info['content_type']);
            } else if (! is_null($request->get('ls_enclosuretype'))) {
                $enclosure->setType($request->get('ls_enclosuretype'));
            } else {
                $enclosure->setType('application/octet-stream');
            }

            $em->persist($enclosure);
            $em->flush();
            $entity->setEnclosure($enclosure);

        }

        $tags = $request->get('ls_tags');
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
                    $tag_obj->setName($tag);
                    $tag_obj->slug = \URLify::filter($tag_obj->getName(), 255, 'de');
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
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_exec($curl);
        $info = curl_getinfo($curl);
        curl_close($curl);
        return $info;
    }


}
