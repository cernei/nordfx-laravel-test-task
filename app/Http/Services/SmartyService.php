<?php

namespace App\Http\Services;

use Smarty;

class SmartyService
{
    private static $instance = NULL;

    public function getInstance() {
        if (!isset(self::$instance)) {
            $smarty = new Smarty();
            $smarty->setTemplateDir(base_path() . '/resources/views/templates');
            $smarty->setConfigDir(base_path() . '/resources/views/config');
            $smarty->setCompileDir(base_path() . '/resources/views/compile');
            $smarty->setCacheDir(base_path() . '/resources/views/cache');

            self::$instance = $smarty;
        }

        return self::$instance;
    }

}
