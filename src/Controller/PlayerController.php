<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\PlayerServiceInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Player;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;

class PlayerController extends AbstractController
{
    private $playerService;

    public function __construct(PlayerServiceInterface $playerService)
    {
        $this->playerService = $playerService;
    }

     //CREATE
     #[Route('/player/create', name: 'player_create', methods:["POST","HEAD"])]
     public function create(Request $request){
         $this->denyAccessUnlessGranted('playerCreate', null);
         $player = $this->playerService->create($request->getContent());
         //return new JsonResponse($player->toArray());
         return JsonResponse::fromJsonString($this->playerService->serializeJson($player));
     }
 
     //INDEX Redirect
     #[Route('/player', name: 'player_redirect_index', methods:["GET","HEAD"])]
     public function redirectIndex(){
         return $this->redirectToRoute("player_index");
     }
     //INDEX
     #[Route('/player/index', name: 'player_index', methods:["GET","HEAD"])]
     public function index(){
         $this->denyAccessUnlessGranted("playerIndex", null);
         $players = $this->playerService->getAll();
         //return new JsonResponse($players);
         return JsonResponse::fromJsonString($this->playerService->serializeJson($players));
     }
 
     //MODIFY
     #[Route('/player/modify/{identifier}',name:'player_modify',requirements: ['identifier'=> '^([a-z0-9]{40})$'], methods:['PUT', 'HEAD'])]
     public function modify(Player $player,Request $request){
         $this->denyAccessUnlessGranted('playerModify', $player);
         $character = $this->characterService->modify($player, $request->getContent());
         //return new JsonResponse($player->toArray());
         return JsonResponse::fromJsonString($this->playerService->serializeJson($player));
     }
 
     //DELETE
     #[Route('/player/delete/{identifier}',name:'player_delete',requirements: ['identifier'=> '^([a-z0-9]{40})$'], methods:['DELETE', 'HEAD'])]
     public function delete(Player $player){
         $this->denyAccessUnlessGranted('playerDelete', $player);
         $response = $this->playerService->delete($player);
         return new JsonResponse(array('delete' => $response));
     }

    //Display
    #[Route('/player/display/{identifier}', name: 'player_display', requirements: ['identifier' => '^([a-z0-9]{40})$'], methods: ["GET", "HEAD"])]
    #[Entity('player', expr:'repository.findOneByIdentifier(identifier)')]
    public function display(Player $player)
    {
        $this->denyAccessUnlessGranted('playerDisplay',$player);
        //return new JsonResponse($player->toArray());
        return JsonResponse::fromJsonString($this->playerService->serializeJson($player));
    }
}
