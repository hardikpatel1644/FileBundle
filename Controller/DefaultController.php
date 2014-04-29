<?php

namespace Oxind\FileBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Oxind\FileBundle\Entity\File;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{

    public function indexAction(Request $request)
    {
        $asFiles = $this->getDoctrine()->getRepository('OxindFileBundle:File')->findAll();
        if ($request->get('id'))
        {

            $obEm = $this->getDoctrine()->getManager();
            $obFiles = $obEm->getRepository('OxindFileBundle:File')->find($request->get('id'));
            $obEm->remove($obFiles);
            $obEm->flush();
            return $this->redirect($this->generateUrl('oxind_file_list'));
        }
        return $this->render('OxindFileBundle:Default:index.html.twig', array('asFiles' => $asFiles));
    }

    /**
     * @Template()
     */
    public function uploadAction(Request $request)
    {
        $file = new File();
        $form = $this->createFormBuilder($file)
                ->add('name')
                ->add('file')
                ->add('submit', 'submit')
                ->getForm();

        $form->handleRequest($request);

        if ($form->isValid())
        {

            $em = $this->getDoctrine()->getManager();
            $em->persist($file);
            $em->flush();
            $file->upload();
            return $this->redirect($this->generateUrl('oxind_file_list'));
        }

        return array('form' => $form->createView());
    }

}
