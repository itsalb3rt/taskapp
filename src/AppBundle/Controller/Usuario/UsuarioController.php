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
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;

class UsuarioController extends Controller
{

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
    public function guardarUsuario(Request $request,UserPasswordEncoderInterface $encoder){
        $data = $request->getContent();
        $data = json_decode($data,true);

        $usuario = new Usuario();


        $form = $this->createForm(UsuarioType::class,$usuario);
        $form->submit($data);
                //cifrando clave
                $passcifrado = $encoder->encodePassword($usuario,$usuario->getContrasena());
                $usuario->setContrasena($passcifrado);
                $entity_manager = $this->getDoctrine()->getManager();
                $entity_manager->persist($usuario);
                $entity_manager->flush();

                $jsonContent = $this->get('serializer')->serialize($usuario,'json');
                $jsonContent = json_decode($jsonContent,true);

                return new JsonResponse($jsonContent);
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

        $usuario->setUsername($data['username']);
        $usuario->setNombre($data['nombre']);
        $usuario->setTipoUsuario($data['tipoUsuario']);

        $entity_manager = $this->getDoctrine()->getManager();
        $entity_manager->flush();

        $jsonContent = $this->get('serializer')->serialize($data,'json');
        $jsonContent = json_decode($jsonContent,true);

        return new JsonResponse($jsonContent);
    }

    /**
     * @Route("/rest/usuario/{id}",options={"expose"=true}, name="reestablecer_contrasena")
     * @Method("POST")
     * @param Request $request
     * @param Usuario $usuario
     *
     * @return JsonResponse
     */
    public function reestablecer_contrasena(Request $request,Usuario $usuario,UserPasswordEncoderInterface $encoder){
        $data = $request->getContent();
        $data = json_decode($data,true);
        $contrasena = mt_rand(100000,999999);
        $usuario->setContrasena($encoder->encodePassword($usuario,$contrasena));

        $entity_manager = $this->getDoctrine()->getManager();
        $entity_manager->flush();

        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(1);
        // Add Circular reference handler
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });

        $normalizers = array($normalizer);
        $serializer = new Serializer($normalizers, $encoders);
        $json =  $serializer->serialize(['contrasena'=>$contrasena],'json');
        return new JsonResponse($json);
    }

    /**
     * @Route("/login", name="login")
     * @param Request $request
     * @param AuthenticationUtils $authenticationUtils
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function loginAction(Request $request,AuthenticationUtils $authenticationUtils) {
        // Verificar si el usuario esta logueado y intenta entrar al login
        if($this->getUser()!=null){
            return $this->redirectToRoute('vista_home');
        }
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render(
            '@App/Usuario/login.html.twig',
            [
                'error'=>$error,
                'last_username'=>$lastUsername
            ]);
    }

    /**
     * @Route("/login_check", name="login_check")
     */
    public function loginCheckAction(){

    }
    /**
     * @Route("/logout",name="logout")
     */
    public function logoutAction(){

    }

}