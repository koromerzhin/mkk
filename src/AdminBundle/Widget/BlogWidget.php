<?php

namespace Mkk\AdminBundle\Widget;

use Mkk\AdminBundle\Lib\LibWidget;

class BlogWidget extends LibWidget
{
    /**
     * Init Widget.
     *
     * @return void
     */
    public function init(): void
    {
        $this->manager = $this->container->get('bdd.blog_manager');
        $this->url     = [
            'show' => 'admin.blog.form',
            'new'  => 'admin.blog.form',
            'list' => 'admin.blog.index',
        ];

        $this->list  = 1;
        $this->titre = 'Blog';
    }
}
