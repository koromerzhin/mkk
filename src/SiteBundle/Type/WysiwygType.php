<?php

namespace Mkk\SiteBundle\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;

class WysiwygType extends AbstractType
{
    /**
     * {@inheritdoc}
     *
     * @param FormView      $view    view
     * @param FormInterface $form    form
     * @param array         $options options
     *
     * @return void
     */
    public function buildView(FormView $view, FormInterface $form, array $options): void
    {
        $attr = $options['attr'];
        if (!isset($attr['class'])) {
            $attr['class'] = '';
        }

        $attr['data-url'] = 'scripts.wysiwyg';
        $attr['class']    = trim($attr['class'] . ' wysiwyg');
        if (!isset($attr['rows'])) {
            $attr['rows'] = 10;
        }

        $view->vars['attr'] = $attr;
        unset($form);
    }

    /**
     * {@inheritdoc}
     *
     * @return string
     */
    public function getParent(): string
    {
        return TextareaType::class;
    }
}
