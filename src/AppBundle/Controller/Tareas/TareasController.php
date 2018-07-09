<?php
/**
 * Created by PhpStorm.
 * User: Usuario
 * Date: 12/6/2018
 * Time: 11:33 AM
 */

namespace AppBundle\Controller\Tareas;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Ticket;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class TareasController extends Controller
{
    /**
     * @Route("/tareas", name="lista_tareas")
     */
    public function indexTareas(){
        $tickets = $this->getDoctrine()
            ->getRepository(Ticket::class)
            ->obtener_todos_tickets();
        //Renderizando la vista
        return $this->render("@App/Tareas/lista_tareas.html.twig",
            [
                "tickets"=>$tickets
            ]);
    }

}