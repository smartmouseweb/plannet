<?php

namespace App\Controller;

use App\Entity\TranslationLocale;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class AccountController extends AbstractController
{
    #[Route('/account', name: 'account')]
    public function index(UserInterface $user, EntityManagerInterface $em): Response
    {
        return $this->render('account/index.html.twig', [
            'langs' => $em->getRepository(TranslationLocale::class)->findAll()
        ]);
    }
}
