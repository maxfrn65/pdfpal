<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class PdfController extends AbstractController
{
    #[Route('/pdf', name: 'app_pdf')]
    public function index(HttpClientInterface $client, ParameterBagInterface $param, $filePath): Response
    {
        $microservice_url = $param->get('microservice_url');
        $response = $client->request(
            'POST',
            $microservice_url.'/pdf'
        );
        $content = $response->getContent();
        dump($content);
    }
}
