<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\User1Type;
use App\Repository\UserRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**register with automatically values symfony
 * @Route("/admin/user")
 * $this->denyAccessUnlessGranted('ROLE_ADMIN');
 */
class AdminUserController extends AbstractController
{

    /**
     * @Route("/new", name="admin_user_new", methods={"GET","POST"})
     */
    public function new(Request $request, UserPasswordEncoderInterface $passwordEncoder, MailerInterface $mailer): Response
    {
        // dodawanie nowego Usera z pozycji Admina
        $user = new User();
        $form = $this->createForm(User1Type::class, $user);
        $form->handleRequest($request);

        // walidacja
        if ($form->isSubmitted() && $form->isValid()) {
            // kodowanie hasła
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $user->setCreatedAt(new \DateTime());

            // sprawdzenie pełnoletności
            $dzisiaj = new DateTime(date("Y-m-d"));
            $urodziny = $user->getDob();
            $interval = $dzisiaj->diff($urodziny);

            if (intval($interval->y) > 18) {
                $user->setIsVerified(true);

                // wysyłanie @ z przywitaniem
                $email = (new Email())
                    ->from(new Address('no-reply@netinteractive.test', 'Hello www.netinteractive.test'))
                    ->to($user->getEmail())
                    ->subject('Dzień dobry')
                    ->text('Witaj w systemie')
                    ->html('<p>Witaj w systemie!</p>');

                $mailer->send($email);
                // koniec wysyłania

            } else {
                $user->setIsVerified(false);
            }
            // koniec sprawdzania pełnoletności

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();


            return $this->redirectToRoute('admin_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin_user/new.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }
    

    // /**
    //  * @Route("/{id}", name="admin_user_show", methods={"GET"})
    //  */
    // public function show(User $user): Response
    // {
    //     return $this->render('admin_user/show.html.twig', [
    //         'user' => $user,
    //     ]);
    // }

    // /**
    //  * @Route("/{id}/edit", name="admin_user_edit", methods={"GET","POST"})
    //  */
    // public function edit(Request $request, User $user): Response
    // {
    //     $form = $this->createForm(User1Type::class, $user);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $this->getDoctrine()->getManager()->flush();

    //         return $this->redirectToRoute('admin_user_index', [], Response::HTTP_SEE_OTHER);
    //     }

    //     return $this->render('admin_user/edit.html.twig', [
    //         'user' => $user,
    //         'form' => $form->createView(),
    //     ]);
    // }
}
