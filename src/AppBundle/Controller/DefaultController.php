<?php

namespace AppBundle\Controller;

use AppBundle\Entity\annonce;
use AppBundle\Entity\utilisateur;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig');
    }

    /**
     * Creates a new utilisateur entity.
     *
     * @Route("/new", name="utilisateur_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $utilisateur = new Utilisateur();
        $form = $this->createForm('AppBundle\Form\utilisateurType', $utilisateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($utilisateur);
            $em->flush();

            return $this->redirectToRoute('annonce_index', array('id' => $utilisateur->getId()));
        }

        return $this->render('utilisateur/new.html.twig', array(
            'utilisateur' => $utilisateur,
            'utilisateurform' => $form->createView(),
        ));
    }

    /**
     * Creates a new utilisateur entity.
     *
     * @Route("/connexion", name="utilisateur_connexion")
     * @Method({"GET", "POST"})
     */
    public function connexionAction()
    {
        $securityUtils=$this->get('security.authentication_utils');

        return $this->render('utilisateur/connexion.html.twig',[
            'lastUserName' => $securityUtils->getLastUsername(),
            'error'=>$securityUtils->getLastAuthenticationError()]
        );
    }

    /**
     * @Route("/contact/{id}",name="contact_utilisateur")
     * @return Response
     */
    public function contactAction(Request $request, annonce $annonce)
    {

        if($request->request->has('submit')){
            $email = $request->request->get('email');
            $message = $request->request->get('message');

            if(!empty ($email) && !empty($message)){
                $mailer=$this->get('mailer');
                $emailMessage= \Swift_Message::newInstance();
                $emailMessage
                    ->setTo($annonce->getUtilisateur()->getEmail())
                    ->setSubject('Réponse à votre annonce '.$annonce->getTitle())
                    ->setFrom($email)
                    ->setBody($message);

                $mailer->send($emailMessage);

                $this->addFlash('confirm','Votre message à été envoyé');

            }

        }

        return $this->render('default/contact.html.twig', ['annonce'=> $annonce]);
    }

    /**
     * @Route("/motDePasse",name="mot_de_passe_perdu")
     * @return Response
     */

    public function motDePassePerduAction(){

        return $this->render('default/motDePassePerdu.html.twig');
    }
}
