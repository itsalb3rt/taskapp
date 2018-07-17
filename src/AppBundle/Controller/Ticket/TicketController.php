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
use Symfony\Component\HttpFoundation\Response;
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
     * @Route("/rest/cambiar_estado/{id}",options={"expose"=true}, name="cambiar_estado")
     * @Method("PUT")
     * @param Request $request
     * @param Ticket $ticket
     *
     * @return JsonResponse
     */
    public function cambiarEstado($id,Request $request){
        $estado = json_decode($request->getContent(),true);
        $fecha = new \DateTime('now', (new \DateTimeZone('America/Santiago')));
        //Enviando actualizacion

        $entityManager = $this->getDoctrine()->getManager();
        $ticket = $entityManager->getRepository(Ticket::class)->find($id);
        $ticket->setFechaCompletado($fecha);
        $ticket->setEstado($estado['estado']);
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
        $notas = $ticket->getNotas();
        return $this->render("@App/Ticket/ver_ticket.html.twig",
            [
                "ticket"=>$ticket,
                "notas"=>$notas
            ]
        );
    }
    /**
     * @Route("/tickets", name="lista_tickets")
     */
    public function todosTickets(){
        $tickets = $this->getDoctrine()
            ->getRepository(Ticket::class)
            ->findBy([],
                ['fechaCreado'=>'DESC']);
        //Renderizando la vista
        return $this->render("@App/Ticket/lista_tickets.html.twig",
            [
                "tickets"=>$tickets
            ]);
    }
    /**
     * @Route("/mis_asignaciones", name="mis_asignaciones")
     */
    public function misAsignaciones(){
        $usuario =
        $tickets = $this->getDoctrine()
            ->getRepository(Ticket::class)
            ->findBy(
                ['usuarioAsignadoId' => $this->getUser()->getId()],
                ['fechaCreado'=>'DESC']
            );
        //Renderizando la vista
        return $this->render("@App/Ticket/mis_asignaciones.html.twig",
            [
                "tickets"=>$tickets
            ]);
    }
    /**
     * @Route("/mis_tickets", name="mis_tickets")
     */
    public function misTickets(){
        $usuario =
        $tickets = $this->getDoctrine()
            ->getRepository(Ticket::class)
            ->findBy(
                ['usuario' => $this->getUser()->getId()],
                ['fechaCreado'=>'DESC']
            );
        //Renderizando la vista
        return $this->render("@App/Ticket/mis_tickets.html.twig",
            [
                "tickets"=>$tickets
            ]);
    }

    /**
     * @Route("/resultado_busqueda/{ticket_id}",options={"expose"=true},name="resultado_busqueda"),requirements={"ticket"="\d+"})
     * @Method 'GET'
     *
     * @param int $ticket_id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function consulta_ticket_id($ticket_id = 1){
        $ticket_id = $_GET['ticket'];

        $mensaje_busqueda = 'Oops! no se encontro nada: ' ;
        //Verificand si el usuario ha introducido un numero
        if(is_numeric($ticket_id)){
            $ticket = $this->getDoctrine()
                ->getRepository(Ticket::class)
                ->findBy(array('id'=>$ticket_id));
            //Verificando que existe resultado de la consulta
            if(isset($ticket[0])){
                $notas = $ticket[0]->getNotas();

                return $this->render("@App/Ticket/ver_ticket.html.twig",
                    [
                        "ticket"=>$ticket[0],
                        "notas"=>$notas
                    ]
                );
            }else{
                return $this->render("@App/Utilitarios/sin_resultados_busqueda.html.twig",
                    [
                        "mensaje"=> $mensaje_busqueda . $ticket_id
                    ]
                );
            }

        }else{
            return $this->render("@App/Utilitarios/sin_resultados_busqueda.html.twig",
                [
                    "mensaje"=> $mensaje_busqueda . $ticket_id
                ]
            );
        }

    }
}