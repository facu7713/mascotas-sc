<?php

namespace App\Controller\ROLE_USER;

use App\Entity\Postulante;
use App\Form\PostulanteType;
use App\Repository\PostulanteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/particular/ser_voluntario')]
#[IsGranted('ROLE_USER')]
final class VoluntarioController extends AbstractController
{
    #[Route('', name: 'app_voluntario')]
    public function index(
        Request $request,
        PostulanteRepository $postulanteRepository,
        EntityManagerInterface $em
    ): Response {
        $persona = $this->getUser()->getPersona();

        $postulante = $postulanteRepository->findOneBy([
            'persona' => $persona,
        ]);

        if ($postulante === null) {
            $postulante = new Postulante();

            $form = $this->createForm(
                PostulanteType::class,
                $postulante
            );

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                $postulante->setPersona($persona);
                $postulante->setEstado('pendiente');
                $postulante->setFechaPostulacion(
                    new \DateTimeImmutable()
                );

                $em->persist($postulante);
                $em->flush();

                $this->addFlash(
                    'success',
                    'Tu postulación fue enviada correctamente.'
                );

                return $this->redirectToRoute('app_voluntario');
            }

            return $this->render(
                'particular/ser_voluntario/ser_voluntario.html.twig',
                [
                    'form' => $form->createView(),
                    'postulante' => null,
                ]
            );
        }

        return $this->render(
            'particular/ser_voluntario/ser_voluntario.html.twig',
            [
                'form' => null,
                'postulante' => $postulante,
            ]
        );
    }

    #[Route(
        '/{id}/eliminar',
        name: 'app_eliminar_postulacion',
        methods: ['POST']
    )]
    public function eliminar_postulacion(
        Postulante $postulante,
        Request $request,
        EntityManagerInterface $em
    ): Response {
    
        if (!$this->isCsrfTokenValid(
            'eliminar_postulacion' . $postulante->getId(),
            $request->request->get('_token')
        )) {
            throw $this->createAccessDeniedException(
                'Token de seguridad inválido.'
            );
        }
    
        if ($postulante->getPersona() !== $this->getUser()->getPersona()) {
            throw $this->createAccessDeniedException(
                'No podés eliminar esta postulación.'
            );
        }
    
        $em->remove($postulante);
        $em->flush();
    
        $this->addFlash(
            'success',
            'Tu postulación fue eliminada correctamente.'
        );
    
        return $this->redirectToRoute('app_voluntario');
    }
}
