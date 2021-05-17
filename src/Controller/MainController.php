<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class MainController
 * @package App\Controller
 */
class MainController extends AbstractController
{
    /**
     * @Route("/", name ="main_home")
     */

    public function home()
    {
        die("coucou");
    }

    /**
     * @Route("/test", name ="main_test")
     */

    public function test()
    {
        die("test");
    }

}