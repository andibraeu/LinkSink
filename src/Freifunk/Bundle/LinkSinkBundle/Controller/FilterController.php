<?php
/**
 * Created by PhpStorm.
 * User: andi
 * Date: 20.02.17
 * Time: 22:33
 */

namespace Freifunk\Bundle\LinkSinkBundle\Controller;


use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Freifunk\Bundle\LinkSinkBundle\Entity\Category;
use Freifunk\Bundle\LinkSinkBundle\Entity\Tag;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class CategoryController
 * @package Freifunk\Bundle\LinkSinkBundle\Controller
 * @Route("/filter")
 */
class FilterController extends Controller
{
    /**
     * @Route("/s/{category}.{format}", defaults={"year" = "", "tag" = "", "format"="html"}, name="category_filter")
     * @Route("/s/{category}/{year}.{format}", requirements={"year" = "\d{4}"}, defaults={"tag" = "", "format"="html"}, name="category_filter_year")
     * @Route("/s/{category}/{year}/{tag}.{format}", requirements={"year" = "\d{4}"}, defaults={"format"="html"}, name="category_filter_year_tag")
     * @Route("/s/{category}/{tag}.{format}", requirements={"tag" = "[A-Za-z0-9\-]+"}, defaults={"year" = "", "format"="html"}, name="category_filter_tag")
     * @Route("/y/{year}.{format}", requirements={"year" = "\d{4}"}, defaults={"tag" = "", "category" = "", "format"="html"}, name="year_filter")
     * @Route("/y/{year}/{tag}.{format}", requirements={"year" = "\d{4}"}, defaults={"category" = "", "format"="html"}, name="year_tag_filter")
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
        $allTags = $repo->findAllOrderedBySlug();

        if ($category && !$myCategory) {
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
            ->orderBy('e.pubyear', 'desc')
            ->groupBy('e.pubyear');
        $years = $qb->getQuery()->execute();
        $qb = $em->createQueryBuilder();


        $qb->select(array('e'))
            ->from('FreifunkLinkSinkBundle:Link', 'e');
        if ($myCategory) {
            $qb->join('e.category', 'c', 'WITH', $qb->expr()->in('c.id', $myCategory->id));
        }
        if ($myTag) {
            $qb->join('e.tags', 't', 'WITH', $qb->expr()->in('t.id', $myTag->id));
        }
        if ($year) {
            $qb->andWhere('e.pubyear = :year');
            $qb->setParameter('year', $year);
        }
        $qb->andWhere('e.deleted is null');
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
}