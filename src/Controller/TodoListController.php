<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TodoListController extends AbstractController
{
    #[Route('/todo/list', name: 'app_todo_list')]
    public function readTodo(Request $request): Response
    {
        $session = $request->getSession();

        if (!$session->has('todo')) {
            $todo = [
                'achat' => 'Acheter une ps5',
                'sport' => 'Gymnase',
                'lire' => 'Coran'
            ];
            $session->set('todo', $todo);
        }

        return $this->render('todo_list/todo.html.twig');
    }


    #[Route('/todolist/add/{cle}/{content}', name: 'make_todo_list')]
    public function makeTodoList(Request $request, $cle, $content): Response
    {
        $session = $request->getSession();
        if ($session->has('todo')) {
            $todo = $session->get('todo');
            if (isset($todo[$cle])) {
                $this->addFlash('danger', message: " La clé existe dejà ");
            } else {
                $todo[$cle] = $content;
                $this->addFlash('success', message: " La liste a été ajouté avec succès");
                $session->set('todo', $todo);
            }
        } else {
            $this->addFlash('info', message: " La liste n'existe pas encore ");
        }
        return $this->redirectToRoute('app_todo_list');
    }


    #[Route('/todolist/update/{cle}/{content}', name: 'update_todo_list')]
    public function updateTodoListe(Request $request, $cle, $content): Response
    {
        $session = $request->getSession();
        if ($session->has('todo')) {
            $todo = $session->get('todo');
            if (!isset($todo[$cle])) {
                $this->addFlash('danger', message: " La clé n'existe pas ");
            } else {
                $todo[$cle] = $content;
                $session->set('todo', $todo);
                $this->addFlash('success', message: " La liste a été mis à jour avec succès");
            }
        } else {
            $this->addFlash('info', message: " La liste n'existe pas encore ");
        }
        return $this->redirectToRoute('app_todo_list');
    }

    #[Route('/todolist/delete/{cle}', name: 'delete_todo_list')]
    public function deleteTodoListe(Request $request, $cle): Response
    {
        $session = $request->getSession();
        if ($session->has('todo')) {
            $todo = $session->get('todo');
            if (!isset($todo[$cle])) {
                $this->addFlash('danger', message: " La clé n'existe pas ");
            } else {
                unset($todo[$cle]);
                $session->set('todo', $todo);
                $this->addFlash('success', message: " La liste a été supprimé avec succès");
            }
        } else {
            $this->addFlash('info', message: " La liste n'existe pas encore ");
        }
        return $this->redirectToRoute('app_todo_list');
    }
}
