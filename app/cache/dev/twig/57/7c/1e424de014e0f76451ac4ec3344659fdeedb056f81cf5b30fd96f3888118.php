<?php

/* FreifunkLinkSinkBundle:Link:index.html.twig */
class __TwigTemplate_577c1e424de014e0f76451ac4ec3344659fdeedb056f81cf5b30fd96f3888118 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = $this->env->loadTemplate("FreifunkLinkSinkBundle::layout.html.twig");

        $this->blocks = array(
            'css' => array($this, 'block_css'),
            'javascripts' => array($this, 'block_javascripts'),
            'body' => array($this, 'block_body'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "FreifunkLinkSinkBundle::layout.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_css($context, array $blocks = array())
    {
        // line 4
        echo "    ";
        if (isset($context['assetic']['debug']) && $context['assetic']['debug']) {
            // asset "c723f46_0"
            $context["asset_url"] = isset($context['assetic']['use_controller']) && $context['assetic']['use_controller'] ? $this->env->getExtension('routing')->getPath("_assetic_c723f46_0") : $this->env->getExtension('assets')->getAssetUrl("_controller/css/c723f46_links_1.css");
            // line 7
            echo "        <link rel=\"stylesheet\" href=\"";
            echo twig_escape_filter($this->env, (isset($context["asset_url"]) ? $context["asset_url"] : $this->getContext($context, "asset_url")), "html", null, true);
            echo "\" />
    ";
        } else {
            // asset "c723f46"
            $context["asset_url"] = isset($context['assetic']['use_controller']) && $context['assetic']['use_controller'] ? $this->env->getExtension('routing')->getPath("_assetic_c723f46") : $this->env->getExtension('assets')->getAssetUrl("_controller/css/c723f46.css");
            echo "        <link rel=\"stylesheet\" href=\"";
            echo twig_escape_filter($this->env, (isset($context["asset_url"]) ? $context["asset_url"] : $this->getContext($context, "asset_url")), "html", null, true);
            echo "\" />
    ";
        }
        unset($context["asset_url"]);
    }

    // line 11
    public function block_javascripts($context, array $blocks = array())
    {
        // line 12
        echo "    ";
        if (isset($context['assetic']['debug']) && $context['assetic']['debug']) {
            // asset "9ecf862_0"
            $context["asset_url"] = isset($context['assetic']['use_controller']) && $context['assetic']['use_controller'] ? $this->env->getExtension('routing')->getPath("_assetic_9ecf862_0") : $this->env->getExtension('assets')->getAssetUrl("_controller/js/9ecf862_events_1.js");
            // line 15
            echo "    <script src=\"";
            echo twig_escape_filter($this->env, (isset($context["asset_url"]) ? $context["asset_url"] : $this->getContext($context, "asset_url")), "html", null, true);
            echo "\"></script>
    ";
        } else {
            // asset "9ecf862"
            $context["asset_url"] = isset($context['assetic']['use_controller']) && $context['assetic']['use_controller'] ? $this->env->getExtension('routing')->getPath("_assetic_9ecf862") : $this->env->getExtension('assets')->getAssetUrl("_controller/js/9ecf862.js");
            echo "    <script src=\"";
            echo twig_escape_filter($this->env, (isset($context["asset_url"]) ? $context["asset_url"] : $this->getContext($context, "asset_url")), "html", null, true);
            echo "\"></script>
    ";
        }
        unset($context["asset_url"]);
    }

    // line 19
    public function block_body($context, array $blocks = array())
    {
        // line 20
        echo "<div class=\"ui one column page grid title\">
        <div class=\"ui column\">
            <h1>
                Links 
                ";
        // line 24
        if (((array_key_exists("tag", $context)) ? (_twig_default_filter((isset($context["tag"]) ? $context["tag"] : $this->getContext($context, "tag")), false)) : (false))) {
            echo " für Tag „";
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["tag"]) ? $context["tag"] : $this->getContext($context, "tag")), "name"), "html", null, true);
            echo "“";
        }
        // line 25
        echo "                ";
        if (((array_key_exists("location", $context)) ? (_twig_default_filter((isset($context["location"]) ? $context["location"] : $this->getContext($context, "location")), false)) : (false))) {
            echo " für Ort „";
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["location"]) ? $context["location"] : $this->getContext($context, "location")), "name"), "html", null, true);
            echo "“";
        }
        // line 26
        echo "            </h1>
        </div>
    </div>

    <div class=\"ui three column page grid stackable\">
        ";
        // line 31
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["entities"]) ? $context["entities"] : $this->getContext($context, "entities")));
        foreach ($context['_seq'] as $context["_key"] => $context["entity"]) {
            // line 32
            echo "            ";
            echo twig_include($this->env, $context, "FreifunkLinkSinkBundle:Link:event_box.html.twig", array("truncate_summary" => true));
            echo "
        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['entity'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 34
        echo "    </div>

";
    }

    public function getTemplateName()
    {
        return "FreifunkLinkSinkBundle:Link:index.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  120 => 34,  111 => 32,  107 => 31,  100 => 26,  93 => 25,  87 => 24,  81 => 20,  78 => 19,  62 => 15,  57 => 12,  54 => 11,  38 => 7,  33 => 4,  30 => 3,);
    }
}
