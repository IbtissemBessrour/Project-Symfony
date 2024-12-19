<?php

namespace App\Controller;

use App\Entity\Quiz;
use App\Form\QuizType;
use App\Repository\QuizRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Dompdf\Dompdf;
use Dompdf\Options;

#[Route('/quiz')]
final class QuizController extends AbstractController{
    #[Route(name: 'app_quiz_index', methods: ['GET'])]
    public function index(Request $request, QuizRepository $quizRepository): Response
    {
        $search = $request->query->get('search', '');
    
        if (!empty($search)) {
            $quizzes = $quizRepository->findByTitle($search);
        } else {
            $quizzes = $quizRepository->findAll();
        }
    
        return $this->render('quiz/index.html.twig', [
            'quizzes' => $quizzes,
        ]);
    }

    
#[Route('/quiz/export-pdf', name: 'app_quiz_export_pdf', methods: ['GET'])]
public function exportPdf(QuizRepository $quizRepository): Response
{
    $quizzes = $quizRepository->findAll();

    $options = new Options();
    $options->set('defaultFont', 'Arial');
    $dompdf = new Dompdf($options);

    $html = $this->renderView('quiz/pdf.html.twig', [
        'quizzes' => $quizzes,
    ]);

    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();

    return new Response($dompdf->output(), 200, [
        'Content-Type' => 'application/pdf',
        'Content-Disposition' => 'inline; filename="quizzes.pdf"',
    ]);
}

#[Route('/new', name: 'app_quiz_new', methods: ['GET', 'POST'])]
public function new(Request $request, EntityManagerInterface $entityManager): Response
{
    $quiz = new Quiz();
    $form = $this->createForm(QuizType::class, $quiz);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $entityManager->persist($quiz);
        $entityManager->flush();

        $this->addFlash('success', 'The quiz "' . $quiz->getTitle() . '" has been created successfully!');

        return $this->redirectToRoute('app_quiz_index', [], Response::HTTP_SEE_OTHER);
    }

    return $this->render('quiz/new.html.twig', [
        'quiz' => $quiz,
        'form' => $form->createView(),
    ]);
}


#[Route('/{id}', name: 'app_quiz_show', methods: ['GET'])]
public function show(Quiz $quiz): Response
{
    // Liste statique de questions associées à un quiz
    $questions = [
        ['question' => 'What is the capital of France?', 'choices' => ['Paris', 'London', 'Rome']],
        ['question' => 'What is 2 + 2?', 'choices' => ['3', '4', '5']],
        ['question' => 'What is the color of the sky?', 'choices' => ['Blue', 'Green', 'Yellow']],
    ];

    return $this->render('quiz/show.html.twig', [
        'quiz' => $quiz,
        'questions' => $questions,
    ]);
}

    #[Route('/{id}/edit', name: 'app_quiz_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Quiz $quiz, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(QuizType::class, $quiz);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_quiz_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('quiz/edit.html.twig', [
            'quiz' => $quiz,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_quiz_delete', methods: ['POST'])]
    public function delete(Request $request, Quiz $quiz, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$quiz->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($quiz);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_quiz_index', [], Response::HTTP_SEE_OTHER);
    }
}