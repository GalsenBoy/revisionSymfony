<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SessionController extends AbstractController
{
    #[Route('/session', name: 'app_session')]
    public function Session(Request $request): Response
    {
        $session = $request->getSession();
        if ($session->has('maSession')) {
            $maSession = $session->get('maSession') + 1;
            $session->set('maSession', $maSession);
        } else {
            $maSession = 1;
            $session->set('maSession', $maSession);
        }
        return $this->render(
            'session/session.html.twig'
        );
    }
}
