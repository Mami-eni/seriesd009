<?php

namespace App\Controller;

use App\Entity\Serie;
use App\Form\SerieType;
use App\Repository\SerieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SerieController extends AbstractController
{
    /**
     * @Route("/series/{page}", name="serie_list", requirements= {"page"="\d+"})
     */
    public function list(int $page= 1,SerieRepository  $serieRepository): Response
    {
       // $serie = "Le monde perdu";
      //  dump($serie);

        //$series = $serieRepository->findAll();
        $serieVote = $serieRepository->findBy([], ["vote"=>"DESC"],50);
        //dump($series);

        $series = $serieRepository->findBestSeries($page);

        $nbSeries = $serieRepository->count([]);
        $maxPage = ceil ($nbSeries/10);




        return $this->render('serie/list.html.twig', ["series"=>$series, "currentPage"=> $page, "maxPage"=>$maxPage

        ]);
    }

    /**
     * @Route("/series/detail/{id}", name="serie_detail")
     * @param $id
     * @return Response
     */
    public function detail($id, SerieRepository  $serieRepository): Response
    {
        $serie = $serieRepository->find($id);
        if(!$serie)
        {
            throw $this->createNotFoundException("this series doesn't exists");
        }

        dump($id);
        return $this->render('serie/detail.html.twig', [ "serie"=>$serie

        ]);
    }

    /**
     * @Route("/series/create/", name="serie_create")
     */
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $serie = new Serie();
        $serieForm = $this->createForm(SerieType::class, $serie);
        $serie->setDateCreated(new \DateTime());

        $serieForm->handleRequest($request);

        if($serieForm->isSubmitted() && $serieForm->isValid())
        {
            $entityManager->persist($serie);
            $entityManager->flush();
            $this->addFlash("success", "serie added ! ");

            return $this->redirectToRoute("serie_detail", ['id'=>$serie->getId()]);

        }
        return $this->render('serie/create.html.twig', [
            "form"=>$serieForm->createView()

        ]);
    }
}
