<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Character;
use App\Entity\Player;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use App\Service\CharacterServiceInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;

class CharacterController extends AbstractController
{
    private $characterService;

    public function __construct(CharacterServiceInterface $characterService)
    {
        $this->characterService = $characterService;
    }

    //CREATE
    /**
    * Creates the Character 
    *@OA\Response(
    *     response=200,
    *     description="Success",
    *     @Model(type=Character::class)
    * )
    * @OA\Response(
    *     response=403,
    *     description="Access denied",
    * )
    * @OA\RequestBody(
    *     request="Character",
    *     description="Data for the Character",
    *     required=true,
    *     @OA\MediaType(
    *         mediaType="application/json",
    *         @OA\Schema(ref="#/components/schemas/Character")
    *     )
    * )
    * @OA\Tag(name="Character")
    */
    #[Route('/character/create', name: 'character_create', methods:["POST","HEAD"])]
    public function create(Request $request)
    {
        $this->denyAccessUnlessGranted('characterCreate', null);
        $character = $this->characterService->create($request->getContent());
        //return new JsonResponse($character->toArray());
        return JsonResponse::fromJsonString($this->characterService->serializeJson($character));
    }
    //INDEX
    /**
    * Redirects to index Route
    * @OA\Response(
    *     response=302,
    *     description="Redirect",
    * )
    * @OA\Tag(name="Character")
    */
    #[Route('/character', name: 'character_redirect_index', methods:["GET","HEAD"])]
    public function redirectIndex()
    {
        return $this->redirectToRoute("character_index");
    }
    //INDEX
    /**
    * Displays available Characters
    * @OA\Response(
    *     response=200,
    *     description="Success",
    *     @OA\Schema(
    *         type="array",
    *         @OA\Items(ref=@Model(type=Character::class))
    *     )
    * )
    * @OA\Response(
    *     response=403,
    *     description="Access denied",
    * )
    * @OA\Tag(name="Character")
    */
    #[Route('/character/index', name: 'character_index', methods:["GET","HEAD"])]
    public function index()
    {
        $this->denyAccessUnlessGranted("characterIndex", null);
        $characters = $this->characterService->getAll();
        //return new JsonResponse($characters);

        return JsonResponse::fromJsonString($this->characterService->serializeJson($characters));
    }
    
    //INDEXNUMBER
    /**
    * Displays available Characters
    * @OA\Response(
    *     response=200,
    *     description="Success",
    *     @OA\Schema(
    *         type="array",
    *         @OA\Items(ref=@Model(type=Character::class))
    *     )
    * )
    * @OA\Response(
    *     response=403,
    *     description="Access denied",
    * )
    * @OA\Tag(name="Character")
    */
    #[Route('/character/index/{number}', name: 'character_index_number', methods:["GET","HEAD"])]
    #[Entity('charactere', expr:'repository.findByNumber(number)')]
    public function indexNumber(Request $request, string $number)
    {
        $this->denyAccessUnlessGranted("characterIndexNumber", null);

        return JsonResponse::fromJsonString($this->characterService->serializeJson($characters));
    }

    //MODIFY
    /**
    * Modifies the Character 
    *@OA\Response(
    *     response=200,
    *     description="Success",
    *     @Model(type=Character::class)
    * )
    * @OA\Response(
    *     response=403,
    *     description="Access denied",
    * )
    * @OA\Parameter(
        *     name="identifier",
    *     in="path",
    *     description="identifier for the Character",
    *     required=true
    * )
    * @OA\RequestBody(
    *     request="Character",
    *     description="Data for the Character",
    *     required=true,
    *     @OA\MediaType(
    *         mediaType="application/json",
    *         @OA\Schema(ref="#/components/schemas/Character")
    *     )
    * )
    * @OA\Tag(name="Character")
    */
    #[Route('/character/modify/{identifier}', name:'character_modify', requirements: ['identifier'=> '^([a-z0-9]{40})$'], methods:['PUT', 'HEAD'])]
    public function modify(Request $request, Character $character)
    {
        $this->denyAccessUnlessGranted('characterModify', $character);
        $character = $this->characterService->modify($character, $request->getContent());
        //return new JsonResponse($character->toArray());
        return JsonResponse::fromJsonString($this->characterService->serializeJson($character));
    }

    //DELETE
    /**
    * Deletes the Character
    * @OA\Response(
    *     response=200,
    *     description="Success",
    *     @OA\Schema(
    *         @OA\Property(property="delete", type="boolean"),
    *     )
    * )
    * @OA\Response(
    *     response=403,
    *     description="Access denied",
    * )
    * @OA\Parameter(
    *     name="identifier",
    *     in="path",
    *     description="identifier for the Character",
    *     required=true
    * )
    * @OA\Tag(name="Character")
    */
    #[Route('/character/delete/{identifier}', name:'character_delete', requirements: ['identifier'=> '^([a-z0-9]{40})$'], methods:['DELETE', 'HEAD'])]
    public function delete(Character $character)
    {
        $this->denyAccessUnlessGranted('characterDelete', $character);
        $response = $this->characterService->delete($character);
        return new JsonResponse(array('delete' => $response));
    }


    //IMAGES
    #[Route('/character/delete/{number}', name:'character_images', requirements: ['number'=> '^([0-9]{1,2})$'], methods:['GET', 'HEAD'])]
    public function images(int $number)
    {
        $this->denyAccessUnlessGranted('characterIndex', null);
        return new JsonResponse($this->characterService->getImages($number));
    }

    //IMAGES KIND
    #[Route('/character/delete/{kind}', name:'character_images_kind', requirements: ['number'=> '^([0-9]{1,2})$'], methods:['GET', 'HEAD'])]
    public function imagesKind(string $kind, int $number)
    {
        $this->denyAccessUnlessGranted('characterIndex', null);
        return new JsonResponse($this->characterService->getImagesKind($kind, $number));
    }


    #[Route('/character', name: 'character', methods:["GET","HEAD"])]
    public function indexes(): Response
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/CharacterController.php',
        ]);
    }
    //DISPLAY
    /**
     * Displays the Character$
     *  @OA\Parameter(
     *     name="identifier",
     *     in="path",
     *     description="identifier for the Character",
     *     required=true,
     * )
     * @OA\Response(
     *     response=200,
     *     description="Success",
     *     @Model(type=Character::class)
     * )
     * @OA\Response(
     *     response=403,
     *     description="Access denied",
     * )
     * @OA\Response(
     *     response=404,
     *     description="Not Found",
     * )
     * @OA\Tag(name="Character")
     */
    #[Route('/character/display/{identifier}', name: 'character_display', requirements: ['identifier' => '^([a-z0-9]{40})$'], methods: ["GET", "HEAD"])]
    public function display(Character $character)
    {
        $this->denyAccessUnlessGranted('characterDisplay', $character);
        //return new JsonResponse($character->toArray());
        return JsonResponse::fromJsonString($this->characterService->serializeJson($character));
    }

    //DISPLAY
    /**
     * Displays the Character by number
     *
     * ...
     *
     * @OA\Parameter(
     *     name="level",
     *     in="path",
     *     description="level of number of the Character",
     *     required=true,
     * )
     * @OA\Response(
     *     response=200,
     *     description="Success",
     *     @Model(type=Character::class)
     * )
     * @OA\Response(
     *     response=403,
     *     description="Access denied",
     * )
     * @OA\Response(
     *     response=404,
     *     description="Not Found",
     * )
     * @OA\Tag(name="Character")
     */
    #[Route('/character/intelligence/{number}', name: 'character_index_number', methods: ['GET', 'HEAD'])]
    public function gtEqNumber(Int $number): Response
    {
        $this->denyAccessUnlessGranted('characterIndex', null);
        $characters = $this->characterService->getAllByNumber($number);
        return JsonResponse::fromJsonString($this->characterService->serializeJson($characters));
    }
}
