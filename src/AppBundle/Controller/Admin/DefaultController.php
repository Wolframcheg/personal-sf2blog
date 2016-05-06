<?php

namespace AppBundle\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/admin37331", name="admin_main_page")
 */

class DefaultController extends Controller
{
    /**
     * @Route("", name="admin_main_page")
     * @Template()
     *
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..')

        ];
    }

}
