<?php

declare(strict_types=1);

namespace App\Controllers;

use Framework\TemplateEngine;
use App\Config\Paths;
use Framework\App;

class AboutController
{

    public function __construct(private TemplateEngine $view)
    {
    }

    public function about()
    {
        echo $this->view->render('/about.php', [
            #'title' => 'About Page'
        ]);
    }
}
