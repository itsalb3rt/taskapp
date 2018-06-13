<?php
/**
 * Created by PhpStorm.
 * User: Usuario
 * Date: 12/6/2018
 * Time: 11:33 AM
 */

namespace AppBundle\Controller\Tareas;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class TareasController extends Controller
{
    /**
     * @Route("/tareas", name="vista_tareas")
     */
    public function indexHome(Request $request){

        //Renderizando la vista
        return $this->render("@App/Tareas/index.html.twig", [
            'tareas' => "",
            'activar_opcion_menu' => 'tareas'
        ]);
    }
}