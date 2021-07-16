<?php

namespace App\Controller\Admin;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * $this->denyAccessUnlessGranted('ROLE_USER');
 */

class AdminController extends AbstractController
{
    /**
     * @Route("/admin/", name="admin_index")
     */
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('admin/admin/index.html.twig', [
            'controller_name' => 'AdminController',
            'users30'   => $userRepository->findByLastThirty(),
            'users7'   => $userRepository->findByLastSeven(),
            'users3'   => $userRepository->findByLastThree(),

        ]);
    }
}
