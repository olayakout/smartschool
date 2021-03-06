<?php

namespace Acme\DemoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class LinkType extends AbstractType
{
	    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title','text');
        $builder->add('url', 'text');
        $builder->add('about','textarea');

        
        $builder->add('submit','submit');
    }

    public function getName()
    {
        return 'link';
    }
}
