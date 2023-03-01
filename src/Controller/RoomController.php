<?php

namespace App\Controller;

use App\Entity\Room;
use App\Form\RoomType;
use App\Repository\RoomRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/room', name: 'room.')]
class RoomController extends AbstractController
{
    #[Route('/', name: 'rooms')]
    public function index(RoomRepository $rr): Response
    {
        $rooms  = $rr->findAll();


        return $this->render('room/index.html.twig', [
            'rooms' => $rooms,
        ]);
    }

    #[Route('/create', name: 'create')]
    public function create(Request $request) {
        $room = new Room();
        //Form
        $form = $this->createForm(RoomType::class, $room);
        $form->handleRequest($request);

        if($form->isSubmitted()) {
            // Entity Manager
            $em = $this->getDoctrine()->getManager();
            $image = $form->get('image')->getData();

            if($image) {
                $filename =  md5(uniqid()). '.' .$image->guessClientExtension();
            }

            $image->move(
                $this->getParameter('images_folder'),
                $filename
            );

            $room->setImage($filename);

//            echo "<pre>";
//            echo var_dump($room);
//            echo "</pre>";
//
//            die();

            $room->setAvailable(true);
            $em->persist($room);
            $em->flush();

            return $this->redirect($this->generateUrl('home'));
        }

        //Response
        return $this->render('room/create.html.twig', [
            'roomForm' => $form->createView(),
        ]);
    }

    #[Route('/delete/{id}', name: 'delete')]
    public function remove($id, RoomRepository $rr) {
        $em = $this->getDoctrine()->getManager();
        $room = $rr->find($id);
        $em->remove($room);
        $em->flush();

        //Notification
        $this->addFlash('success', "Room Deleted Successfully");

        return $this->redirect($this->generateUrl('room.rooms'));
    }
}
