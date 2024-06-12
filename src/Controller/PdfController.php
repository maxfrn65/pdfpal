<?php

namespace App\Controller;

use App\Entity\Pdf;
use App\Entity\User;
use Doctrine\ORM\EntityManager;
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
    public function index(HttpClientInterface $client, Request $request, EntityManagerInterface $manager): Response
    {
        $userId = $this->getUser()->getId();
        $user = $manager->getRepository(User::class)->find($userId);

        $htmlPdf = new Pdf();

        $form = $this->createFormBuilder($htmlPdf)
            ->add('file', FileType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form['file']->getData();
            $htmlPdf->setTitle($file->getClientOriginalName());
            $file->move('./', 'pdf.html');

            $fp = fopen('pdf.html', 'r');
            $htmlPdf->setUser($this->getUser());
            $htmlPdf->setCreatedAt(date('d/m/Y'));

            $manager->persist($htmlPdf);
            $manager->flush();

            $response = $client->request('POST', $_ENV['MICROSERVICE_URL'] . '/html-to-pdf', [
                'headers' => [
                    'Content-Type' => 'multipart/form-data'
                ],
                'body' => [
                    'file' => $fp
                ]
            ]);
            $content = $response->getContent();
            return new Response($content, 200, ['Content-Type' => 'application/pdf']);
        }
        return $this->render('pdf/htmltopdf.html.twig', [
            'htmlForm' => $form,
            'user' => $user
        ]);
    }

    #[Route('pdf/url-to-pdf', name: 'url_to_pdf')]
    public function urlToPdf(Request $request, HttpClientInterface $client, EntityManagerInterface $manager): Response
    {
        $userId = $this->getUser()->getId();
        $user = $manager->getRepository(User::class)->find($userId);

        $urlPdf = new Pdf();

        $form = $this->createFormBuilder($urlPdf)
            ->add('url', UrlType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $url = $form->get('url')->getViewData();
            $urlPdf->setUser($this->getUser());
            $urlPdf->setTitle($url);
            $urlPdf->setCreatedAt(date('d/m/Y'));

            $manager->persist($urlPdf);
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
            'urlForm' => $form,
            'user' => $user
        ]);
    }
}
