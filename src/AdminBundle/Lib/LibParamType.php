<?php

namespace Mkk\AdminBundle\Lib;

use Mkk\SiteBundle\Lib\LibAbstractType;

abstract class LibParamType extends LibAbstractType
{
    /**
     * {@inheritdoc}
     *
     * @return string
     */
    public function getBlockPrefix(): string
    {
        return 'param';
    }
}
