<?php
/**
 * Created by PhpStorm.
 * User: Usuario
 * Date: 11/6/2018
 * Time: 6:44 PM
 */

namespace AppBundle\Controller\Usuario;
use AppBundle\Entity\Usuario;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UsuarioController extends Controller
{ /**
 * @Route("/usuario", name="vista_usuario")
 */
    public function indexUsuario(){
        /*
        $entity_manager = $this->getDoctrine()->getManager();

        $usuario = new Usuario();
        $usuario->setNombre("Giant Abreu");
        $usuario->setUsername("gabreu@gmail.com");

        $entity_manager->persist($usuario);
        $entity_manager->flush();

        dump($usuario);
        die;
        */
        //dump($usuarios);
        //die;
        //Select * from usuarios
        $usuarios = $this->getDoctrine()
            ->getRepository(Usuario::class)
            ->findAll();
        //Renderizando la vist
        return $this->render("@App/Usuario/lista.html.twig",
        ["usuarios"=>$usuarios]);
    }
    /**
     * @Route("/usuario/{idUsuario}", name="informacion_usuario")
     */
    public function indexUsuarioInfo($idUsuario){
       return $this->render( '@App/Usuario/index.html.twig',
        ["idUsuario" => $idUsuario]
        );
    }
}