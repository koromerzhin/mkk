<?php

namespace Mkk\AdminBundle\Widget;

use Mkk\AdminBundle\Lib\LibWidget;

class BookmarkWidget extends LibWidget
{
    /**
     * Init Widget.
     *
     * @return void
     */
    public function init(): void
    {
        $this->manager = $this->container->get('bdd.bookmark_manager');
        $this->url     = [
            'show' => 'admin.bookmark.form',
            'new'  => 'admin.bookmark.form',
            'list' => 'admin.bookmark.index',
        ];

        $this->list  = 1;
        $this->titre = 'Bookmark';
    }
}
