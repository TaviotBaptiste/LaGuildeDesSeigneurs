<?php

namespace App\Controller;

use App\Entity\Character;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Service\CharacterServiceInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;

class CharacterController extends AbstractController
{
    public function __construct(private CharacterServiceInterface $characterService)
    {
    }



    #[Route('/character', name: 'character_redirect_index', methods: ["GET", "HEAD"])]
    /**
     * @OA\Response(
     *     response=302,
     *     description="Redirect",
     * )
     * @OA\Tag(name="Character")
     */
    public function redirectIndex()
    {
        return $this->redirectToRoute('character_index');
    }


    #[Route('/character/index', name: 'character_index', methods: ["GET", "HEAD"])]
    /**
     * @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\Schema(
     *         type="array",
     *         @OA\Items(
     *             ref=@Model(type=Character::class))
     *     )
     * )
     * @OA\Response(
     *     response=403,
     *     description="Access denied",
     * )
     * @OA\Tag(name="Character")
     */
    public function index()
    {
        $this->denyAccessUnlessGranted('characterIndex', null);
        $characters = $this->characterService->getAll();
        return JsonResponse::fromJsonString($this->characterService->serializeJson($characters));
    }

    #[Route('/character/intelligence/{intelligence}', name: 'character_index_intelligence', requirements: ["intelligence" => "^([0-9]{1,3})$"], methods: ["GET", "HEAD"])]
    /**
     * Display the character by intelligence contained in the url
     * 
     * @OA\Parameter(
     *      name="intelligence",
     *      in="path",
     *      description="intelligence for the Character",
     *      required=true,
     * )
     * @OA\Response(
     *      response=200,
     *      description="Success",
     *      @Model(type=Character::class),
     * )
     * @OA\Response(
     *      response=403,
     *      description="Access denied",
     * )
     * @OA\Response(
     *      response=404,
     *      description="Not Found",
     * )
     * @OA\Tag(name="Character")
     */
    public function indexIntelligence(int $intelligence)
    {
        $this->denyAccessUnlessGranted('characterIntelligence', null);
        $characters = $this->characterService->getByIntelligence($intelligence);
        return JsonResponse::fromJsonString($this->characterService->serializeJson($characters));
    }

    #[Route('/character/life/{life}', name: 'character_index_life', requirements: ["life" => "^([0-9]{1,3})$"], methods: ["GET", "HEAD"])]
    /**
     * Display the character by life contained in the url
     * 
     * @OA\Parameter(
     *      name="life",
     *      in="path",
     *      description="life for the Character",
     *      required=true,
     * )
     * @OA\Response(
     *      response=200,
     *      description="Success",
     *      @Model(type=Character::class),
     * )
     * @OA\Response(
     *      response=403,
     *      description="Access denied",
     * )
     * @OA\Response(
     *      response=404,
     *      description="Not Found",
     * )
     * @OA\Tag(name="Character")
     */
    public function indexLife(int $life)
    {
        $this->denyAccessUnlessGranted('characterLife', null);
        $characters = $this->characterService->getByLife($life);
        return JsonResponse::fromJsonString($this->characterService->serializeJson($characters));
    }

    #[Route('/character/caste/{caste}', name: 'character_index_caste', requirements: ["caste" => "[^/]+"], methods: ["GET", "HEAD"])]
    /**
     * Display the character by caste contained in the url
     * 
     * @OA\Parameter(
     *      name="caste",
     *      in="path",
     *      description="caste for the Character",
     *      required=true,
     * )
     * @OA\Response(
     *      response=200,
     *      description="Success",
     *      @Model(type=Character::class),
     * )
     * @OA\Response(
     *      response=403,
     *      description="Access denied",
     * )
     * @OA\Response(
     *      response=404,
     *      description="Not Found",
     * )
     * @OA\Tag(name="Character")
     */
    public function indexCaste(string $caste)
    {
        $this->denyAccessUnlessGranted('characterCaste', null);
        $characters = $this->characterService->getByCaste($caste);
        return JsonResponse::fromJsonString($this->characterService->serializeJson($characters));
    }

    #[Route('/character/knowledge/{knowledge}', name: 'character_index_knowledge', requirements: ["knowledge" => "[^/]+"], methods: ["GET", "HEAD"])]
    /**
     * Display the character by knowledge contained in the url
     * 
     * @OA\Parameter(
     *      name="knowledge",
     *      in="path",
     *      description="knowledge for the Character",
     *      required=true,
     * )
     * @OA\Response(
     *      response=200,
     *      description="Success",
     *      @Model(type=Character::class),
     * )
     * @OA\Response(
     *      response=403,
     *      description="Access denied",
     * )
     * @OA\Response(
     *      response=404,
     *      description="Not Found",
     * )
     * @OA\Tag(name="Character")
     */
    public function indexKnowledge(string $knowledge)
    {
        $this->denyAccessUnlessGranted('characterKnowledge', null);
        $characters = $this->characterService->getByKnowledge($knowledge);
        return JsonResponse::fromJsonString($this->characterService->serializeJson($characters));
    }

    #[Route('/character/display/{identifier}', name: 'character_display', requirements: ["identifier" => "^([a-z0-9]{40})$"], methods: ["GET", "HEAD"])]
    #[Entity("character", expr: "repository.findOneByIdentifier(identifier)")]
    /**
     * Displays the Character
     * 
     * @OA\Parameter(
     *      name="identifier",
     *      in="path",
     *      description="identifier for the Character",
     *      required=true,
     * )
     * @OA\Response(
     *      response=200,
     *      description="Success",
     *      @Model(type=Character::class),
     * )
     * @OA\Response(
     *      response=403,
     *      description="Access denied",
     * )
     * @OA\Response(
     *      response=404,
     *      description="Not Found",
     * )
     * @OA\Tag(name="Character")
     */


    public function display(Character $character): Response
    {
        $this->denyAccessUnlessGranted('characterDisplay', $character);
        return JsonResponse::fromJsonString($this->characterService->serializeJson($character));
    }

    #[Route('/character/create', name: 'character_create', methods: ["POST", "HEAD"])]
    //CREATE
    /**
     * @OA\Response(
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
    public function create(Request $request)
    {
        $this->denyAccessUnlessGranted('characterDisplay', null);
        $character = $this->characterService->create($request->getContent());
        return JsonResponse::fromJsonString($this->characterService->serializeJson($character));
    }

    //MODIFY
    /**
     * @OA\Response(
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
    #[Route('/character/modify/{identifier}', name: 'character_modify', requirements: ["identifier" => "^([a-z0-9]{40})$"], methods: ["PUT", "HEAD"])]
    public function modify(Request $request, Character $character)
    {
        $this->denyAccessUnlessGranted('characterModify', $character);
        $character = $this->characterService->modify($character, $request->getContent());
        return JsonResponse::fromJsonString($this->characterService->serializeJson($character));
    }


    #[Route('/character/delete/{identifier}', name: 'character_delete', requirements: ["identifier" => "^([a-z0-9]{40})$"], methods: ["DELETE", "HEAD"])]
    //DELETE
    /**
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
    public function delete(Character $character)
    {
        $this->denyAccessUnlessGranted('characterDelete', $character);
        $response = $this->characterService->delete($character);
        return new JsonResponse(array('delete' => $response));
    }

    #[Route('/character/images/{number}', name: 'character_images', requirements: ["number" => "^([0-9]{1,2})$"], methods: ["GET", "HEAD"])]
    public function image(int $number)
    {
        $this->denyAccessUnlessGranted('characterIndex', null);
        $images = $this->characterService->getImages($number);
        return new JsonResponse($images);
    }

    #[Route('/character/images/{kind}/{number}', name: 'character_images_kind', requirements: ["number" => "^([0-9]{1,2})$", "kind" => "^(dames|seigneurs|ennemis|ennemies)$"], methods: ["GET", "HEAD"])]
    public function imageKind(string $kind, int $number)
    {
        $this->denyAccessUnlessGranted('characterIndex', null);
        $images = $this->characterService->getImagesKind($kind, $number);
        return new JsonResponse($images);
    }
}