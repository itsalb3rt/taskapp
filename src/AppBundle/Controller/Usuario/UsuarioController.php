<?php
/**
 * Created by PhpStorm.
 * User: Usuario
 * Date: 11/6/2018
 * Time: 6:44 PM
 */

namespace AppBundle\Controller\Usuario;
use AppBundle\Entity\Usuario;
use AppBundle\Services\ModSerializer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class UsuarioController extends Controller
{

    /**
     * @Route("/usuario", name="lista_usuarios"),options={"expose"=true}
     */
        public function indexUsuario(){

            $usuarios = $this->getDoctrine()
                ->getRepository(Usuario::class)
                ->findAll();
            //Renderizando la vista
            return $this->render("@App/Usuario/lista_usuarios.html.twig",
                [
                    "usuarios"=>$usuarios
                ]
            );
        }

    /**
     *
     * @Route("/usuario/{id}", name="editar_usuario"),options={"expose"=true}
     * @Method("GET")
     * @param Usuario $usuario
     * @return \Symfony\Component\HttpFoundation\Response
     *
     */
    public function indexEditUsuario(Usuario $usuario){

        return $this->render("@App/Usuario/editar_usuario.html.twig",
            [
                "usuario"=>$usuario
            ]
        );
    }
    /**
     * @Route("/usuario/{id}", name="eliminar_usuario"),options={"expose"=true}
     * @Method("DELETE")
     * @param Usuario $usuario
     * @return Response
     */
    public function indexEliminarUsuario(Usuario $usuario){
        $entity_manager = $this->getDoctrine()->getManager();

        $entity_manager->remove($usuario);
        $entity_manager->flush();

        return $this->redirectToRoute('lista_usuarios');
    }
    //Restful API

    /**
     * @Route("/rest/usuario/{id}", name="buscar_usuarios"),options={"expose"=true}
     * @Method("GET")
     * @ParamConverter("usuario",class="AppBundle:Usuario")
     * @param Usuario $usuario
     * @return null
     */
    public function buscarUsuario($usuario){
        $jsonContent = $this->get('serializer')->serialize($usuario,'json');
        $jsonContent = json_decode($jsonContent,true);
        return new JsonResponse($jsonContent);
    }

    /**
     * @Route("/rest/usuario", name="guardar_usuario"),options={"expose"=true}
     * @Method("POST")
     * @param Request $request
     * @return null
     */
    public function guardarUsuario(Request $request){
        $data = $request->getContent();
        $data = json_decode($data,true);

        $usuario = new Usuario();
        $usuario->setNombre($data['nombre']);
        $usuario->setUsername($data['nombreusuario']);

        $entity_manager = $this->getDoctrine()->getManager();
        $entity_manager->persist($usuario);
        $entity_manager->flush();

        $jsonContent = $this->get('serializer')->serialize($usuario,'json');
        $jsonContent = json_decode($jsonContent,true);
        return new JsonResponse($jsonContent);
    }

    /**
     * @Route("/rest/usuario/{id}", name="actualizar_usuario"),options={"expose"=true}
     * @Method("PUT")
     * @param Request $request
     * @param Usuario $usuario
     *
     * @return JsonResponse
     */
    public function actualizarUsuario(Request $request,Usuario $usuario){
        $data = $request->getContent();
        $data = json_decode($data,true);

        $usuario->setNombre($data['nombre']);
        $usuario->setUsername($data['nombreusuario']);

        $entity_manager = $this->getDoctrine()->getManager();
        $entity_manager->flush();

        $jsonContent = $this->get('serializer')->serialize($usuario,'json');
        $jsonContent = json_decode($jsonContent,true);

        return new JsonResponse($jsonContent);
    }
}