<?php

namespace App\Controller;

use App\Repository\HotelContactRepository;
use App\Repository\ReviewRepository;
use App\Repository\RoomRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(RoomRepository $rr, ReviewRepository $rvr, HotelContactRepository $hcr): Response
    {

        $rooms = $rr->findAll();
        $reviews = $rvr->findAll();
        $hotelContact = $hcr->findAll();

        $phone = $hotelContact[0]->getPhone();
        $email = $hotelContact[0]->getEmail();
        $address = $hotelContact[0]->getAddress();

//        echo "<pre>";
//        echo var_dump($phone);
//        echo "</pre>";
//        die();

        return $this->render('home/index.html.twig', [
            'rooms' => $rooms,
            'reviews'=>$reviews,
            'email'=>$email,
            'phone'=>$phone,
            'address'=>$address
        ]);
    }
}
