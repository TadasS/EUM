<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Entity\person;
use AppBundle\Entity\groups;

/**
 * api controller.
 *
 * @Route("/api")
 */
class apiController extends Controller
{
    /**
     * Lists all persons with groups
     *
     * @Route("/persons", name="api_persons")
     * @Method("GET")
     */
    public function personsAction()
    {
        $em             = $this->getDoctrine()->getManager();
        $persons        = $em->getRepository('AppBundle:person')->findAll();

        $response       = [];

        foreach ($persons as $p) {
            $groups     = [];

            foreach ($p->getGroups() as $group) {
                $groups[] = array(
                    'id'          => $group->getId(),
                    'name'        => $group->getName()
                );
            }

            $response[] = array(
                'id'              => $p->getId(),
                'firstName'       => $p->getFirstName(),
                'lastName'        => $p->getLastName(),
                'groups'          => $groups,
            );
        }

        return new JsonResponse($response);
    }

    /**
     * Lists all groups with persons
     *
     * @Route("/groups", name="api_groups")
     * @Method("GET")
     */
    public function groupsAction()
    {
        $em             = $this->getDoctrine()->getManager();
        $groups         = $em->getRepository('AppBundle:groups')->findAll();

        $response       = [];

        foreach ($groups as $g) {
            $persons    = [];

            foreach ($g->getPersons() as $person) {
                $persons[] = array(
                    'id'          => $person->getId(),
                    'firstName'   => $person->getFirstName(),
                    'lastName'    => $person->getLastName()
                );
            }

            $response[] = array(
                'id'              => $g->getId(),
                'name'            => $g->getName(),
                'persons'         => $persons
            );
        }

        return new JsonResponse($response);
    }

    /**
     * Finds and displays single person with groups.
     *
     * @Route("/person/{id}", name="api_person")
     * @Method("GET")
     */
    public function personAction($id)
    {
        $em             = $this->getDoctrine()->getManager();
        $person         = $em->getRepository('AppBundle:person')->findOneBy(array('id' => $id));

        if (!is_null($person)) {
            $groups     = [];

            foreach ($person->getGroups() as $group) {
                $groups[] = array(
                    'id'          => $group->getId(),
                    'name'        => $group->getName()
                );
            }

            $response   = array(
                'id'              => $person->getId(),
                'firstName'       => $person->getFirstName(),
                'lastName'        => $person->getLastName(),
                'groups'          => $groups
            );
        } else {
            $response   = array(
                'error'           => 'Person not found.'
            );
        }

        return new JsonResponse($response);
    }

    /**
     * Finds and displays single group with persons.
     *
     * @Route("/group/{id}", name="api_group")
     * @Method("GET")
     */
    public function groupAction($id)
    {
        $em             = $this->getDoctrine()->getManager();
        $group          = $em->getRepository('AppBundle:groups')->findOneBy(array('id' => $id));

        if (!is_null($group)) {
            $persons    = [];

            foreach ($group->getPersons() as $person) {
                $persons[] = array(
                    'id'          => $person->getId(),
                    'firstName'   => $person->getFirstName(),
                    'lastName'    => $person->getLastName()
                );
            }

            $response   = array(
                'id'              => $group->getId(),
                'name'            => $group->getName(),
                'persons'         => $persons
            );
        } else {
            $response   = array(
                'error'           => 'Group not found.'
            );
        }

        return new JsonResponse($response);
    }

    /**
     * Add's new person
     *
     * @Route("/persons/new", name="api_new_person")
     * @Method("POST")
     */
    public function newPersonAction(Request $request)
    {
        if (empty($request->get('firstName')) || empty($request->get('lastName'))) {

            return new JsonResponse(array(
                'error'           => '`firstName` && `lastName` must be set.'
            ));
        }

        $person = new person();
        $person->setFirstName($request->get('firstName'));
        $person->setLastName($request->get('lastName'));

        $em = $this->getDoctrine()->getManager();
        $em->persist($person);
        $em->flush();

        return new JsonResponse(array(
            'success'             => 'Person added.'
        ));
    }

    /**
     * Add's new person
     *
     * @Route("/groups/new", name="api_new_group")
     * @Method("POST")
     */
    public function newGroupAction(Request $request)
    {
        if (empty($request->get('name'))) {

            return new JsonResponse(array(
                'error'           => '`name` must be set.'
            ));
        }

        $group = new groups();
        $group->setName($request->get('name'));

        $em = $this->getDoctrine()->getManager();
        $em->persist($group);
        $em->flush();

        return new JsonResponse(array(
            'success'             => 'Group added.'
        ));
    }

    /**
     * Delete's person
     *
     * @Route("/person/{id}", name="api_delete_person")
     * @Method("DELETE")
     */
    public function deletePersonAction($id)
    {
        $em             = $this->getDoctrine()->getManager();
        $person         = $em->getRepository('AppBundle:person')->findOneBy(array('id' => $id));

        if (!is_null($person)) {
            $em->remove($person);
            $em->flush();

            $response   = array(
                'success'         => 'Person deleted.'
            );
        } else {
            $response   = array(
                'error'           => 'Person not found.'
            );
        }

        return new JsonResponse($response);
    }

    /**
     * Delete's group
     *
     * @Route("/group/{id}", name="api_delete_group")
     * @Method("DELETE")
     */
    public function deleteGroupAction($id)
    {
        $em             = $this->getDoctrine()->getManager();
        $group          = $em->getRepository('AppBundle:groups')->findOneBy(array('id' => $id));

        if (!is_null($group)) {
            $em->remove($group);
            $em->flush();

            $response   = array(
                'success'         => 'Group deleted.'
            );
        } else {
            $response   = array(
                'error'           => 'Group not found.'
            );
        }

        return new JsonResponse($response);
    }
}
