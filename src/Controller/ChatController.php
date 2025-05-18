<?php

namespace App\Controller;

use App\Service\ChatService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ChatController extends AbstractController
{
    #[Route('/chat', name: 'chat')]
    public function chat(Request $request, ChatService $chatService): Response
    {
        $question = $request->request->get('question');
        $response = null;

        if ($question) {
            $response = $chatService->askQuestion($question);
        }

        return $this->render('chat/index.html.twig', [
            'response' => $response,
        ]);
    }
}
