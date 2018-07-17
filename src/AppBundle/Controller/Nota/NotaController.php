<?php
/**
 * Created by PhpStorm.
 * User: Usuario
 * Date: 11/6/2018
 * Time: 6:44 PM
 */

namespace AppBundle\Controller\Nota;

use AppBundle\Entity\Nota;
use AppBundle\Entity\Usuario;
use AppBundle\Form\NotaType;
use AppBundle\Services\ModSerializer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;

class NotaController extends Controller
{

    /**
     * @Route("/rest/guardar_nota",options={"expose"=true}, name="guardar_nota")
     * @Method("POST")
     * @param Request $request
     * @return Response
     */
    public function guardar_nota(Request $request){
        $fecha = new \DateTime('now', (new \DateTimeZone('America/Santiago')));
        $data = $request->getContent();
        $data = json_decode($data,true);

        $nota = new Nota();
        $nota->setFecha($fecha);
        $form = $this->createForm(NotaType::class,$nota);
        $form->submit($data);

        $entity_manager = $this->getDoctrine()->getManager();
        $entity_manager->persist($nota);
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
        $json =  $serializer->serialize($data,'json');
        return new JsonResponse($json);
    }

}