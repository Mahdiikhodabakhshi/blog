<?php

namespace App\Controller;

use App\Entity\Visita;
use App\Repository\VisitaRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\RestauranteRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Loader\Configurator\form;

class VisitaController extends AbstractController
{
       //-----------------------------------LISTADO VISITAS--------------------------------

       #[Route('/visitas', name: 'listado_visitas' , methods:["GET"])]
       public function listado_visitas(VisitaRepository $visitaRepository): Response
       {

         

        
            
           return $this->render('visita/visitas.html.twig', [
               'visitas' => $visitaRepository->findAll(),
           ]);
           
       }
   
       //-----------------------------------CREAR VISITAS--------------------------------
   
   
       #[Route('/visitas/{id}', name: 'crear_visitas' , methods:["POST"])]
      #[Route('/visitas/crear/{id}', name: 'crear_visitas_formulario' , methods:["POST" , "GET"])]
       public function crear_visitas(int $id,EntityManagerInterface $Manager ,RestauranteRepository $r,Request $request): Response
       {
        $visita = new Visita();
        
        $res = $r->find($id);
        if ($res) {
            $visita -> setRestaurante($res);

            $form = $this->createFormBuilder($visita)
    
            ->add("Valoracion" , IntegerType::class,[
                "required" => true,
            ])
            ->add("Comentario" , TextType::class ,[
                "required" => false,
                "constraints"=>[
                    new Length(["min" => 10])
                ]
            ])
           
    
            ->setMethod("POST")
            ->add("CrearVisita" , SubmitType::class)
            ->getForm() ;
    
            $form->handleRequest($request);
    
            if($form->isSubmitted() && $form->isValid()){
    
                //utilizo los datos recibidos
    
                $visita = $form->getData();
    
                $Manager->persist($visita);
                $Manager->flush();
                
                return $this->redirectToRoute("detalle_restaurante",['id'=>$id] );
    
    
            }else{
                //mostrar el formulario para que el usario lo rellene
    
                 return $this->render('visita/crear_visita.html.twig', [
                            'formulario' => $form,
                        ]);
            }

        }else{
            return $this->json("NO EXISTE RESTAURANTE CON ID ". $id ." PARA CREAR VISITA",404);
        }

      

       
       }
   
   
       //-----------------------------------DETALLE RESTAURANTE--------------------------------
   
           #[Route('/visitas/{id}', name: 'detalle_visita' , methods:[ "GET"])]
           public function detalle_visitas(int $id,VisitaRepository $visitaRepository): Response
           {
            /*
            $visita = $visitaRepository->find($id);
            if ($visita) {
                return $this->json($visita);
            }
            else{
                return $this->json("no exitse visita con ID ". $id );
            }
              
               //*/
               return $this->render('visita/detalle_visita.html.twig', [
                'visita' => $visitaRepository->find($id),
                
                
            ]);
           }
   
       //-----------------------------------ELIMINAR RESTAURANTE--------------------------------
   
       #[Route('/visitas/{id}', name: 'eleminar_visitas' , methods:[ "DELETE"])]
      #[Route('/visitas/{id}/delete', name: 'eleminar_visita_get',methods:["GET"])]
   
           public function eleminar_visitas(int $id,VisitaRepository $visitaRepository,EntityManagerInterface $Manager): Response
           {    
            $visita = $visitaRepository->find($id);
            if ($visita) {
                $idrestaurante = $visita->getRestaurante()->getId();
                $Manager -> remove($visita);
                $Manager->flush();

                 return $this->redirectToRoute("detalle_restaurante",['id'=>$idrestaurante] );
            }
            else{
                throw $this->createNotFoundException("No existe receta con el id".$id);
            }



                /*
               return $this->render('restaurante/index.html.twig', [
                   'controller_name' => 'RestauranteController',
               ]);
               //*/
           }
   
   
       //-----------------------------------ACTUALIZAR RESTAURANTE--------------------------------
   
   
       #[Route('/visitas/{id}', name: 'actualizar_visitas',methods:["PATCH"])]
       #[Route('/visita/{id}/modificar', name: 'actualizar_visita_get', methods:["GET", "POST"])]
           public function actualizar_visitas(int $id,VisitaRepository $visitaRepository,EntityManagerInterface $manager,Request $request): Response
           {
            $visita = $visitaRepository->find($id);
            /*

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

//*/
                
                if ($visita) {
                    $form = $this->createFormBuilder($visita)

                    ->add("Valoracion" , IntegerType::class,[
                        "required" => true,
                        "constraints"=>[
                            new Length(["max" => 2])
                        ]
                    ])
                    ->add("Comentario" , TextType::class ,[
                        "required" => false,
                        "constraints"=>[
                            new Length(["min" => 10])
                        ]
                    ])
                   
            
                    ->setMethod("POST")
                    ->add("ModificarVisita" , SubmitType::class)
                    ->getForm() ;
            
                    $form->handleRequest($request);
            
                    if($form->isSubmitted() && $form->isValid()){
            
                        //utilizo los datos recibidos
            
                        $visita = $form->getData();
            
                        $manager->persist($visita);
                        $manager->flush();
                        
                        return $this->redirectToRoute("detalle_restaurante",['id'=>$visita->getRestaurante()->getId()] );
            
            
                    }else{
                        //mostrar el formulario para que el usario lo rellene
            
                         return $this->render('visita/crear_visita.html.twig', [
                                    'formulario' => $form,
                                ]);
                    }
                }
                else{
                    return $this->json("NO EXISTE ID ". $id ,404);
    
                }
              
               
           }
}
