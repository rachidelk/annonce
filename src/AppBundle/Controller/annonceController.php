<?php

namespace AppBundle\Controller;

use AppBundle\Entity\annonce;
use AppBundle\Entity\utilisateur;
use AppBundle\Form\annonceType;
use AppBundle\Form\annonceUtilisateurType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Annonce controller.
 *
 * @Route("annonce")
 */
class annonceController extends Controller
{
    /**
     * Lists all annonce entities.
     *
     * @Route("/", name="annonce_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $annonces = $em->getRepository('AppBundle:annonce')->findAll();

        $cat = $this->getDoctrine()->getManager();
        $categories = $cat->getRepository('AppBundle:categorie')->findAll();


        return $this->render('annonce/index.html.twig', array(
            'annonces' => $annonces,'categories'=>$categories
        ));
    }

    /**
     * Creates a new annonce entity.
     *
     * @Route("/new", name="annonce_new")
     * @Method({"GET", "POST"})
     */
    public function newAnnonceAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $annonce = new Annonce();

        if($this->getUser()== null) {
            $utilisateur = new Utilisateur();
            $form = $this->createForm(annonceUtilisateurType::class, $annonce);

        }else{
            $form = $this->createForm(annonceType::class, $annonce);
            $utilisateur = $this->getUser();
            $annonce->setUtilisateur($utilisateur);
        }

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($annonce);
            $em->flush();

            return $this->redirectToRoute('annonce_show', array('id' => $annonce->getId()));
        }

        return $this->render('annonce/new.html.twig', array(
            'annonce' => $annonce,
            'form' => $form->createView(),
            'utilisateur'=>$utilisateur,
        ));
    }



    /**
     * Finds and displays a annonce entity.
     *
     * @Route("/{id}", name="annonce_show",requirements={"id"="\d+"})
     * @Method("GET")
     */
    public function showAction(annonce $annonce)
    {
        $deleteForm = $this->createDeleteForm($annonce);

        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository('AppBundle:categorie')->findAll();

        return $this->render('annonce/show.html.twig', array(
            'annonce' => $annonce,
            'delete_form' => $deleteForm->createView(),'categories'=>$categories
        ));
    }

    /**
     * Displays a form to edit an existing annonce entity.
     *
     * @Route("/{id}/edit", name="annonce_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, annonce $annonce)
    {
        $deleteForm = $this->createDeleteForm($annonce);
        $editForm = $this->createForm('AppBundle\Form\annonceType', $annonce);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('annonce_edit', array('id' => $annonce->getId()));
        }

        return $this->render('annonce/edit.html.twig', array(
            'annonce' => $annonce,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a annonce entity.
     *
     * @Route("/{id}", name="annonce_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, annonce $annonce)
    {
        $form = $this->createDeleteForm($annonce);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($annonce);
            $em->flush($annonce);
        }

        return $this->redirectToRoute('annonce_index');
    }

    /**
     * Creates a form to delete a annonce entity.
     *
     * @param annonce $annonce The annonce entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(annonce $annonce)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('annonce_delete', array('id' => $annonce->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
