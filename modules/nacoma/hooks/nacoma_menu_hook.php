<?php

  Event::add('ninja.menu.setup', function () {

    $auth = Auth::instance();
    $menu = Event::$data;

    if (op5MayI::instance()->run('ninja.configuration:read') && Kohana::config('config.nacoma_path') !== false) {

      $menu->set('Manage', null, 4, 'icon-16 x16-configuration', array('style' => 'margin-top: 8px'));

      $menu->set('Manage.Configure', 'configuration/configure', 0, 'icon-16 x16-nacoma');

    }

  });