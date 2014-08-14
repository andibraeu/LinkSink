<?php

use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\RequestContext;

/**
 * appDevUrlMatcher
 *
 * This class has been auto-generated
 * by the Symfony Routing Component.
 */
class appDevUrlMatcher extends Symfony\Bundle\FrameworkBundle\Routing\RedirectableUrlMatcher
{
    /**
     * Constructor.
     */
    public function __construct(RequestContext $context)
    {
        $this->context = $context;
    }

    public function match($pathinfo)
    {
        $allow = array();
        $pathinfo = rawurldecode($pathinfo);
        $context = $this->context;
        $request = $this->request;

        if (0 === strpos($pathinfo, '/css/c723f46')) {
            // _assetic_c723f46
            if ($pathinfo === '/css/c723f46.css') {
                return array (  '_controller' => 'assetic.controller:render',  'name' => 'c723f46',  'pos' => NULL,  '_format' => 'css',  '_route' => '_assetic_c723f46',);
            }

            // _assetic_c723f46_0
            if ($pathinfo === '/css/c723f46_links_1.css') {
                return array (  '_controller' => 'assetic.controller:render',  'name' => 'c723f46',  'pos' => 0,  '_format' => 'css',  '_route' => '_assetic_c723f46_0',);
            }

        }

        if (0 === strpos($pathinfo, '/js/9ecf862')) {
            // _assetic_9ecf862
            if ($pathinfo === '/js/9ecf862.js') {
                return array (  '_controller' => 'assetic.controller:render',  'name' => '9ecf862',  'pos' => NULL,  '_format' => 'js',  '_route' => '_assetic_9ecf862',);
            }

            // _assetic_9ecf862_0
            if ($pathinfo === '/js/9ecf862_events_1.js') {
                return array (  '_controller' => 'assetic.controller:render',  'name' => '9ecf862',  'pos' => 0,  '_format' => 'js',  '_route' => '_assetic_9ecf862_0',);
            }

        }

        if (0 === strpos($pathinfo, '/css/5ec667a')) {
            // _assetic_5ec667a
            if ($pathinfo === '/css/5ec667a.css') {
                return array (  '_controller' => 'assetic.controller:render',  'name' => '5ec667a',  'pos' => NULL,  '_format' => 'css',  '_route' => '_assetic_5ec667a',);
            }

            if (0 === strpos($pathinfo, '/css/5ec667a_')) {
                // _assetic_5ec667a_0
                if ($pathinfo === '/css/5ec667a_main_1.css') {
                    return array (  '_controller' => 'assetic.controller:render',  'name' => '5ec667a',  'pos' => 0,  '_format' => 'css',  '_route' => '_assetic_5ec667a_0',);
                }

                // _assetic_5ec667a_1
                if ($pathinfo === '/css/5ec667a_semantic_2.css') {
                    return array (  '_controller' => 'assetic.controller:render',  'name' => '5ec667a',  'pos' => 1,  '_format' => 'css',  '_route' => '_assetic_5ec667a_1',);
                }

                // _assetic_5ec667a_2
                if ($pathinfo === '/css/5ec667a_custom_3.css') {
                    return array (  '_controller' => 'assetic.controller:render',  'name' => '5ec667a',  'pos' => 2,  '_format' => 'css',  '_route' => '_assetic_5ec667a_2',);
                }

            }

        }

        if (0 === strpos($pathinfo, '/images/3c038e0')) {
            // _assetic_3c038e0
            if ($pathinfo === '/images/3c038e0.png') {
                return array (  '_controller' => 'assetic.controller:render',  'name' => '3c038e0',  'pos' => NULL,  '_format' => 'png',  '_route' => '_assetic_3c038e0',);
            }

            // _assetic_3c038e0_0
            if ($pathinfo === '/images/3c038e0_logo_1.png') {
                return array (  '_controller' => 'assetic.controller:render',  'name' => '3c038e0',  'pos' => 0,  '_format' => 'png',  '_route' => '_assetic_3c038e0_0',);
            }

        }

        if (0 === strpos($pathinfo, '/_')) {
            // _wdt
            if (0 === strpos($pathinfo, '/_wdt') && preg_match('#^/_wdt/(?P<token>[^/]++)$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => '_wdt')), array (  '_controller' => 'web_profiler.controller.profiler:toolbarAction',));
            }

            if (0 === strpos($pathinfo, '/_profiler')) {
                // _profiler_home
                if (rtrim($pathinfo, '/') === '/_profiler') {
                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($pathinfo.'/', '_profiler_home');
                    }

                    return array (  '_controller' => 'web_profiler.controller.profiler:homeAction',  '_route' => '_profiler_home',);
                }

                if (0 === strpos($pathinfo, '/_profiler/search')) {
                    // _profiler_search
                    if ($pathinfo === '/_profiler/search') {
                        return array (  '_controller' => 'web_profiler.controller.profiler:searchAction',  '_route' => '_profiler_search',);
                    }

                    // _profiler_search_bar
                    if ($pathinfo === '/_profiler/search_bar') {
                        return array (  '_controller' => 'web_profiler.controller.profiler:searchBarAction',  '_route' => '_profiler_search_bar',);
                    }

                }

                // _profiler_purge
                if ($pathinfo === '/_profiler/purge') {
                    return array (  '_controller' => 'web_profiler.controller.profiler:purgeAction',  '_route' => '_profiler_purge',);
                }

                if (0 === strpos($pathinfo, '/_profiler/i')) {
                    // _profiler_info
                    if (0 === strpos($pathinfo, '/_profiler/info') && preg_match('#^/_profiler/info/(?P<about>[^/]++)$#s', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_info')), array (  '_controller' => 'web_profiler.controller.profiler:infoAction',));
                    }

                    // _profiler_import
                    if ($pathinfo === '/_profiler/import') {
                        return array (  '_controller' => 'web_profiler.controller.profiler:importAction',  '_route' => '_profiler_import',);
                    }

                }

                // _profiler_export
                if (0 === strpos($pathinfo, '/_profiler/export') && preg_match('#^/_profiler/export/(?P<token>[^/\\.]++)\\.txt$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_export')), array (  '_controller' => 'web_profiler.controller.profiler:exportAction',));
                }

                // _profiler_phpinfo
                if ($pathinfo === '/_profiler/phpinfo') {
                    return array (  '_controller' => 'web_profiler.controller.profiler:phpinfoAction',  '_route' => '_profiler_phpinfo',);
                }

                // _profiler_search_results
                if (preg_match('#^/_profiler/(?P<token>[^/]++)/search/results$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_search_results')), array (  '_controller' => 'web_profiler.controller.profiler:searchResultsAction',));
                }

                // _profiler
                if (preg_match('#^/_profiler/(?P<token>[^/]++)$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler')), array (  '_controller' => 'web_profiler.controller.profiler:panelAction',));
                }

                // _profiler_router
                if (preg_match('#^/_profiler/(?P<token>[^/]++)/router$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_router')), array (  '_controller' => 'web_profiler.controller.router:panelAction',));
                }

                // _profiler_exception
                if (preg_match('#^/_profiler/(?P<token>[^/]++)/exception$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_exception')), array (  '_controller' => 'web_profiler.controller.exception:showAction',));
                }

                // _profiler_exception_css
                if (preg_match('#^/_profiler/(?P<token>[^/]++)/exception\\.css$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_exception_css')), array (  '_controller' => 'web_profiler.controller.exception:cssAction',));
                }

            }

            if (0 === strpos($pathinfo, '/_configurator')) {
                // _configurator_home
                if (rtrim($pathinfo, '/') === '/_configurator') {
                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($pathinfo.'/', '_configurator_home');
                    }

                    return array (  '_controller' => 'Sensio\\Bundle\\DistributionBundle\\Controller\\ConfiguratorController::checkAction',  '_route' => '_configurator_home',);
                }

                // _configurator_step
                if (0 === strpos($pathinfo, '/_configurator/step') && preg_match('#^/_configurator/step/(?P<index>[^/]++)$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_configurator_step')), array (  '_controller' => 'Sensio\\Bundle\\DistributionBundle\\Controller\\ConfiguratorController::stepAction',));
                }

                // _configurator_final
                if ($pathinfo === '/_configurator/final') {
                    return array (  '_controller' => 'Sensio\\Bundle\\DistributionBundle\\Controller\\ConfiguratorController::finalAction',  '_route' => '_configurator_final',);
                }

            }

        }

        // freifunk_linksink_default_index
        if (0 === strpos($pathinfo, '/hello') && preg_match('#^/hello/(?P<name>[^/]++)$#s', $pathinfo, $matches)) {
            return $this->mergeDefaults(array_replace($matches, array('_route' => 'freifunk_linksink_default_index')), array (  '_controller' => 'Freifunk\\Bundle\\LinkSinkBundle\\Controller\\DefaultController::indexAction',));
        }

        // 
        if (rtrim($pathinfo, '/') === '') {
            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                $allow = array_merge($allow, array('GET', 'HEAD'));
                goto not_;
            }

            if (substr($pathinfo, -1) !== '/') {
                return $this->redirect($pathinfo.'/', '');
            }

            return array (  '_controller' => 'Freifunk\\Bundle\\LinkSinkBundle\\Controller\\LinkController::indexAction',  '_route' => '',);
        }
        not_:

        // _new
        if ($pathinfo === '/link/neu') {
            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                $allow = array_merge($allow, array('GET', 'HEAD'));
                goto not__new;
            }

            return array (  '_controller' => 'Freifunk\\Bundle\\LinkSinkBundle\\Controller\\LinkController::newAction',  '_route' => '_new',);
        }
        not__new:

        throw 0 < count($allow) ? new MethodNotAllowedException(array_unique($allow)) : new ResourceNotFoundException();
    }
}
