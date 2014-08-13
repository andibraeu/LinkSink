<?php

/* FreifunkLinkSinkBundle::layout.html.twig */
class __TwigTemplate_c79244e6cfe056ffee91d086148a723e8c8811ec7b81fd2f11851843978664ab extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'css' => array($this, 'block_css'),
            'body' => array($this, 'block_body'),
            'javascripts' => array($this, 'block_javascripts'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<!DOCTYPE html>
<html>
<head>

    <title>";
        // line 5
        $this->displayBlock('title', $context, $blocks);
        echo "</title>
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
    <!-- Bootstrap -->
    <link href='//fonts.googleapis.com/css?family=Roboto:400,700' rel='stylesheet' type='text/css'>
    ";
        // line 9
        if (isset($context['assetic']['debug']) && $context['assetic']['debug']) {
            // asset "5ec667a_0"
            $context["asset_url"] = isset($context['assetic']['use_controller']) && $context['assetic']['use_controller'] ? $this->env->getExtension('routing')->getPath("_assetic_5ec667a_0") : $this->env->getExtension('assets')->getAssetUrl("_controller/css/5ec667a_main_1.css");
            // line 14
            echo "    <link rel=\"stylesheet\" href=\"";
            echo twig_escape_filter($this->env, (isset($context["asset_url"]) ? $context["asset_url"] : $this->getContext($context, "asset_url")), "html", null, true);
            echo "\" media=\"screen\" />
    ";
            // asset "5ec667a_1"
            $context["asset_url"] = isset($context['assetic']['use_controller']) && $context['assetic']['use_controller'] ? $this->env->getExtension('routing')->getPath("_assetic_5ec667a_1") : $this->env->getExtension('assets')->getAssetUrl("_controller/css/5ec667a_semantic_2.css");
            echo "    <link rel=\"stylesheet\" href=\"";
            echo twig_escape_filter($this->env, (isset($context["asset_url"]) ? $context["asset_url"] : $this->getContext($context, "asset_url")), "html", null, true);
            echo "\" media=\"screen\" />
    ";
            // asset "5ec667a_2"
            $context["asset_url"] = isset($context['assetic']['use_controller']) && $context['assetic']['use_controller'] ? $this->env->getExtension('routing')->getPath("_assetic_5ec667a_2") : $this->env->getExtension('assets')->getAssetUrl("_controller/css/5ec667a_custom_3.css");
            echo "    <link rel=\"stylesheet\" href=\"";
            echo twig_escape_filter($this->env, (isset($context["asset_url"]) ? $context["asset_url"] : $this->getContext($context, "asset_url")), "html", null, true);
            echo "\" media=\"screen\" />
    ";
        } else {
            // asset "5ec667a"
            $context["asset_url"] = isset($context['assetic']['use_controller']) && $context['assetic']['use_controller'] ? $this->env->getExtension('routing')->getPath("_assetic_5ec667a") : $this->env->getExtension('assets')->getAssetUrl("_controller/css/5ec667a.css");
            echo "    <link rel=\"stylesheet\" href=\"";
            echo twig_escape_filter($this->env, (isset($context["asset_url"]) ? $context["asset_url"] : $this->getContext($context, "asset_url")), "html", null, true);
            echo "\" media=\"screen\" />
    ";
        }
        unset($context["asset_url"]);
        // line 16
        echo "    ";
        $this->displayBlock('css', $context, $blocks);
        // line 19
        echo "
</head>

<body>
";
        // line 23
        $this->env->loadTemplate("FreifunkLinkSinkBundle::navigation.html.twig")->display($context);
        // line 24
        echo "
<div class=\"ui one column page grid\">
    <div class=\"column\">
        <div id=\"mission-statement\" class=\"ui message green\">
            ";
        // line 28
        if (isset($context['assetic']['debug']) && $context['assetic']['debug']) {
            // asset "3c038e0_0"
            $context["asset_url"] = isset($context['assetic']['use_controller']) && $context['assetic']['use_controller'] ? $this->env->getExtension('routing')->getPath("_assetic_3c038e0_0") : $this->env->getExtension('assets')->getAssetUrl("_controller/images/3c038e0_logo_1.png");
            // line 29
            echo "            ";
        } else {
            // asset "3c038e0"
            $context["asset_url"] = isset($context['assetic']['use_controller']) && $context['assetic']['use_controller'] ? $this->env->getExtension('routing')->getPath("_assetic_3c038e0") : $this->env->getExtension('assets')->getAssetUrl("_controller/images/3c038e0.png");
            echo "            ";
        }
        unset($context["asset_url"]);
        // line 30
        echo "        </div>
    </div>
</div>

<div id=\"main\" class=\"segment\">
    ";
        // line 35
        $this->displayBlock('body', $context, $blocks);
        // line 36
        echo "</div>
<!-- jQuery (necessary for Bootstraps JavaScript plugins) -->
<script src=\"";
        // line 38
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("js/jquery.js"), "html", null, true);
        echo "\"></script>
<!-- Include all JavaScripts, compiled by Assetic -->
<script src=\"";
        // line 40
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("js/semantic.js"), "html", null, true);
        echo "\"></script>
";
        // line 41
        $this->displayBlock('javascripts', $context, $blocks);
        // line 42
        echo "</body>
</html>
";
    }

    // line 5
    public function block_title($context, array $blocks = array())
    {
        echo "Linkverwaltung Freifunk LinkSink";
    }

    // line 16
    public function block_css($context, array $blocks = array())
    {
        // line 17
        echo "
    ";
    }

    // line 35
    public function block_body($context, array $blocks = array())
    {
    }

    // line 41
    public function block_javascripts($context, array $blocks = array())
    {
    }

    public function getTemplateName()
    {
        return "FreifunkLinkSinkBundle::layout.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  144 => 41,  139 => 35,  134 => 17,  131 => 16,  125 => 5,  119 => 42,  117 => 41,  113 => 40,  108 => 38,  104 => 36,  102 => 35,  95 => 30,  83 => 28,  77 => 24,  75 => 23,  69 => 19,  66 => 16,  40 => 14,  36 => 9,  29 => 5,  23 => 1,  120 => 34,  111 => 32,  107 => 31,  100 => 26,  93 => 25,  87 => 29,  81 => 20,  78 => 19,  62 => 15,  57 => 12,  54 => 11,  38 => 7,  33 => 4,  30 => 3,);
    }
}
