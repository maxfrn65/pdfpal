<?php

namespace App\Controller;

use App\Entity\Pdf;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class PdfController extends AbstractController
{
    #[Route('pdf/html-to-pdf', name: 'html_to_pdf')]
    public function index(EntityManagerInterface $entityManager, Request $request): Response
    {
        $userId = $this->getUser()->getId();
        $user = $entityManager->getRepository(User::class)->find($userId);

        return $this->render('pdf/htmltopdf.html.twig', [
            'user' => $user,
            'userId' => $userId,
        ]);
        //$microservice_url = $param->get('microservice_url');
        //$response = $client->request(
            //'POST',
            //$microservice_url . '/html-to-pdf'
        //);
        //$content = $response->getContent();
        //return new Response($content, "200", ["Content-Type" => "application/pdf"]);
    }

    #[Route('pdf/url-to-pdf', name: 'url_to_pdf')]
    public function urlToPdf(Request $request, HttpClientInterface $client, EntityManagerInterface $manager): Response
    {
        $pdf = new Pdf();

        $form = $this->createFormBuilder($pdf)
            ->add('url', UrlType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $url = $form->get('url')->getViewData();
            $pdf->setUser($this->getUser());
            $pdf->setTitle($url);
            $pdf->setCreatedAt(date('d/m/Y'));

            $manager->persist($pdf);
            $manager->flush();

            $response = $client->request('POST', $_ENV['MICROSERVICE_URL'] . '/url-to-pdf', [
                'body' => [
                    'url' => $url
                ]
            ]);
            $content = $response->getContent();
            return new Response($content, 200, ['Content-Type' => 'application/pdf']);
        }
        return $this->render('pdf/urltopdf.html.twig', [
            'urlForm' => $form
        ]);
    }
}
