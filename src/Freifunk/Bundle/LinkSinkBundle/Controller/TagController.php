<?php

namespace Freifunk\Bundle\LinkSinkBundle\Controller;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Freifunk\Bundle\LinkSinkBundle\Entity\Tag;
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
        $allTags = $repo->findAll();

        /** @var Tag $location */
        $tag = $repo->findOneBy(['slug' => $slug]);

        if (!$tag) {
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
}
