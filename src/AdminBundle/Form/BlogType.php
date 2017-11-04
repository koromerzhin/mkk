<?php

namespace Mkk\AdminBundle\Form;

use Mkk\SiteBundle\Lib\LibAbstractType;
use Mkk\SiteBundle\Type\OuiNonType;
use Mkk\SiteBundle\Type\WysiwygType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Intl\Intl;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BlogType extends LibAbstractType
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
            'envoyer',
            Type\SubmitType::class
        );
        $builder->add(
            'filevignette',
            Type\TextType::class,
            [
                'required' => FALSE,
                'label'    => 'Vignette',
                'attr'     => [
                    'data-upload' => 'admin.blog.upload.vignette',
                ],
            ]
        );
        $builder->add(
            'filegalerie',
            Type\TextType::class,
            [
                'required' => FALSE,
                'label'    => 'Vignette',
                'attr'     => [
                    'data-upload' => 'admin.blog.upload.galerie',
                ],
            ]
        );
        $builder->add(
            'fileimage',
            Type\TextType::class,
            [
                'required' => FALSE,
                'label'    => 'Image',
                'attr'     => [
                    'data-upload' => 'admin.blog.upload.image',
                ],
            ]
        );
        $builder->add(
            'titre',
            Type\TextType::class,
            [
                'label' => 'Titre',
                'attr'  => ['placeholder' => 'Titre'],
            ]
        );
        $languedispo = [];
        $langues     = Intl::getLanguageBundle()->getLanguageNames('fr');
        foreach ($this->params['languesite'] as $code) {
            $name               = $langues[$code];
            $languedispo[$name] = $code;
        }

        $builder->add(
            'langue',
            Type\LanguageType::class,
            [
                'label'       => 'Langue',
                'placeholder' => 'Langue',
                'choices'     => $languedispo,
            ]
        );
        $builder->add(
            'commentaire',
            OuiNonType::class,
            [
                'label' => 'Commentaire activé',
            ]
        );
        $builder->add(
            'actif_public',
            OuiNonType::class,
            [
                'label' => 'Article publié',
            ]
        );
        $builder->add(
            'datepublication',
            Type\TextType::class,
            [
                'required' => FALSE,
                'label'    => 'Date de publication',
                'attr'     => ['placeholder' => 'Date de publication'],
            ]
        );
        $builder->add(
            'alias',
            Type\TextType::class,
            [
                'label'    => 'Alias',
                'attr'     => ['placeholder' => 'Alias'],
                'required' => FALSE,
            ]
        );
        $builder->add(
            'contenu',
            WysiwygType::class,
            [
                'label'    => 'Contenu',
                'required' => FALSE,
            ]
        );
        $builder->add(
            'intro',
            WysiwygType::class,
            [
                'label'    => 'Intro',
                'required' => FALSE,
            ]
        );
        $builder->add(
            'video',
            Type\UrlType::class,
            [
                'label'    => 'Lien vidéo (Youtube / Viméo / Dailymotion)',
                'required' => FALSE,
            ]
        );
        $builder->add(
            'tag',
            Type\TextType::class,
            [
                'label'    => 'Tags',
                'attr'     => ['placeholder' => 'Tags'],
                'mapped'   => FALSE,
                'required' => FALSE,
            ]
        );
        $builder->add(
            'categorie',
            Type\TextType::class,
            [
                'label'    => 'Catégorie',
                'required' => TRUE,
                'attr'     => [
                    'placeholder' => 'Catégorie',
                    'data-url'    => 'admin.blog.search.categorie',
                ],
            ]
        );
        $builder->add(
            'user',
            Type\TextType::class,
            [
                'label' => 'Rédacteur',
                'attr'  => [
                    'placeholder' => 'Rédacteur',
                    'data-url'    => 'admin.blog.search.redacteur',
                ],
            ]
        );
        $builder->add(
            'redacteur',
            OuiNonType::class,
            [
                'label' => 'Afficher le rédacteur',
            ]
        );
        $builder->add(
            'meta_description',
            Type\TextType::class,
            [
                'required' => FALSE,
                'label'    => 'Description',
            ]
        );
        $builder->add(
            'meta_keywords',
            Type\TextType::class,
            [
                'required' => FALSE,
                'label'    => 'Mots clefs',
            ]
        );
        unset($options);
    }

    /**
     * {@inheritdoc}
     *
     * @param OptionsResolver $resolver champs obligatoire lié a symfony
     *
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $namespace = $this->namespace;
        $resolver->setDefaults(
            [
                'data_class' => "{$namespace}\SiteBundle\Entity\Blog",
            ]
        );
    }

    /**
     * {@inheritdoc}
     *
     * @return string
     */
    public function getBlockPrefix(): string
    {
        return 'blog';
    }
}
