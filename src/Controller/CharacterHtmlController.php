<?php

namespace App\Controller;

use App\Entity\Character;
use App\Form\CharacterHtmlType;
use App\Service\CharacterService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Service\CharacterServiceInterface;

#[Route('/character/html')]
class CharacterHtmlController extends AbstractController
{


    public function __construct(private CharacterServiceInterface $characterService)
    {
    }


    #[Route('/', name: 'app_character_html_index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('character_html/index.html.twig', [
            'characters' => $this->characterService->getAll(),
        ]);
    }

    #[Route('/intelligence/{intelligence}', name: 'app_character_html_intelligence',requirements: ["intelligence" => "^([0-9]{1,3})$"], methods: ['GET'])]
    public function indexIntelligence(int $intelligence)
    {
        return $this->render('character_html/index.html.twig', [
            'characters' => $this->characterService->getByIntelligence($intelligence),
        ]);
    }

    #[Route('/life/{life}', name: 'app_character_html_life',requirements: ["life" => "^([0-9]{1,3})$"], methods: ['GET'])]
    public function indexLife(int $life)
    {
        return $this->render('character_html/index.html.twig', [
            'characters' => $this->characterService->getByLife($life),
        ]);
    }

    #[Route('/caste/{caste}', name: 'app_character_html_caste',requirements: ["caste" => "[^/]+"], methods: ['GET'])]
    public function indexCaste(string $caste)
    {
        return $this->render('character_html/index.html.twig', [
            'characters' => $this->characterService->getByCaste($caste),
        ]);
    }

    #[Route('/knowledge/{knowledge}', name: 'app_character_html_knowledge',requirements: ["knowledge" => "[^/]+"], methods: ['GET'])]
    public function indexKnowledge(string $knowledge)
    {
        return $this->render('character_html/index.html.twig', [
            'characters' => $this->characterService->getByCaste($knowledge),
        ]);
    }
    
    #[Route('/new', name: 'app_character_html_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $character = new Character();
        $form = $this->createForm(CharacterHtmlType::class, $character);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->characterService->createFromHtml($character);
            return $this->redirectToRoute('app_character_html_show', array('id' => $character->getId(),));
        }

        return $this->renderForm('character_html/new.html.twig', [
            'character' => $character,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_character_html_show', methods: ['GET'])]
    public function show(Character $character): Response
    {
        return $this->render('character_html/show.html.twig', [
            'character' => $character,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_character_html_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Character $character, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CharacterHtmlType::class, $character);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->characterService->modifyFromHtml($character);
            return $this->redirectToRoute('app_character_html_index', array('id' => $character->getId(),));
        }

        return $this->renderForm('character_html/edit.html.twig', [
            'character' => $character,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_character_html_delete', methods: ['POST'])]
    public function delete(Request $request, Character $character, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $character->getId(), $request->request->get('_token'))) {
            $entityManager->remove($character);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_character_html_index', [], Response::HTTP_SEE_OTHER);
    }
}