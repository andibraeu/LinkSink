<?php

namespace Freifunk\Bundle\LinkSinkBundle\Controller;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Freifunk\Bundle\LinkSinkBundle\Entity\Tag;
use Jsvrcek\ICS\Model\Description\Geo;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Freifunk\Bundle\LinkSinkBundle\Entity\Link;
use Freifunk\Bundle\LinkSinkBundle\Form\LinkType;
use Symfony\Component\HttpFoundation\Response;
use Jsvrcek\ICS\Model\Calendar;
use Jsvrcek\ICS\Model\CalendarEvent;

use Jsvrcek\ICS\Utility\Formatter;
use Jsvrcek\ICS\CalendarStream;
use Jsvrcek\ICS\CalendarExport;
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
        $repo = $em->getRepository('FreifunkLinkSinkBundle:Tag');

        /** @var Tag $location */
        $tag = $repo->findOneBy(['slug' => $slug]);

        if (!$tag) {
            throw $this->createNotFoundException('Unable to find tag entity.');
        }

        /** @var QueryBuilder $qb */
        $qb = $em->createQueryBuilder();
        $qb->select(array('e'))
            ->from('FreifunkLinkSinkBundle:Link', 'e')
            ->join('e.tags', 't', 'WITH', $qb->expr()->in('t.id', $tag->id))
            ->orderBy('e.pubdate');
        $entities = $qb->getQuery()->execute();

        if ($format == 'ics') {
//            $calendar = new Calendar();
//            $calendar->setProdId('-//My Company//Cool Calendar App//EN');
//
//            foreach ($entities as $entity) {
//                /** @var Event $entity */
//                $event = new CalendarEvent();
//                $event->setStart($entity->startdate);
//                if ($entity->enddate instanceof \DateTime)
//                    $event->setEnd($entity->enddate);
//                $event->setSummary($entity->summary);
//                $event->setDescription($entity->description);
//                $event->setUrl($entity->url);
//                if ($entity->location instanceof Location) {
//                    $location = new \Jsvrcek\ICS\Model\Description\Location();
//                    $location->setName($entity->location->name);
//                    $event->setLocations([$location]);
//                    if (\is_float($entity->location->lon) && \is_float($entity->location->lat)) {
//                        $geo = new Geo();
//                        $geo->setLatitude($entity->location->lat);
//                        $geo->setLongitude($entity->location->lon);
//                        $event->setGeo($geo);
//                    }
//                }
//                $calendar->addEvent($event);
//            }
//
//            $calendarExport = new CalendarExport(new CalendarStream, new Formatter());
//            $calendarExport->addCalendar($calendar);
//
//            //output .ics formatted text
//            $result = $calendarExport->getStream();
//
//            $response = new Response($result);
//            $response->headers->set('Content-Type', 'text/calendar');
//
//            return $response;
            return '';
        } else {
            return array(
                'entities' => $entities,
                'tag' => $tag,
            );
        }
    }
}
