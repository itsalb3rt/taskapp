<?php
/**
 * Created by PhpStorm.
 * User: Usuario
 * Date: 12/6/2018
 * Time: 10:16 AM
 */

namespace AppBundle\Controller\Home;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomeController extends Controller
{
    /**
     * @Route("/home", name="vista_home")
     */
    public function indexHome(){

        //Renderizando la vista
        return $this->render("@App/Home/home.html.twig");
    }
}