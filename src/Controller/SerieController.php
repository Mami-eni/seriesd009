<?php

namespace App\Controller;

use App\Entity\Serie;
use App\Form\SerieType;
use App\ManageEntity\UpdateEntity;
use App\Repository\SerieRepository;
use App\Upload\SerieImage;
use Container0kof7Lt\getMaker_Renderer_FormTypeRendererService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
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
     * @Route("/series/detail/{id}", name="serie_detail", requirements= {"page"="\d+"})
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
     * @Route("/series/create", name="serie_create")
     */
    public function create(Request $request, EntityManagerInterface $entityManager, UpdateEntity $updateEntity, SerieImage $image): Response
    {
        $serie = new Serie();
        $serieForm = $this->createForm(SerieType::class, $serie);
        $serie->setDateCreated(new \DateTime());

        $serieForm->handleRequest($request);

      //  $file = $serieForm->get('poster')->getData(); // recuperer info
        //dd($file);

        if($serieForm->isSubmitted() && $serieForm->isValid())
        {//
           //  $serie->setVote('9.5'); // test

           // $entityManager->persist($serie);
            //$entityManager->flush();

            $file = $serieForm->get('poster')->getData();

            // ci-dessous, la variable file est identifiée comme etant un uploadfile

            if($file)
            {
                //$newFileName = $serie->getName().'-'.uniqid().'.'.$file->guessExtension(); // renommage du nom du fichier à sauvegarder
               $directory = $this->getParameter('upload_posters_series_dir');
               $image->save($file, $serie,$directory);
                //$serie->setPoster($newFileName);
            }
            $updateEntity->save($serie); // a la place des lignes du dessus, exemple utilisation d'un service
            $this->addFlash("success", "serie added ! ");

            return $this->redirectToRoute("serie_detail", ['id'=>$serie->getId()]);

        }
        return $this->render('serie/create.html.twig', [
            "form"=>$serieForm->createView()

        ]);
    }

    /**
     * @Route("/series/edit/{id}", name="serie_edit")
     * @param $id
     * @return Response
     */
    public function edit($id, EntityManagerInterface  $entityManager, SerieRepository $serieRepository, Request $request): Response
    {
        $serie = $serieRepository->find($id);
        if(!$serie)
        {
            throw $this->createNotFoundException("this series doesn't exists");
        }
        $serieForm = $this->createForm(SerieType::class, $serie);
        $serieForm->handleRequest($request);

        if($serieForm->isSubmitted() && $serieForm->isValid())
        {
            $entityManager->persist($serie);
            $entityManager->flush();
            $this->addFlash('success','serie edited !!');

            return $this->redirectToRoute('serie_detail', ['id'=>$serie->getId()]);
        }



        return $this->render('serie/edit.html.twig', [
            "serie" => $serie,
            "form" =>$serieForm->createView()
        ]);



    }

    /**
     * @Route("/series/delete/{id}", name="serie_delete")
     * @param $id
     * @return Response
     */
    public function delete($id, EntityManagerInterface  $entityManager, SerieRepository $serieRepository): Response
    {
        $serie = $serieRepository->find($id);
        if(!$serie)
        {
            throw $this->createNotFoundException("this series doesn't exists");
        }

        $entityManager->remove($serie);
        $entityManager->flush();

        return $this->redirectToRoute('main_home');
    }


    /**
     * @Route("/series/detail/ajax-like", name="serie_ajax_like")
     *
     * @return Response
     */
    public function likeOrDislike(Request  $request, EntityManagerInterface  $entityManager, SerieRepository $serieRepository): Response
    {
        // recuperation des données de ma requete
       $data = json_decode($request->getContent());
       $serie_id = $data->serie_id;
       $like = $data->like;

       // instance de la serie en fonction de l'id
       $serie = $serieRepository->find($serie_id);

       if($like==0)
       {
           $serie->setNbLike($serie->getNbLike()-1);
       }

       else{
           $serie->setNbLike($serie->getNbLike() +1);
       }

       // crud
       $entityManager->persist($serie);
       $entityManager->flush();

       return new JsonResponse(['likes'=>$serie->getNbLike()]); // renvoi objet json


    }
}
