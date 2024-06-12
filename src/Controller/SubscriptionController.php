<?php

namespace App\Controller;

use App\Entity\Subscription;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SubscriptionController extends AbstractController
{
    #[Route(path: "/choose-subscription/{userId}", name: "app_choose_subscription")]
    public function chooseSubscription(int $userId, Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $entityManager->getRepository(User::class)->find($userId);

        if (!$user) {
            throw $this->createNotFoundException('No user found for id ' . $userId);
        }

        if ($request->isMethod('POST')) {
            $subscriptionId = $request->request->get('subscription_id');
            $subscription = $entityManager->getRepository(Subscription::class)->find($subscriptionId);

            if ($subscription) {
                $user->setSubscription($subscription);
                $entityManager->flush();
                $this->addFlash('success', 'Your plan has been changed successfully.');

            // Redirect to a success page or login
                return $this->redirectToRoute('app_home');
            }
        }

        $subscriptions = $entityManager->getRepository(Subscription::class)->findAll();

        return $this->render('subscription/choose_subscription.html.twig', [
        'subscriptions' => $subscriptions,
        ]);
    }
}
