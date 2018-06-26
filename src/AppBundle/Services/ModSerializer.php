<?php
/**
 * Created by PhpStorm.
 * User: Usuario
 * Date: 24/6/2018
 * Time: 10:35 AM
 */

namespace AppBundle\Services;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;

class ModSerializer
{
    /**
     * @param $datos [Data to Json]
     *
     * @return JsonResponse [JSON Object]
     */
    public function serializeJson($datos){
        $encoders = array(new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());
        $serializer = new Serializer($normalizers,$encoders);

        return  $serializer->serialize($datos,"json");
    }
}