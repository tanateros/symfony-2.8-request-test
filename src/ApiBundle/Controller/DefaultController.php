<?php

namespace ApiBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Serializer;
use ApiBundle\Entity\Request as RequestEntity;

class DefaultController extends Controller
{
    /**
    * @Route("/storeRequest/{route}", name="store-request")
    */
    public function storeRequestAction($route, Request $request)
    {
        try {
            $requestRow = new RequestEntity();
            $requestRow
                ->setHeaders(json_encode($request->headers->all()))
                ->setBody($request->request->all() ? json_encode($request->request->all()) : json_encode($request->query->all()))
                ->setRoute($route)
                ->setMethod($request->getMethod())
                ->setIp($request->getClientIp())
                ->setCreated();

            $em = $this->getDoctrine()->getManager();
            $em->persist($requestRow);
            $em->flush();

            $responseBody = [
                'Success' => true,
                'id' => $requestRow->getId()
            ];
        } catch (\Exception $e) {
            $responseBody = [
                'Success' => false,
                'message' => 'reason of fail'
            ];
        }

        $encoder = new JsonEncoder();
        $normalizer = new GetSetMethodNormalizer();
        $serializer = new Serializer(array($normalizer), array($encoder));
        $response = new JsonResponse();
        $response->setContent($serializer->serialize($responseBody, 'json'));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
    * @Route("/getRequest/", name="get-request")
    */
    public function getRequestAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $result = $em->getRepository('ApiBundle:Request')->findRequest($request->query->all());

        $encoder = new JsonEncoder();
        $normalizer = new GetSetMethodNormalizer();
        $serializer = new Serializer(array($normalizer), array($encoder));
        $response = new JsonResponse();
        $response->setContent($serializer->serialize($result, 'json'));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
}
