<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class PdfController extends AbstractController
{
    #[Route('/html-to-pdf', name: 'html_to_pdf')]
    public function index(HttpClientInterface $client, ParameterBagInterface $param): Response
    {
        return $this->render('pdf/htmltopdf.html.twig');
        //$microservice_url = $param->get('microservice_url');
        //$response = $client->request(
            //'POST',
            //$microservice_url . '/html-to-pdf'
        //);
        //$content = $response->getContent();
        //return new Response($content, "200", ["Content-Type" => "application/pdf"]);
    }

    #[Route('/url-to-pdf', name: 'url_to_pdf')]
    public function urlToPdf(): Response
    {
        return $this->render('pdf/urltopdf.html.twig');
    }
}
