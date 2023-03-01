<?php

namespace App\Controller;

use App\Repository\ReviewRepository;
use App\Repository\RoomRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(RoomRepository $rr, ReviewRepository $rvr): Response
    {

        $rooms = $rr->findAll();
        $reviews = $rvr->findAll();

//        echo "<pre>";
//        echo var_dump($rooms);
//        echo "</pre>";
//        die();

        return $this->render('home/index.html.twig', [
            'rooms' => $rooms,
            'reviews'=>$reviews
        ]);
    }
}
