<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\groups;
use AppBundle\Form\groupsType;

/**
 * groups controller.
 *
 * @Route("/groups")
 */
class groupsController extends Controller
{
    /**
     * Lists all groups entities.
     *
     * @Route("/", name="groups_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $groups = $em->getRepository('AppBundle:groups')->findAll();
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $groups,
            $request->query->getInt('page', 1),
            15
        );
        $pagination->setTemplate('twitter_bootstrap_v3_pagination.html.twig');

        return $this->render('groups/index.html.twig', array(
            'pagination' => $pagination
        ));
    }

    /**
     * Creates a new groups entity.
     *
     * @Route("/new", name="groups_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $group = new groups();
        $form = $this->createForm('AppBundle\Form\groupsType', $group);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($group);
            $em->flush();

            return $this->redirectToRoute('groups_show', array('id' => $group->getId()));
        }

        return $this->render('groups/new.html.twig', array(
            'group' => $group,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a groups entity.
     *
     * @Route("/{id}", name="groups_show")
     * @Method("GET")
     */
    public function showAction(groups $group)
    {
        $deleteForm = $this->createDeleteForm($group);

        return $this->render('groups/show.html.twig', array(
            'group' => $group,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing groups entity.
     *
     * @Route("/{id}/edit", name="groups_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, groups $group)
    {
        $deleteForm = $this->createDeleteForm($group);
        $editForm = $this->createForm('AppBundle\Form\groupsType', $group);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($group);
            $em->flush();

            return $this->redirectToRoute('groups_edit', array('id' => $group->getId()));
        }

        return $this->render('groups/edit.html.twig', array(
            'group' => $group,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a groups entity.
     *
     * @Route("/{id}", name="groups_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, groups $group)
    {
        $form = $this->createDeleteForm($group);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($group);
            $em->flush();
        }

        return $this->redirectToRoute('groups_index');
    }

    /**
     * Creates a form to delete a groups entity.
     *
     * @param groups $group The groups entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(groups $group)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('groups_delete', array('id' => $group->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
