<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Task;
use App\Repository\TaskRepository;

class TaskService{

    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly TaskRepository $taskRepository
    ){}

    /**
     * @param Task $task
     * @return void
     * @throws \Exception
     */
    //Ajouter une tâche en BDD
    public function save(Task $task){
        //Tester si les champs sont tous remplis
        if($task->getTitle() != "" && $task->getContent() != "" && $task->getCreatedAt() != "" && $task->getExpiredAt() != ""){
            //Setter les paramètres
            $task->setStatus("false");
            $this->em->persist($task);
            $this->em->flush();
        }
        //Sinon les champs ne sont pas remplis
        else{
            throw new \Exception("Les champs ne sont pas remplis", 400);
        }
    }

    //Récupérer toutes les tâches en BDD
    public function getAll(){
        try {
            return $this->taskRepository->findAll();
        } catch (\Exception $e) {
            throw new \Exception("Impossible de récupérer les données.");
        }
    }

}