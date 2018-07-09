<?php
/**
 * Created by PhpStorm.
 * User: Usuario
 * Date: 11/6/2018
 * Time: 6:44 PM
 */

namespace AppBundle\Controller\Usuario;
use AppBundle\Entity\Usuario;
use AppBundle\Form\UsuarioType;
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
     * @Route("/login", name="login")
     */
    public function loginAction(Request $request) {

        dump("error");
        die();
        //Llamamos al servicio de autenticacion
        $authenticationUtils = $this->get('security.authentication_utils');

        // conseguir el error del login si falla
        $error = $authenticationUtils->getLastAuthenticationError();

        // ultimo nombre de usuario que se ha intentado identificar
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render(
            'AppBundle:Usuario:login.html.twig',array('error'=>$error,'last_username'=>$lastUsername));
    }
    /**
     * @Route("/usuario", options={"expose"=true},name="lista_usuarios")
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
     * @Route("/usuario/{id}",options={"expose"=true}, name="editar_usuario")
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
     * @Route("/rest/usuario/{id}", options={"expose"=true},name="eliminar_usuario")
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
     * @Route("/rest/usuario/{id}",options={"expose"=true}, name="buscar_usuarios")
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
     * @Route("/rest/usuario",options={"expose"=true}, name="guardar_usuario")
     * @Method("POST")
     * @param Request $request
     * @return Response
     */
    public function guardarUsuario(Request $request){
        $data = $request->getContent();
        $data = json_decode($data,true);

        $usuario = new Usuario();
        $form = $this->createForm(UsuarioType::class,$usuario);
        $form->submit($data);
            if($form->isValid()){
                $entity_manager = $this->getDoctrine()->getManager();
                $entity_manager->persist($usuario);
                $entity_manager->flush();

                $jsonContent = $this->get('serializer')->serialize($usuario,'json');
                $jsonContent = json_decode($jsonContent,true);
                return new JsonResponse($jsonContent);
            }
    }

    /**
     * @Route("/rest/usuario/{id}",options={"expose"=true}, name="actualizar_usuario")
     * @Method("PUT")
     * @param Request $request
     * @param Usuario $usuario
     *
     * @return JsonResponse
     */
    public function actualizarUsuario(Request $request,Usuario $usuario){
        $data = $request->getContent();
        $data = json_decode($data,true);

        $form = $this->createForm(UsuarioType::class,$usuario);
        $form->submit($data);

        $entity_manager = $this->getDoctrine()->getManager();
        $entity_manager->flush();

        $jsonContent = $this->get('serializer')->serialize($usuario,'json');
        $jsonContent = json_decode($jsonContent,true);

        return new JsonResponse($jsonContent);
    }


}