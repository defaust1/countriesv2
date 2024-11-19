<?php

namespace App\Controller;

use App\Entity\Country;
use App\Repository\CountryRepository;
use App\Service\CountryService;
use App\Form\CountryType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Knp\Component\Pager\PaginatorInterface;



class CountryController extends AbstractController
{
    #[Route('/update-countries', name: 'update_countries')]
    public function updateCountries(CountryService $countryService, 
    EntityManagerInterface $em): Response
    {
        // Paso 1: Llamar al servicio para obtener los datos de los países
        $countriesData = $countryService->fetchCountries();
        // Paso 1b: añadimos variables para contar el numero de añadidos nuevos
        $repository = $em->getRepository(Country::class);
        $addedCount = 0; //fin de actualizacion añadidos (ELIMINAR)

        // Paso 2: Recorrer los datos de cada país y guardarlos/actualizarlos en la base de datos
        foreach ($countriesData as $countryData) {
            // Intentar buscar el país en la base de datos por su código ISO
            $country = $em->getRepository(Country::class)->findOneBy(['codigo_iso' => $countryData['cca3']]);
            // Si no existe, se crea un nuevo país
            if (!$country) {
                $country = new Country();
                $country->setCodigoIso($countryData['cca3']);
                $addedCount++; //Suma el pais nuevo para mostrarlo
            }

            // Actualizar los datos del país
            $country->setNombreComun($countryData['name']['common'] ?? null);
            $country->setNombreOficial($countryData['name']['official'] ?? 'Desconocido');
            $country->setRegion($countryData['region'] ?? 'Desconocido');
            $country->setSubregion($countryData['subregion'] ?? '');
            $country->setCapital($countryData['capital'][0] ?? null);
            $country->setPoblacion($countryData['population'] ?? 0);
            $country->setArea($countryData['area'] ?? 0.0);
            $country->setBandera($countryData['flags']['png'] ?? '');
            $country->setLat($countryData['latlng'][0] ?? 0.0);
            $country->setLng($countryData['latlng'][1] ?? 0.0);
            

            // Guardar el país en la base de datos
            $em->persist($country);
        }

        // Confirmar los cambios en la base de datos
        $em->flush();

        // Devolver una respuesta indicando que el proceso ha terminado
        return $this->redirectToRoute('countries_list', [
            'addedCount' => $addedCount,
        ]);
    }
    // Mostrar listado paises en Index.html.twig. DESACTUALIZADO 15/11/2024
    /*#[Route('/countries', name: 'countries_list')]
    public function showCountries(EntityManagerInterface $em): Response
    {
        // Obtener todos los países desde la base de datos
        $countries = $em->getRepository(Country::class)->findAll();

        // Renderizar una vista y pasarle los países
        return $this->render('country/index.html.twig', [
            'countries' => $countries,
        ]);
        
    }*/
    //Mostramos con paginacion de 20 y total de paises.
    #[Route('/countries', name: 'countries_list')]
    public function index(EntityManagerInterface $em, PaginatorInterface $paginator, Request $request): Response
    {
        $countryRepository = $em->getRepository(Country::class);
        $countries = $countryRepository->findAll();

        // Consulta para contar los países
         $totalCountries = $countryRepository->createQueryBuilder('c')
        ->select('COUNT(c.id)')
        ->getQuery()
        ->getSingleScalarResult();

        // Recuperar la consulta para todos los países y ordenar por orden alfabetico.
        $query = $countryRepository->createQueryBuilder('c')
        ->orderBy('c.nombre_comun', 'ASC')
        ->getQuery();

        // Usar el paginador para dividir los resultados en páginas
        $pagination = $paginator->paginate(
            $query, // La consulta para los países
            $request->query->getInt('page', 1), // Página actual, por defecto 1
            20 // Número de países por página
        );
        $addedCount = $request->query->get('addedCount', null); // Cuantos nuevos hemos añadido
        return $this->render('country/index.html.twig', [
            'pagination' => $pagination, // Pasar la paginación a la plantilla
            'totalCountries' => $totalCountries, //Pasar total de paises
            'addedCount' => $addedCount, //Paises nuevos a plantilla.
        ]);
    }
    // Método para eliminar un país
    #[Route('/countries/delete/{id}', name: 'country_delete', methods: ['POST'])]
    public function deleteCountry(int $id, EntityManagerInterface $em, Request $request): RedirectResponse
    {
        $country = $em->getRepository(Country::class)->find($id);

        if ($country) {
            $token = $request->request->get('_token');
            if ($this->isCsrfTokenValid('delete' . $id, $token)) {
                $em->remove($country);
                $em->flush();
                $this->addFlash('success', 'El país ha sido eliminado con éxito.');
            } else {
                $this->addFlash('error', 'Token CSRF inválido.');
            }
        } else {
            $this->addFlash('error', 'El país no existe.');
        }
        return $this->redirectToRoute('countries_list');
    }  
    // Metodo para editar Paises
    #[Route('/countries/edit/{id}', name: 'country_edit', methods: ['GET', 'POST'])]
    public function editCountry(int $id, Request $request, EntityManagerInterface $em): Response
    {
        $country = $em->getRepository(Country::class)->find($id);

        if (!$country) {
            $this->addFlash('error', 'El país no existe.');
            return $this->redirectToRoute('countries_list'); // Cambia a la ruta de tu listado de países
        }

        $form = $this->createFormBuilder($country)
            ->add('NombreComun', TextType::class, ['label' => 'Nombre Comun'])
            ->add('NombreOficial', TextType::class, ['label' => 'Nombre Oficial'])
            ->add('CodigoIso', TextType::class, ['label' => ' CodigoIso'])
            ->add('Region', TextType::class, ['label' => ' Region'])
            ->add('Subregion', TextType::class, ['label' => ' Subregion'])
            ->add('Poblacion', TextType::class, ['label' => ' Poblacion'])
            ->add('Area', TextType::class, ['label' => ' Area'])
            ->add('Capital', TextType::class, ['label' => ' Capital'])
            ->add('save', SubmitType::class, ['label' => 'Guardar cambios'])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash('success', 'El país ha sido actualizado con éxito.');
            return $this->redirectToRoute('countries_list'); // Cambia a la ruta de tu listado de países
        }

        return $this->render('country/edit.html.twig', [
            'form' => $form->createView(),
            'country' => $country,
        ]);
    }
    //Para buscar por letras en el buscador de index
    #[Route('/countries/search', name: 'country_search', methods: ['GET'])]
    public function search(Request $request, CountryRepository $countryRepository): JsonResponse
    {
        $searchTerm = $request->query->get('q', '');
        $countries = $countryRepository->findBySearchTerm($searchTerm);

        $results = [];
        foreach ($countries as $country) 
        {
            $results[] = ['id' => $country->getId(), 
            'nombre_comun' => $country->getNombreComun(),
            'nombre_oficial' => $country->getNombreOficial(),
            'codigo_iso' => $country->getCodigoIso(),
            'capital' => $country->getCapital(),
            'region' => $country->getRegion(),
            'subregion' => $country->getSubregion(),
            'poblacion' => $country->getpoblacion(),
            'area' => $country->getArea()];
        }

        return $this->json($results);
    }
    //Para crear nuevos paises en el caso de que nos falte algun pais.
    #[Route('/countries/add', name: 'country_add')]
    public function add(Request $request, EntityManagerInterface $entityManager): Response
    {
        $country = new Country();
        $form = $this->createForm(CountryType::class, $country);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Guardar el nuevo país en la base de datos
            $entityManager->persist($country);
            $entityManager->flush();

            $this->addFlash('success', 'País añadido exitosamente!');
            return $this->redirectToRoute('countries_list');
        }

        return $this->render('country/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}


/*
namespace App\Controller;

use App\Service\CountryService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CountryController extends AbstractController
{
    #[Route('/update-countries', name: 'update_countries')]
    public function updateCountries(CountryService $countryService, EntityManagerInterface $em): Response
    {
        // Lógica para actualizar los países
        return new Response('Los países han sido actualizados.');
    }
} */