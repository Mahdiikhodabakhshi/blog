<?php

namespace App\Controller;

use App\Entity\Restaurante;
use App\Repository\RestauranteRepository;
use App\Repository\VisitaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class RestauranteController extends AbstractController
{
    //-----------------------------------LISTADO RESTAURANTES--------------------------------

    #[Route('/restaurante', name: 'listado_restaurante' , methods:["GET"])]
    #[Route('/', name: 'raiz_restaurante' , methods:["GET"])]
    public function listado_restaurantes(RestauranteRepository $restauranteRepository): Response
    {
            /*
        $listaRestaurantes = $restauranteRepository->findAll();

        return $this->json($listaRestaurantes);
            //*/



        
        return $this->render('restaurante/listado_restaurante.html.twig', [
            'restaurantes' => $restauranteRepository->findAll(),
        ]);
        
    }

    //-----------------------------------CREAR RESTAURANTE--------------------------------


    #[Route('/restaurante', name: 'crear_restaurante' , methods:["POST"])]
   // #[Route('/restaurante/crear', name: 'crear_restaurante' , methods:["POST" , "GET"])]
    public function crear_restaurante(EntityManagerInterface $manager , Request $request): JsonResponse
    {

        $restaurante = new Restaurante;

        $restaurante -> setNombre("md");
        $restaurante -> setDireccion("plaza ajuntamiento");
        $restaurante -> setTelefono("999*487");
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
        public function detalle_restaurante(int $id,RestauranteRepository $restauranteRepository): Response
        {
             /*
            $restaurante = $restauranteRepository->find($id);

            if ($restaurante) {

                            return $this->json($restaurante);

            }else{
                return $this->json('No existe El restaurante con ID '.$id ,404);
            }

           //*/

          

            return $this->render('restaurante/detalle_restaurante.html.twig', [
                'restaurante' => $restauranteRepository->find($id),
                
                
            ]);

            
        }

    //-----------------------------------ELEMINAR RESTAURANTE--------------------------------

    #[Route('/restaurante/{id}', name: 'eleminar_restaurante' , methods:[ "DELETE"])]
    #[Route('/restaurante/{id}/delete', name: 'eleminar_restaurante_get',methods:["GET"])]
        public function eleminar_restaurante(int $id,RestauranteRepository $restauranteRepository , EntityManagerInterface $manager): JsonResponse
        {
            $restaurante = $restauranteRepository->find($id);

            if ($restaurante) {
                $manager -> remove($restaurante);
                $manager->flush();

                return $this->json('el restaurante ha eliminado con ID '. $id);
            }
            else{
                    return $this->json("NO EXISTE EL RESTAURANTE CON ID ".$id ,404);
            }

            
            /*
            return $this->render('restaurante/index.html.twig', [
                'controller_name' => 'RestauranteController',
            ]);
             //*/
        }
       


    //-----------------------------------ACTUALIZAR RESTAURANTE--------------------------------


    #[Route('/restaurante/{id}', name: 'actualizar_restaurante',methods:["PATCH"])]

        public function actualizar_restaurante(int $id , RestauranteRepository $restauranteRepository, EntityManagerInterface $manager): JsonResponse
        {
            $restaurante = $restauranteRepository->find($id);

            if ($restaurante) {
                $restaurante ->setNombre('BURGER KING');
                $restaurante->setDireccion('PLAZA CATALONYA');
                $restaurante->setTelefono('46546222222222');
                $manager->persist($restaurante);
                $manager->flush();
                return $this->json('ACTUALIZADO EL RESTAURANTE '. $id);
            }
            else{
                return $this->json("NO EXISTE ID ". $id ,404);

            }


            /*
            return $this->render('restaurante/index.html.twig', [
                'controller_name' => 'RestauranteController',
            ]);

            //*/
        }
}
