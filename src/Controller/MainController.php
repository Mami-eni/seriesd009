<?php


namespace App\Controller;


use App\Entity\Serie;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\DateTime;

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
        $series = ["armand" => "nom", "Normand"=>"nom", "Age"=>23];
        return $this->render("main/home.html.twig", ["serie"=>$series]);

        //die("coucou");
    }

    /**
     * @Route("/test", name ="main_test")
     */

    public function test(EntityManagerInterface $entityManager)
    {
        $serie = new Serie();
        $serie1 = new Serie();
        $serie->setBackdrop("frefrgrrtg")
            ->setDateCreated(new \DateTime())
            ->setFirstAirDate(new \DateTime("-1 year"))
            ->setLastAirDate(new \DateTime("-6 month"))
            ->setGenre("western")
            ->setName("Lucky luke")
            ->setPopularity(100.0)
            ->setPoster("hdezhflhrg")
            ->setStatus("returning")
            ->setTmdbId(125426)
            ->setVote(9.8);
        $serie1->setBackdrop("frefrgrrtg")
            ->setDateCreated(new \DateTime())
            ->setFirstAirDate(new \DateTime("-1 year"))
            ->setLastAirDate(new \DateTime("-6 month"))
            ->setGenre("western")
            ->setName("only luke")
            ->setPopularity(100.0)
            ->setPoster("hdezhflhrg")
            ->setStatus("returning")
            ->setTmdbId(125426)
            ->setVote(9.8);
        dump($serie);
        //$entityManager->persist($serie);
        //$entityManager->flush();

       // $entityManager->remove($serie1);
       // $entityManager->flush();

           // $entityManager = $this->getDoctrine()->getManager();
        return $this->render("main/test.html.twig");
       // die("test");
    }



}