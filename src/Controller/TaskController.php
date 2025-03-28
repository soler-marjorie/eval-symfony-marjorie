<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Service\TaskService;
use App\Entity\Task;
use App\Form\TaskType;
use Symfony\Component\HttpFoundation\Request;

final class TaskController extends AbstractController
{

    public function __construct(
        private readonly TaskService $taskService
    ){}
    
    
    #[Route('/task', name: 'app_task')]
    public function index(): Response
    {
        return $this->render('task/index.html.twig', [
            'controller_name' => 'TaskController',
        ]);
    }

    //Ajouter une tâche
    #[Route('/task/add', name: 'app_task_add')]
    public function add(Request $request): Response
    {
        $task = new Task();
        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);
        $type = "";
        $msg = "";

        //test si le formulaire est submit
        if($form->isSubmitted() && $form->isValid()) {
            try{
                //Appel de la methode save de TaskService
                $this->taskService->save($task);
                $type ="success";
                $msg = "La tâche à été ajoutée en BDD";
            }
            //Capturer les exceptions
            catch (\Exception $e){
                $type = "danger";
                $msg = $e->getMessage();
            }

            $this->addFlash($type, $msg);
        }
        return $this->render('task/addtask.html.twig',[
            'formulaire' => $form
        ]);
    }
}
