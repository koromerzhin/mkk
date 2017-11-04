<?php

namespace Mkk\AdminBundle\Form\Param;

use Mkk\AdminBundle\Lib\LibParamType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;

class BddType extends LibParamType
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
        $groupscontact = [];
        $container     = $this->container;
        if (isset($this->params['group_contacts'])) {
            $groupscontact = $this->params['group_contacts'];
        }

        $groups          = [];
        $groupManager    = $container->get('bdd.group_manager');
        $groupRepository = $groupManager->getRepository();
        $data            = $groupRepository->findall();
        foreach ($data as $group) {
            $id       = $group->getId();
            $groups[] = [
                $id => $group->getNom(),
            ];
        }

        if (0 !== count($groupscontact)) {
            $groupscontact = implode(',', $groupscontact);

            $builder->add(
                'groupcontactdefault',
                Type\TextType::class,
                [
                    'label' => 'Groupe de contact par défaut',
                    'attr'  => [
                        'placeholder' => 'Choisir le groupe contact par défaut',
                        'data-url'    => 'admin.param.search.group',
                        'data-uri'    => 1,
                    ],
                ]
            );
        }

        $builder->add(
            'group_utilisateurs',
            Type\ChoiceType::class,
            [
                'required' => FALSE,
                'expanded' => TRUE,
                'label'    => 'Utilisateurs',
                'multiple' => TRUE,
                'choices'  => $groups,
            ]
        );
        $builder->add(
            'group_connect',
            Type\ChoiceType::class,
            [
                'required' => FALSE,
                'expanded' => TRUE,
                'label'    => 'Utilisateurs',
                'multiple' => TRUE,
                'choices'  => $groups,
            ]
        );
        $builder->add(
            'group_contacts',
            Type\ChoiceType::class,
            [
                'required' => FALSE,
                'expanded' => TRUE,
                'label'    => 'Contacts',
                'multiple' => TRUE,
                'choices'  => $groups,
            ]
        );
        $builder->add(
            'group_responsables',
            Type\ChoiceType::class,
            [
                'required' => FALSE,
                'expanded' => TRUE,
                'label'    => 'Responsables',
                'multiple' => TRUE,
                'choices'  => $groups,
            ]
        );
        unset($options);
    }
}
