<?php

namespace App\Controller;

use App\Entity\Restaurante;
use App\Repository\RestauranteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class RestauranteController extends AbstractController
{
    //-----------------------------------LISTADO RESTAURANTES--------------------------------

    #[Route('/restaurante', name: 'listado_restaurantes' , methods:["GET"])]
    #[Route('/', name: 'raiz_restaurante' , methods:["GET"])]
    public function listado_restaurantes(RestauranteRepository $restauranteRepository): JsonResponse
    {

        $listaRestaurantes = $restauranteRepository->findAll();

        return $this->json($listaRestaurantes);




        /*
        return $this->render('restaurante/index.html.twig', [
            'controller_name' => 'RestauranteController',
        ]);
        //*/
    }

    //-----------------------------------CREAR RESTAURANTE--------------------------------


    #[Route('/restaurante', name: 'crear_restaurante' , methods:["POST"])]
    #[Route('/restaurante/crear', name: 'crear_restaurante' , methods:["POST" , "GET"])]
    public function crear_restaurante(EntityManagerInterface $manager , Request $request): JsonResponse
    {

        $restaurante = new Restaurante;

        $restaurante -> setNombre("kfc");
        $restaurante -> setDireccion("plaza mayor");
        $restaurante -> setTelefono("463546487");
        $restaurante -> setTipoCocina("comidaRapida");
        $manager -> persist($restaurante);
        $manager->flush();

        return $this->json("restaurante ha creado con ID " .$restaurante->getId());



        /*
        return $this->render('restaurante/index.html.twig', [
            'controller_name' => 'RestauranteController',
        ]);
        //*/
    }


    //-----------------------------------DETALLE RESTAURANTE--------------------------------

        #[Route('/restaurante/{id}', name: 'detalle_restaurante' , methods:[ "GET"])]
        public function detalle_restaurante(int $id,RestauranteRepository $restauranteRepository): JsonResponse
        {
            $restaurante = $restauranteRepository->find($id);

            return $this->json($restaurante);
            /*
            return $this->render('restaurante/index.html.twig', [
                'controller_name' => 'RestauranteController',
            ]);

            //*/
        }

    //-----------------------------------ELEMINAR RESTAURANTE--------------------------------

    #[Route('/restaurante/{id}', name: 'eleminar_restaurante' , methods:[ "DELETE"])]
    #[Route('/restaurante/{id}/delete', name: 'eleminar_restaurante_get',methods:["GET"])]

        public function eleminar_restaurante(int $id): Response
        {
            return $this->render('restaurante/index.html.twig', [
                'controller_name' => 'RestauranteController',
            ]);
        }


    //-----------------------------------ACTUALIZAR RESTAURANTE--------------------------------


    #[Route('/restaurante/{id}', name: 'actualizar_restaurante',methods:["PATCH"])]

        public function actualizar_restaurante(int $id): Response
        {
            return $this->render('restaurante/index.html.twig', [
                'controller_name' => 'RestauranteController',
            ]);
        }
}
