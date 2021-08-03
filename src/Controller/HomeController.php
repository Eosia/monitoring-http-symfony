<?php

namespace App\Controller;


use App\Entity\Status;
use App\Entity\Website;
use App\Repository\StatusRepository;
use App\Repository\WebsiteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{

    private $mailer;

    public function __construct(\Swift_Mailer $mailer) {
        $this->mailer = $mailer;
    }

    /**
     * @Route("/", name="home")
     */
    public function index(WebsiteRepository $repository, StatusRepository $statusRepo)
    {
        $websites = $repository->findAll();
        $count = count($websites);
        $status = $statusRepo->getLastStatus($count);

        return $this->render('home/index.html.twig', [
            'websites' => $websites,
            'status' => $status
        ]);
    }


    /**
     * @Route("/websites/clean", name="clean")
     */
    public function clean(StatusRepository $repository) {
        //Supprimer tous les status
        $repository->cleanStatusHistory();
        $this->addFlash('warning', 'L\'historique des statuts a bien été effacé !');
        //Se rediriger vers l'accueil
        return $this->redirectToRoute('home');
    }


    /**
     * @Route("/websites/analyze", name="analyze")
     */
    public function analyze(WebsiteRepository $repository, EntityManagerInterface $manager) {
        //Récupération de tous les sites 
        $websites = $repository->findAll();

        //Récupération des status actuel des sites
        foreach($websites as $key =>$site) {
            $url = $site->getUrl();
            $handle = curl_init($url);
            curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($handle);
            $code = curl_getinfo($handle, CURLINFO_HTTP_CODE);
            curl_close($handle);

            //Créer une nouvelle entité status et enregistrer en db
            $status = new Status();
            $status->setCode($code)
                ->setReportedAt(new \DateTime())
                ->setWebsite($site);
                $manager->persist($status);

            if(
                $status->getCode() === 0 || $status->getCode() === 403 
                || $status->getCode() === 404 || $status->getCode() === 500 
                || $status->getCode() === 501 || $status->getCode() === 502
                || $status->getCode() === 503 || $status->getCode() === 401
                || $status->getCode() === 504 || $status->getCode() === 310
                || $status->getCode() === 409 || $status->getCode() === 429
                || $status->getCode() === 508 || $status->getCode() === 520
                || $status->getCode() === 521 || $status->getCode() === 522
                || $status->getCode() === 523 || $status->getCode() === 524
                || $status->getCode() === 525 || $status->getCode() === 526
                ) {
                $message = (new \Swift_Message('Alerte site hors service !
                '))
                    ->setFrom('alert@eosiaweb.be')
                    ->setTo('kevin.eosiaweb@gmail.com')
                    ->setBody(
                        $this->renderView('admin/email.html.twig', compact('status', 'site')), 'text/html'
                    );
                $this->mailer->send($message);
            }
        }

        $manager->flush();

        $this->addFlash(
            'success',
            'Diagnostique bien effectué !'
        );

        //Redirection vers la route home
        return $this->redirectToRoute('home');

    }

    /**
     * @Route("/websites/{id}", name="website_show")
     */

    public function show(Website $website) {
        return $this->render('home/show.html.twig', [
            'website' => $website
        ]);
    }
}


