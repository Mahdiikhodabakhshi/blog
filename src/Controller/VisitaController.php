<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VisitaController extends AbstractController
{
       //-----------------------------------LISTADO VISITAS--------------------------------

       #[Route('/visitas', name: 'listado_visitas' , methods:["GET"])]
       public function listado_visitas(): Response
       {
           return $this->render('restaurante/index.html.twig', [
               'controller_name' => 'RestauranteController',
           ]);
       }
   
       //-----------------------------------CREAR VISITAS--------------------------------
   
   
       #[Route('/visitas', name: 'crear_visitas' , methods:["POST"])]
       #[Route('/visitas/crear', name: 'crear_visitas' , methods:["POST" , "GET"])]
       public function crear_visitas(): Response
       {
           return $this->render('restaurante/index.html.twig', [
               'controller_name' => 'RestauranteController',
           ]);
       }
   
   
       //-----------------------------------DETALLE RESTAURANTE--------------------------------
   
           #[Route('/visitas/{id}', name: 'detalle_visitas' , methods:[ "GET"])]
           public function detalle_visitas(int $id): Response
           {
               return $this->render('restaurante/index.html.twig', [
                   'controller_name' => 'RestauranteController',
               ]);
           }
   
       //-----------------------------------ELEMINAR RESTAURANTE--------------------------------
   
       #[Route('/visitas/{id}', name: 'eleminar_visitas' , methods:[ "DELETE"])]
       #[Route('/visitas/{id}/delete', name: 'eleminar_visitas_get',methods:["GET"])]
   
           public function eleminar_visitas(int $id): Response
           {
               return $this->render('restaurante/index.html.twig', [
                   'controller_name' => 'RestauranteController',
               ]);
           }
   
   
       //-----------------------------------ACTUALIZAR RESTAURANTE--------------------------------
   
   
       #[Route('/visitas/{id}', name: 'actualizar_visitas',methods:["PATCH"])]
   
           public function actualizar_visitas(int $id): Response
           {
               return $this->render('restaurante/index.html.twig', [
                   'controller_name' => 'RestauranteController',
               ]);
           }
}
