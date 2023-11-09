<?php

namespace App\Controller;

use App\Entity\Visita;
use App\Repository\RestauranteRepository;
use App\Repository\VisitaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class VisitaController extends AbstractController
{
       //-----------------------------------LISTADO VISITAS--------------------------------

       #[Route('/visitas', name: 'listado_visitas' , methods:["GET"])]
       public function listado_visitas(VisitaRepository $visitaRepository): JsonResponse
       {

        $visitas = $visitaRepository->findAll();

        return $this->json($visitas);
            /*
           return $this->render('restaurante/index.html.twig', [
               'controller_name' => 'RestauranteController',
           ]);
           //*/
       }
   
       //-----------------------------------CREAR VISITAS--------------------------------
   
   
       #[Route('/visitas', name: 'crear_visitas' , methods:["POST"])]
      // #[Route('/visitas/crear/{id}', name: 'crear_visitas' , methods:["POST" , "GET"])]
       public function crear_visitas(EntityManagerInterface $Manager ,RestauranteRepository $r,Request $request): JsonResponse
       {
        $visita = new Visita();
        
        $res = $r->find(9);

        $visita -> setRestaurante($res);

        $visita -> setValoracion(10);
        $visita -> setComentario("muuuuy buena restaurante");


        return $this->json( '');
            /*        
           return $this->render('restaurante/index.html.twig', [
               'controller_name' => 'RestauranteController',
           ]);
           //*/
       }
   
   
       //-----------------------------------DETALLE RESTAURANTE--------------------------------
   
           #[Route('/visitas/{id}', name: 'detalle_visitas' , methods:[ "GET"])]
           public function detalle_visitas(int $id,VisitaRepository $visitaRepository): JsonResponse
           {
            $visita = $visitaRepository->find($id);
            if ($visita) {
                return $this->json($visita);
            }
            else{
                return $this->json("no exitse visita con ID ". $id );
            }


         
            /*
               return $this->render('restaurante/index.html.twig', [
                   'controller_name' => 'RestauranteController',
               ]);
               //*/
           }
   
       //-----------------------------------ELEMINAR RESTAURANTE--------------------------------
   
       #[Route('/visitas/{id}', name: 'eleminar_visitas' , methods:[ "DELETE"])]
      // #[Route('/visitas/{id}/delete', name: 'eleminar_visitas_get',methods:["GET"])]
   
           public function eleminar_visitas(int $id,VisitaRepository $visitaRepository,EntityManagerInterface $Manager): JsonResponse
           {    
            $visita = $visitaRepository->find($id);
            if ($visita) {
                $Manager->remove($visita);
                $Manager->flush();
                return $this->json("eleminado ". $id );

              }
            else{
                return $this->json("no existe ". $id );
            }



                /*
               return $this->render('restaurante/index.html.twig', [
                   'controller_name' => 'RestauranteController',
               ]);
               //*/
           }
   
   
       //-----------------------------------ACTUALIZAR RESTAURANTE--------------------------------
   
   
       #[Route('/visitas/{id}', name: 'actualizar_visitas',methods:["PATCH"])]
   
           public function actualizar_visitas(int $id,VisitaRepository $visitaRepository,EntityManagerInterface $manager): JsonResponse
           {
            $visita = $visitaRepository->find($id);
            if ($visita){
                $visita ->setValoracion(5);
                $visita -> setComentario("SSSDFGS");
              //  $visita -> setRestaurante(5);
              //  $Manager->persist($visita);
              //  $Manager->flush();
                
                return $this->json("Actualizado ". $id );
            }
            else{
                    return $this->json('NO EXISTE ID '. $id);
            }


                
                /*
               return $this->render('restaurante/index.html.twig', [
                   'controller_name' => 'RestauranteController',
               ]);
               //*/
           }
}
