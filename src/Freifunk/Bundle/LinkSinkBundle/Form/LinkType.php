<?php
/**
 * Created by PhpStorm.
 * User: andi
 * Date: 15.08.14
 * Time: 10:46
 */

namespace Freifunk\Bundle\LinkSinkBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class LinkType extends AbstractType {
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('pubdate')
            ->add('guid')
            ->add('description')
            ->add('title')
            ->add('url')
            ->add('enclosure')
            ->add('tags')
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Freifunk\Bundle\LinkSinkBundle\Entity\Link'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'freifunk_bundle_linksinkbundle_link';
    }
}