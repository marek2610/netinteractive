<?php

namespace App\Controller\Admin;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin")
 * $this->denyAccessUnlessGranted('ROLE_ADMIN');
 */

class AdminController extends AbstractController
{
    /**
     * @Route("/", name="admin_index")
     */
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('admin/admin/index.html.twig', [
            'controller_name' => 'AdminController',
            'users'   => $userRepository->findByAllUsers(),

        ]);
    }

    /**
     * @Route("/thirty", name="admin_index30")
     */
    public function thirty(UserRepository $userRepository): Response
    {
        return $this->render('admin/admin/index.html.twig', [
            'controller_name' => 'AdminController',
            'users'   => $userRepository->findByLastThirty(),
        ]);
    }

    /**
     * @Route("/seven", name="admin_index07")
     */
    public function seven(UserRepository $userRepository): Response
    {
        return $this->render('admin/admin/index.html.twig', [
            'controller_name' => 'AdminController',
            'users'   => $userRepository->findByLastSeven(),
        ]);
    }

    /**
     * @Route("/three", name="admin_index03")
     */
    public function three(UserRepository $userRepository): Response
    {
        return $this->render('admin/admin/index.html.twig', [
            'controller_name' => 'AdminController',
            'users'   => $userRepository->findByLastThree(),
        ]);
    }
}
