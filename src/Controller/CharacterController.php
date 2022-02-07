<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Character;
use Symfony\Component\HttpFoundation\JsonResponse;

class CharacterController extends AbstractController
{
    #[Route('/character', name: 'character')]
    public function index(): Response
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/CharacterController.php',
        ]);
    }
    /**
    * @Route("/character/display", name="character_display") 
    */

    #[Route('/character/display', name: 'character_display')]
    public function display()
    {
        $character = new Character();
        //dump($character);
        //dd($character->toArray());
        return new JsonResponse($character->toArray());
    }
}
