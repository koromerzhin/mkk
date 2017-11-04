<?php

namespace Mkk\AdminBundle\Form\Param;

use Mkk\AdminBundle\Lib\LibParamType;
use Mkk\SiteBundle\Type\WysiwygType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;

class TableaubordType extends LibParamType
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
        $manager    = $this->container->get('bdd.group_manager');
        $repository = $manager->getRepository();
        $groups     = $repository->findAll();
        if (isset($this->params['group_connect'])) {
            $connect = $this->params['group_connect'];
            foreach ($connect as $idGroup) {
                $group = '';
                foreach ($groups as $row) {
                    if ($row->getId() === $idGroup) {
                        $group = $row->getNom();
                        break;
                    }
                }

                $builder->add(
                    "groupbord_{$idGroup}_accueil",
                    Type\TextType::class,
                    [
                        'label' => $group,
                    ]
                );
            }
        }

        $builder->add(
            'messageaccueil',
            WysiwygType::class,
            [
                'label'    => "Message d'accueil",
                'required' => FALSE,
            ]
        );
        unset($options);
    }
}
