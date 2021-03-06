<?php

namespace App\Controller;

use App\Entity\Question;
use App\Entity\QuizzDet;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use JMS\Serializer\SerializerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api")
 */
class ApiController extends AbstractFOSRestController
{

    /**
     * @Route("/ping", name="healthcheck", methods={"GET"})
     */
    public function getAction(): JsonResponse
    {
        return new JsonResponse('Pong');
    }


    /**
     * @Rest\Put("/quizzdet/{id}", name="put_quizzdet", methods={"PUT"}, requirements={"id"="\d+"})
     * @param Request $request
     * @param string  $id
     *
     * @return JsonResponse
     */
    public function putResultado(Request $request, string $id): JsonResponse
    {
        $em = $this->getDoctrine()->getManager();
        $quizzdet = $em->getRepository(QuizzDet::class)->find($id);

        $result = $request->get('result');
        $quizzdet->setResult($result);
        $em->persist($quizzdet);

        if ($result === 0) {
            /** @var Question $question */
            $question = $quizzdet->getQuestion();
            if ($question->getFails() === null) {
                $num_fails = 0;
            } else {
                $num_fails = $question->getFails();
            }

            $question->setFails($num_fails + 1);
            $em->persist($question);
        }

        $em->flush();
        return new JsonResponse('OK');
    }

    /**
     * @Rest\Put("/question/{id}/problem", name="put_problem_question", methods={"PUT"}, requirements={"id"="\d+"})
     * @param Request $request
     * @param string  $id
     *
     * @return JsonResponse
     */
    public function putQuestionProblemAction(Request $request, string $id): JsonResponse
    {
        $em = $this->getDoctrine()->getManager();
        $question = $em->getRepository(Question::class)->find($id);

        $problem = $request->get('problem');
        $question->setProblem($problem);
        $em->persist($question);

        $em->flush();
        return new JsonResponse('OK');
    }
}
