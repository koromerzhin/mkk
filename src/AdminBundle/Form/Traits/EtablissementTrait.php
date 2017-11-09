<?php

namespace Mkk\AdminBundle\Form\Traits;

use Mkk\AdminBundle\Form\Collection\AdressesType;
use Mkk\AdminBundle\Form\Collection\EmailsType;
use Mkk\AdminBundle\Form\Collection\HorairesType;
use Mkk\AdminBundle\Form\Collection\LiensType;
use Mkk\AdminBundle\Form\Collection\TelephonesType;
use Mkk\AdminBundle\Form\Collection\UsersType;
use Mkk\SiteBundle\Type\OuiNonType;
use Mkk\SiteBundle\Type\WysiwygType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;

trait EtablissementTrait
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
            'descriptionactivite',
            WysiwygType::class,
            [
                'label'    => 'Description',
                'required' => FALSE,
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
        $builder->add(
            'adresses',
            Type\CollectionType::class,
            [
                'required'     => FALSE,
                'entry_type'   => AdressesType::class,
                'allow_add'    => TRUE,
                'delete_empty' => TRUE,
                'allow_delete' => TRUE,
                'by_reference' => FALSE,
                'label'        => 'Adresses',
            ]
        );
        $builder->add(
            'users',
            Type\CollectionType::class,
            [
                'required'     => FALSE,
                'entry_type'   => UsersType::class,
                'allow_add'    => FALSE,
                'delete_empty' => TRUE,
                'allow_delete' => FALSE,
                'by_reference' => FALSE,
                'label'        => 'Utilisateurs',
            ]
        );
        $builder->add(
            'liens',
            Type\CollectionType::class,
            [
                'required'     => FALSE,
                'entry_type'   => LiensType::class,
                'allow_add'    => TRUE,
                'delete_empty' => TRUE,
                'allow_delete' => TRUE,
                'by_reference' => FALSE,
                'label'        => 'Liens',
            ]
        );
        $builder->add(
            'horaires',
            Type\CollectionType::class,
            [
                'required'     => FALSE,
                'entry_type'   => HorairesType::class,
                'allow_add'    => TRUE,
                'delete_empty' => FALSE,
                'allow_delete' => TRUE,
                'by_reference' => FALSE,
                'label'        => 'Horaires',
            ]
        );
        $builder->add(
            'emails',
            Type\CollectionType::class,
            [
                'required'     => FALSE,
                'entry_type'   => EmailsType::class,
                'allow_add'    => TRUE,
                'delete_empty' => TRUE,
                'allow_delete' => TRUE,
                'by_reference' => FALSE,
                'label'        => 'Emails',
            ]
        );
        $builder->add(
            'telephones',
            Type\CollectionType::class,
            [
                'required'     => FALSE,
                'entry_type'   => TelephonesType::class,
                'allow_add'    => TRUE,
                'delete_empty' => TRUE,
                'allow_delete' => TRUE,
                'by_reference' => FALSE,
                'label'        => 'Téléphones',
            ]
        );
        $builder->add(
            'directeur',
            Type\TextType::class,
            [
                'label'    => 'Directeur',
                'required' => FALSE,
            ]
        );
        $builder->add(
            'nom',
            Type\TextType::class,
            ['label' => 'Enseigne']
        );
        $builder->add(
            'prefix',
            Type\TextType::class,
            [
                'required' => FALSE,
                'label'    => 'Prefix',
            ]
        );
        $builder->add(
            'alias',
            Type\TextType::class,
            [
                'label'    => 'Alias',
                'required' => FALSE,
            ]
        );
        $builder->add(
            'actif',
            OuiNonType::class,
            [
                'label' => 'Activation sur le site publique',
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
            'descriptionactivite',
            WysiwygType::class,
            [
                'label'    => 'Description',
                'required' => FALSE,
            ]
        );

        $this->addFilevuesEquipe($builder);
        $this->addFileVuesExterne($builder);
        $this->addFileVuesInterne($builder);
        $this->addGalerie($builder);
        $this->addVignette($builder);
        $this->addPdf($builder);
        $this->addCopyright($builder);
        $this->addSecteur($builder);
        $this->addNbSalarie($builder);
        $this->addCa($builder);
        $this->addSiret($builder);
        $this->addApe($builder);
        $this->addTvaIntra($builder);

        unset($options);
    }

    /**
     * addFilevuesEquipe.
     *
     * @param FormBuilderInterface $builder builder
     *
     * @return void
     */
    private function addFilevuesEquipe(FormBuilderInterface $builder): void
    {
        if (isset($this->params['etablissement_mediaphotoequipe']) && 1 === (int) $this->params['etablissement_mediaphotoequipe']) {
            $builder->add(
                'filevuesequipe',
                Type\TextType::class,
                [
                    'required' => FALSE,
                    'label'    => "L'équipe",
                    'attr'     => [
                        'data-upload' => 'admin.enseigne.upload.vuesequipe',
                    ],
                ]
            );
        }
    }

    /**
     * addFileVuesExterne.
     *
     * @param FormBuilderInterface $builder builder
     *
     * @return void
     */
    private function addFileVuesExterne(FormBuilderInterface $builder): void
    {
        if (isset($this->params['etablissement_mediaphotoenexterieur']) && 1 === (int) $this->params['etablissement_mediaphotoenexterieur']) {
            $builder->add(
                'filevuesexterne',
                Type\TextType::class,
                [
                    'required' => FALSE,
                    'label'    => 'En extérieur',
                    'attr'     => [
                        'data-upload' => 'admin.enseigne.upload.vuesexterne',
                    ],
                ]
            );
        }
    }

    /**
     * addFileVuesInterne.
     *
     * @param FormBuilderInterface $builder builder
     *
     * @return void
     */
    private function addFileVuesInterne(FormBuilderInterface $builder): void
    {
        if (isset($this->params['etablissement_mediaphotoeninterieur']) && 1 === (int) $this->params['etablissement_mediaphotoeninterieur']) {
            $builder->add(
                'filevuesinterne',
                Type\TextType::class,
                [
                    'required' => FALSE,
                    'label'    => 'En intérieur',
                    'attr'     => [
                        'data-upload' => 'admin.enseigne.upload.vuesinterne',
                    ],
                ]
            );
        }
    }

    /**
     * addGalerie.
     *
     * @param FormBuilderInterface $builder builder
     *
     * @return void
     */
    private function addGalerie(FormBuilderInterface $builder): void
    {
        if (isset($this->params['etablissement_mediaimages']) && 1 === (int) $this->params['etablissement_mediaimages']) {
            $builder->add(
                'filegalerie',
                Type\TextType::class,
                [
                    'required' => FALSE,
                    'label'    => "Galerie d'images",
                    'attr'     => [
                        'data-upload' => 'admin.enseigne.upload.galerie',
                    ],
                ]
            );
        }
    }

    /**
     * addVignette.
     *
     * @param FormBuilderInterface $builder builder
     *
     * @return void
     */
    private function addVignette(FormBuilderInterface $builder): void
    {
        if (isset($this->params['etablissement_medialogo']) && 1 === (int) $this->params['etablissement_medialogo']) {
            $builder->add(
                'filevignette',
                Type\TextType::class,
                [
                    'required' => FALSE,
                    'label'    => 'Logo',
                    'attr'     => [
                        'data-upload' => 'admin.enseigne.upload.vignette',
                    ],
                ]
            );
        }
    }

    /**
     * addPdf.
     *
     * @param FormBuilderInterface $builder builder
     *
     * @return void
     */
    private function addPdf(FormBuilderInterface $builder): void
    {
        if (isset($this->params['etablissement_factures']) && 1 === (int) $this->params['etablissement_factures']) {
            $builder->add(
                'filepdf',
                Type\TextType::class,
                [
                    'required' => FALSE,
                    'label'    => 'Pdf',
                    'attr'     => [
                        'data-upload' => 'admin.enseigne.upload.pdf',
                    ],
                ]
            );
        }
    }

    /**
     * addCopyright.
     *
     * @param FormBuilderInterface $builder builder
     *
     * @return void
     */
    private function addCopyright(FormBuilderInterface $builder): void
    {
        if (isset($this->params['etablissement_mediaimages']) and 1 === (int) $this->params['etablissement_mediaimages']) {
            $builder->add(
                'copyright',
                WysiwygType::class,
                [
                    'label'    => 'Copyright',
                    'required' => FALSE,
                ]
            );
        }
    }

    /**
     * addSecteur.
     *
     * @param FormBuilderInterface $builder builder
     *
     * @return void
     */
    private function addSecteur(FormBuilderInterface $builder): void
    {
        if (isset($this->params['etablissement_secteur']) and 1 === (int) $this->params['etablissement_secteur']) {
            $builder->add(
                'nafsousclasse',
                Type\TextType::class,
                [
                    'label'    => 'Code NAF',
                    'required' => FALSE,
                    'attr'     => [
                        'placeholder' => 'Code NAF',
                        'data-url'    => 'admin.enseigne.search.nafsousclasse',
                    ],
                ]
            );
            $builder->add(
                'activite',
                Type\TextType::class,
                [
                    'label'    => 'Activité',
                    'required' => FALSE,
                    'attr'     => [
                        'placeholder' => 'Activité',
                    ],
                ]
            );
        }
    }

    /**
     * addNbSalarie.
     *
     * @param FormBuilderInterface $builder builder
     *
     * @return void
     */
    private function addNbSalarie(FormBuilderInterface $builder): void
    {
        if (isset($this->params['etablissement_nbrsalarie']) and 1 === (int) $this->params['etablissement_nbrsalarie']) {
            $builder->add(
                'nbsalarie',
                Type\IntegerType::class,
                [
                    'attr'     => ['min' => 0],
                    'label'    => 'Nombre de salariés',
                    'required' => FALSE,
                ]
            );
        }
    }

    /**
     * addCa.
     *
     * @param FormBuilderInterface $builder builder
     *
     * @return void
     */
    private function addCa(FormBuilderInterface $builder): void
    {
        if (isset($this->params['etablissement_ca']) and 1 === (int) $this->params['etablissement_ca']) {
            $builder->add(
                'ca',
                Type\TextType::class,
                [
                    'label'    => 'Chiffre d\'affaire',
                    'required' => FALSE,
                ]
            );
        }
    }

    /**
     * addSiret.
     *
     * @param FormBuilderInterface $builder builder
     *
     * @return void
     */
    private function addSiret(FormBuilderInterface $builder): void
    {
        if (isset($this->params['etablissement_siret']) and 1 === (int) $this->params['etablissement_siret']) {
            $builder->add(
                'siret',
                Type\TextType::class,
                [
                    'label'    => 'N° de SIRET',
                    'required' => FALSE,
                ]
            );
        }
    }

    /**
     * addApe.
     *
     * @param FormBuilderInterface $builder builder
     *
     * @return void
     */
    private function addApe(FormBuilderInterface $builder): void
    {
        if (isset($this->params['etablissement_ape']) and 1 === (int) $this->params['etablissement_ape']) {
            $builder->add(
                'ape',
                Type\TextType::class,
                [
                    'label'    => 'APE',
                    'required' => FALSE,
                ]
            );
        }
    }

    /**
     * addTvaIntra.
     *
     * @param FormBuilderInterface $builder builder
     *
     * @return void
     */
    private function addTvaIntra(FormBuilderInterface $builder): void
    {
        if (isset($this->params['etablissement_tva']) and 1 === (int) $this->params['etablissement_tva']) {
            $builder->add(
                'tvaintra',
                Type\TextType::class,
                [
                    'label'    => 'N° TVA intracommunautaire',
                    'required' => FALSE,
                ]
            );
        }
    }
}
