<?php

namespace Mkk\AdminBundle\Form\Param;

use Mkk\AdminBundle\Lib\LibParamType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;

class TinymceType extends LibParamType
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
        $container       = $this->container;
        $groups          = [];
        $groupManager    = $container->get('bdd.group_manager');
        $groupRepository = $groupManager->getRepository();
        $data            = $groupRepository->findall();
        foreach ($data as $group) {
            $id       = $group->getId();
            $nom      = $group->getNom();
            $groups[] = [$nom => $id];
        }

        $builder->add(
            'tinymce_filemanageracces',
            Type\ChoiceType::class,
            [
                'required' => FALSE,
                'expanded' => TRUE,
                'label'    => '  ',
                'multiple' => TRUE,
                'choices'  => $groups,
            ]
        );
        unset($options);
    }
}
