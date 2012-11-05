<?php

namespace Archer\ClickatellBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SendMessageFormType extends AbstractType {

    private $class;

    public function __construct($class) {
        $this->class = $class;
    }

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('toPhone', 'integer', array('label' => 'message.to', 'translation_domain' => 'ArcherClickatellBundle'))
                ->add('text', 'textarea', array('label' => 'message.message', 'translation_domain' => 'ArcherClickatellBundle'));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => $this->class,
        ));
    }

    public function getName() {
        return 'clickatell_send_message';
    }

}
