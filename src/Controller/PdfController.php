<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class PdfController extends AbstractController
{
    #[Route('/html-to-pdf', name: 'app_pdf')]
    public function index(HttpClientInterface $client, ParameterBagInterface $param): Response
    {
        $microservice_url = $param->get('microservice_url');
        $response = $client->request(
            'POST',
            $microservice_url . '/html-to-pdf'
        );
        $content = $response->getContent();
        return new Response($content, "200", ["Content-Type" => "application/pdf"]);
    }
}
