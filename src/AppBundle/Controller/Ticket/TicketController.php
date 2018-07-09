<?php
/**
 * Created by PhpStorm.
 * User: Usuario
 * Date: 12/6/2018
 * Time: 11:33 AM
 */

namespace AppBundle\Controller\Ticket;

use AppBundle\Entity\Nota;
use AppBundle\Entity\Ticket;
use AppBundle\Form\TicketType;
use AppBundle\Entity\Usuario;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class TicketController extends Controller
{
    /**
     * @Route("/crear_ticket", name="crear_ticket")
     */
    public function crear_ticket(){
        $usuarios = $this->getDoctrine()
            ->getRepository(Usuario::class)
            ->findAll();
        //Renderizando la vista
        return $this->render("@App/Ticket/crear_ticket.html.twig",
            [
                "usuarios"=>$usuarios
            ]);
    }
    /**
     * @Route("/rest/crear_ticket",options={"expose"=true}, name="guardar_ticket")
     * @Method("POST")
     * @param Request $request
     * @return Response
     */
    public function guardarTicket(Request $request){
        $data = $request->getContent();
        $data = json_decode($data,true);
        $fecha = new \DateTime('now', (new \DateTimeZone('America/Santiago')));
        $ticket = new Ticket();
        $ticket->setEstado("PENDIENTE");
        $ticket->setFechaCreado($fecha);

        $form = $this->createForm(TicketType::class,$ticket);
        $form->submit($data);
            $entity_manager = $this->getDoctrine()->getManager();
            $entity_manager->persist($ticket);
            $entity_manager->flush();

            $jsonContent = $this->get('serializer')->serialize($ticket,'json');
            $jsonContent = json_decode($jsonContent,true);
            return new JsonResponse($jsonContent);
    }

    /**
     * @Route("/rest/iniciar_tarea/{id}",options={"expose"=true}, name="iniciar_tarea")
     * @Method("PUT")
     * @param Request $request
     * @param Ticket $ticket
     *
     * @return JsonResponse
     */
    public function actualizarUsuario($id){

        $fecha = new \DateTime('now', (new \DateTimeZone('America/Santiago')));
        //Enviando actualizacion
        $entityManager = $this->getDoctrine()->getManager();
        $ticket = $entityManager->getRepository(Ticket::class)->find($id);
        $ticket->setFecha($fecha);
        $ticket->setEstado("EN_PROCESO");
        $entityManager->flush();
        $data = array('id'=>$id);
        $jsonContent = $this->get('serializer')->serialize($data,'json');
        $jsonContent = json_decode($jsonContent,true);
        return new JsonResponse($jsonContent);
    }

    /**
     * @Route("/ver_ticket/{id}",options={"expose"=true}, name="ver_ticket")
     * @Method("GET")
     * @param Ticket $ticket
     * @return \Symfony\Component\HttpFoundation\Response
     *
     */
    public function verTicket(Ticket $ticket){

        $notas = $this->getDoctrine()
            ->getRepository(Nota::class)
            ->buscar_notas_por_id($ticket->getId());

        return $this->render("@App/Ticket/ver_ticket.html.twig",
            [
                "ticket"=>$ticket,
                "notas"=>$notas
            ]
        );
    }
}