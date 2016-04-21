<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use AppBundle\Entity\Link;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        return $this->render('AppBundle:default:index.html.twig');
    }

    /**
     * @Route("/generate", name="generate")
     * @Method("post")
     */
    public function generateAction(Request $request)
    {
        $destination = $request->request->get('destination');

        if (filter_var($destination, FILTER_VALIDATE_URL) === false) {
            return new JsonResponse([
                'error' => 'Incorrect link',
            ]);
        }

        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('AppBundle:Link');

        $link = $repository->findOneBy(['destination' => $destination]);

        if (!$link) {
            do {
                $code = $this->get('token_generator')->getToken(6);
            } while ($repository->findOneBy(['code' => $code]));

            $link = new Link;
            $link->setDestination($destination);
            $link->setCode($code);

            $em->persist($link);
            $em->flush();
        }

        return new JsonResponse([
            'code' => $link->getCode(),
        ]);
    }

    /**
     * @Route("/{code}", name="goto")
     * @Method("get")
     */
    public function gotoAction($code)
    {
        $link = $this->getDoctrine()->getRepository('AppBundle:Link')->findOneBy(['code' => $code]);
        if (!$link) {
            throw new NotFoundHttpException('Link not found');
        }
        return $this->redirect($link->getDestination());
    }
}
