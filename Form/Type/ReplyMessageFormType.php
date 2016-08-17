<?php

namespace Archer\ClickatellBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * User: andrey
 * Date: 23.10.12
 * Time: 16:50.
 */
class ReplyMessageFormType extends AbstractType
{
    private $class;

    public function __construct($class)
    {
        $this->class = $class;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('text', 'textarea', array('label' => 'message.message', 'trim' => true, 'translation_domain' => 'ArcherClickatellBundle', 'required' => true, 'attr' => array('maxlength' => 5599, 'class' => 'input-xlarge')));
    }

    public function getName()
    {
        return 'clickatell_reply_message';
    }

    public function setDefaultOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => $this->class,
        ));
    }
}
