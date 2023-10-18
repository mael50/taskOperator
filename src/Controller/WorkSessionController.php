<?php

namespace App\Controller;

use App\Entity\WorkSession;
use App\Form\WorkSessionType;
use App\Repository\WorkSessionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/work/session')]
class WorkSessionController extends AbstractController
{
    #[Route('/', name: 'app_work_session_index', methods: ['GET'])]
    public function index(WorkSessionRepository $workSessionRepository): Response
    {
        return $this->render('work_session/index.html.twig', [
            'work_sessions' => $workSessionRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_work_session_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $workSession = new WorkSession();
        $form = $this->createForm(WorkSessionType::class, $workSession);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($workSession);
            $entityManager->flush();

            return $this->redirectToRoute('app_work_session_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('work_session/new.html.twig', [
            'work_session' => $workSession,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_work_session_show', methods: ['GET'])]
    public function show(WorkSession $workSession): Response
    {
        return $this->render('work_session/show.html.twig', [
            'work_session' => $workSession,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_work_session_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, WorkSession $workSession, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(WorkSessionType::class, $workSession);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_work_session_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('work_session/edit.html.twig', [
            'work_session' => $workSession,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_work_session_delete', methods: ['POST'])]
    public function delete(Request $request, WorkSession $workSession, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$workSession->getId(), $request->request->get('_token'))) {
            $entityManager->remove($workSession);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_work_session_index', [], Response::HTTP_SEE_OTHER);
    }
}
