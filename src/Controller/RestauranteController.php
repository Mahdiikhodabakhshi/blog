<?php

namespace App\Controller;

use App\Entity\Restaurante;
use App\Repository\VisitaRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\RestauranteRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

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
   #[Route('/restaurante/crear', name: 'crear_restaurante_formulario' , methods:["POST" , "GET"])]
    public function crear_restaurante(EntityManagerInterface $manager , Request $request): Response
    {

        $restaurante = new Restaurante;

        $form = $this->createFormBuilder($restaurante)

        ->add("nombre" , TextType::class,[
            "required" => true,
        ])
        ->add("Direccion" , TextType::class ,[
            "required" => true,
            "constraints"=>[
                new Length(["min" => 5])
            ]
        ])
        ->add("Telefono" , TextType::class,[
            "required" => false,
        ])
        ->add("tipoCocina" , TextType::class , [
            "required" => false,






        ])

        ->setMethod("POST")
        ->add("Crear" , SubmitType::class)
        ->getForm() ;

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            //utilizo los datos recibidos

            $restaurante = $form->getData();

            $manager->persist($restaurante);
            $manager->flush();
            
            return $this->redirectToRoute("listado_restaurante");


        }else{
            //mostrar el formulario para que el usario lo rellene

             return $this->render('restaurante/crear_restaurante.html.twig', [
                        'formulario' => $form,
                    ]);
        }
        






        /*
        $restaurante -> setNombre("md");
        $restaurante -> setDireccion("plaza ajuntamiento");
        $restaurante -> setTelefono("999*487");
        $restaurante -> setTipoCocina("comidaRapida");
        $manager -> persist($restaurante);
        $manager->flush();
       
        return $this->json("restaurante ha creado con ID " .$restaurante->getId());
 


        
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
        public function eleminar_restaurante(int $id,RestauranteRepository $restauranteRepository , EntityManagerInterface $manager): Response
        {
            $restaurante = $restauranteRepository->find($id);

            if ($restaurante) {
                $manager -> remove($restaurante);
                $manager->flush();

                 return $this->redirectToRoute("listado_restaurante");
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
