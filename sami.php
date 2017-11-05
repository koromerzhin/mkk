<?php
use Sami\Sami;
use Sami\Version\GitVersionCollection;
use Symfony\Component\Finder\Finder;
$iterator = Finder::create()
    ->files()
    ->name('*.php')
    ->exclude('Resources')
    ->in($dir = 'src')
;
return new Sami($iterator, array(
    'title'                => 'Mkk',
    'build_dir'            => __DIR__.'/../doc/mkk/',
    'cache_dir'            => __DIR__.'/../cache/%version%',
    // use a custom theme directory
    'default_opened_level' => 2,
));
