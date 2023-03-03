<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Repository\RoomRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BookingController extends AbstractController
{
    #[Route('/booking', name: 'booking')]
    public function index(Request $request, RoomRepository $rr): Response
    {
        if($request->isMethod('POST')) {
            //save data
            $name = $request->request->get('name');
            $email = $request->request->get('email');
            $checkIn = $request->request->get('checkin');
            $checkOut = $request->request->get('checkout');
            $adults = $request->request->get('adults');
            $children = $request->request->get('children');
            $room = $request->request->get('room');
            $message = $request->request->get('message');

            $booking = new  Booking();

            $booking->setName($name);
            $booking->setEmail($email);
            $booking->setChildren($children);
            $booking->setAdults($adults);
            $booking->setCheckIn($checkIn);
            $booking->setCheckOut($checkOut);
            $booking->setRoom($room);
            $booking->setMessage($message);
            $booking->setStatus('pending');

            $em = $this->getDoctrine()->getManager();
            $em->persist($booking);
            $em->flush();

            $this->addFlash("success","Room Booked Successfuly Check Email For Receipt");

            $this->redirect($this->generateUrl('booking'));
        }

        $rooms = $rr->findAll();

        return $this->render('booking/index.html.twig', [
            'rooms' => $rooms,
        ]);
    }
}
