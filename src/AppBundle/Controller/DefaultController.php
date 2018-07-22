<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => "Albert Hidalgo",
            'activar_opcion_menu' => 'home'
        ]);
    }

    /**
     * @Route("^/", name="verificar_login")
     */
    public function verificar_login()
    {
        if($this->getUser() == null){
            return $this->redirectToRoute('login');
        }
    }
}
