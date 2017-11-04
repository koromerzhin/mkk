<?php

namespace Mkk\AdminBundle\Form\Param;

use Mkk\AdminBundle\Form\Collection\UploadsType;
use Mkk\AdminBundle\Lib\LibParamType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;

class UploadType extends LibParamType
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
            'upload',
            Type\CollectionType::class,
            [
                'required'     => FALSE,
                'entry_type'   => UploadsType::class,
                'allow_add'    => FALSE,
                'delete_empty' => TRUE,
                'allow_delete' => FALSE,
                'label'        => 'Upload',
            ]
        );
        unset($options);
    }
}
