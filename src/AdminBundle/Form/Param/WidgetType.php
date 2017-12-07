<?php

namespace Mkk\AdminBundle\Form\Param;

use Mkk\AdminBundle\Form\Collection\WidgetsType;
use Mkk\AdminBundle\Lib\LibParamType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;

class WidgetType extends LibParamType
{
    /**
     * Description of what this does.
     *
     * @param FormBuilderInterface $builder champs obligatoire lié a symfony
     * @param array                $options data de configureOptions();
     *
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add(
            'submit',
            Type\SubmitType::class
        );
        $builder->add(
            'widget_show',
            Type\CollectionType::class,
            [
                'required'     => FALSE,
                'entry_type'   => WidgetsType::class,
                'allow_add'    => TRUE,
                'delete_empty' => TRUE,
                'allow_delete' => FALSE,
                'label'        => 'Par groupes utilisateurs',
            ]
        );
        unset($options);
    }
}
