<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AdminController
 * @Route ("/admin", name= "admin_")
 */

class AdminController extends AbstractController
{
    /**
     * @Route("", name="main")
     */
    public function main(): Response
    {
        return $this->render('admin/main.html.twig', [

        ]);
    }
}
