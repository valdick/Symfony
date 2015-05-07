<?php

namespace Vlad\HelloBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Vlad\HelloBundle\Entity\First;
use Vlad\HelloBundle\Form\FirstType;

/** Class FirstController */
class FirstController extends Controller
{
    /**
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('VladHelloBundle:First')->findAll();

        return $this->render('VladHelloBundle:First:index.html.twig', array('entities' => $entities));
    }

    /**
     * @return Response
     */
    public function newAction()
    {
        $entity = new First();
        $form   = $this->createCreateForm($entity);

        return $this->render('VladHelloBundle:First:new.html.twig', array('entities' => $entity, 'form' => $form->createView()));
    }

    /**
     * @param First $entity
     * @return \Symfony\Component\Form\Form
     */
    private function createCreateForm(First $entity)
    {
        $form = $this->createForm(new FirstType(), $entity, array(
            'action' => $this->generateUrl('vlad_first_create'),
            'method' => 'POST',
        ));
        $form->add('submit', 'submit', array('label' => 'Добавить пользователя'));

        return $form;
    }

    /**
     * @param Request $request
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function createAction(Request $request)
    {
        $entity = new First();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('vlad_first', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * @param $id
     * @return Response
     */
    public function showAction($id){
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('VladHelloBundle:First')->find($id);

        if (!$entity) {
            return new Response ('Пользователь не найден');
        }
        else {
            return $this->render('VladHelloBundle:First:show.html.twig', array('entity' => $entity));
        }

//        $deleteForm = $this->createDeleteForm($id);
//
//        return array(
//            'entity'      => $entity,
//            'delete_form' => $deleteForm->createView(),
//        );
    }

    /**
     * @param $id
     * @return Response
     */
    public function editAction($id){
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('VladHelloBundle:First')->find($id);

        if (!$entity) {
            return new Response ('Пользователь не найден');
        }
        else {
            $editForm = $this->createEditForm($entity);
            return $this->render('VladHelloBundle:First:edit.html.twig', array('form' => $editForm->createView()));
        }
    }

    /**
     * @param First $entity
     * @return \Symfony\Component\Form\Form
     */
    private function createEditForm(First $entity)
    {
        $form = $this->createForm(new FirstType(), $entity, array(
            'action' => $this->generateUrl('vlad_first_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Изменить'));

        return $form;
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function updateAction(Request $request, $id){
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VladHelloBundle:First')->find($id);

        if (!$entity) {
            return new Response('Ошибка $entity ненайден');
        }
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('vlad_first', array('id' => $id)));
        }
    }

    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction($id)
    {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('VladHelloBundle:First')->find($id);

            $em->remove($entity);
            $em->flush();


        return $this->redirect($this->generateUrl('vlad_first'));
    }
}

