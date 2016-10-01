<?php

namespace AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use CoreBundle\Entity\Category;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class CategoryController extends Controller {

    public function listingAction(Request $request) {
        if (!$this->get('tleroch_admin.security')->verify()) {
            return $this->redirect($request->getBaseUrl());
        }

        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('CoreBundle:Category');
        $categories = $em->getRepository('CoreBundle:Category')->getCategoriesWithSubCategories();

        return $this->render('AdminBundle:Categories:listing.html.twig', array('categories' => $categories));
    }

    public function addAction(Request $request) {
        if (!$this->get('tleroch_admin.security')->verify()) {
            return $this->redirect($request->getBaseUrl());
        }

        $category = new Category();
        $form = $this->createForm('CoreBundle\Form\CategoryType');
        $form->setData($category);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($category);
                $em->flush();
                $this->get('session')->getFlashBag()->add('categories', 'Votre catégorie a bien été ajoutée.');
                return $this->redirectToRoute('admin_categories');
            }
        }

        return $this->render('AdminBundle:Categories:add.html.twig', array(
                    'form' => $form->createView()
        ));
    }

    public function editAction($id, Request $request) {
        if (!$this->get('tleroch_admin.security')->verify()) {
            return $this->redirect($request->getBaseUrl());
        }

        $em = $this->getDoctrine()->getManager();

        $category = $em->getRepository('CoreBundle:Category')->find($id);

        $form = $this->createForm('CoreBundle\Form\CategoryType');
        $form->setData($category);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (!is_null($category->getPhoto()) && $category->getPhoto() instanceof File) {
                $category->setPhoto($category->getPhoto()->getTotalFileName());
            }

            $em->flush();

            $this->get('session')->getFlashBag()->add('category', 'Votre categorie a bien été modifiée.');

            return $this->redirectToRoute('admin_categories');
        }

        return $this->render('AdminBundle:Categories:edit.html.twig', array(
                    'category' => $category,
                    'form' => $form->createView()
        ));
    }

    public function deleteAction(Request $request, $id) {

        if (!$this->get('tleroch_admin.security')->verify()) {
            return $this->redirect($request->getBaseUrl());
        }

        $em = $this->getDoctrine()->getManager();

        $category = $em->getRepository('CoreBundle:Category')->find($id);

        $form = $this->createFormBuilder()
                ->add('submit', SubmitType::class)
                ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Delete files
            if (!is_null($category->getPhoto())) {
                $image = $this->get('kernel')->getRootDir() . '/../web/' . $this->getParameter('tmp_photos_folder_upload') . $category->getPhoto->getTotalFileName();

                if (file_exists($image) && is_file($image)) {
                    unlink($image);
                }
            }

            $em->remove($category);
            $em->flush();

            $this->get('session')->getFlashBag()->add('category', 'Votre catégorie a bien été supprimée.');

            return $this->redirectToRoute('admin_categories');
        }

        return $this->render('AdminBundle:Categories:delete.html.twig', array(
                    'category' => $category,
                    'form' => $form->createView()
        ));
    }

}
