<?php

namespace App\Controller;

use App\Entity\Website;
use App\Form\WebsiteType;
use App\Repository\WebsiteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AdminController extends AbstractController
{

    /**
     * @Route("/admin/login", name="login")
     */
    public function login(AuthenticationUtils $utils) {
        $error = $utils->getLastAuthenticationError();
        return $this->render('admin/login.html.twig', [
            'error' => $error !== null
        ]);
    }


    /**
     * @Route("/admin/logout", name="logout")
     */
    public function logout() {

    }


    //retourne la liste des sites dans l'espace admin

    /**
     * @Route("/admin", name="admin_dashboard")
     */
    public function index(WebsiteRepository $repository)
    {
        $websites = $repository->findAll();
        return $this->render('admin/index.html.twig', [
            'websites' => $websites
        ]);
    }

    //ajout d'un nouveau site

    /**
     * @Route("/admin/new", name="admin_new")
     */
    public function new(Request $request, EntityManagerInterface $manager) {
        $website = new Website();
        $form = $this->createForm(WebsiteType::class, $website);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $manager->persist($website);
            $manager->flush();
            $this->addFlash('success', 'Site ajouté avec succès.');
            return $this->redirectToRoute('admin_dashboard');
        }

        return $this->render('admin/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    //Supression d'un site 

    /**
     * @Route("/admin/{id}/remove", name="admin_remove")
     */
    public function remove(EntityManagerInterface $manager, Website $website) {
        $manager->remove($website);
        $manager->flush();
        $this->addFlash('warning', 'Site web supprimé avec succès.');
        return $this->redirectToRoute('admin_dashboard');
    }

    /**
     * @Route("/admin/{id}/edit", name="admin_edit")
     */
    public function edit(Website $website, Request $request, EntityManagerInterface $manager) {
        $form = $this->createForm(WebsiteType::class, $website);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $manager->persist($website);
            $manager->flush();
            $this->addFlash('success', 'Site edité avec succès.');
            return $this->redirectToRoute('admin_dashboard');
        }

        return $this->render('admin/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

}
            # activate different ways to authenticate
            # https://symfony.com/doc/current/security.html#firewalls-authentication

            # https://symfony.com/doc/current/security/impersonating_user.html
            # switch_user: true

    # Easy way to control access for large sections of your site
    # Note: Only the *first* access control that matches will be used