<?php

namespace App\Controller;

use App\Entity\Country;
use App\Service\CountryService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

class CountryController extends AbstractController
{
    #[Route('/update-countries', name: 'update_countries')]
    public function updateCountries(CountryService $countryService, EntityManagerInterface $em): Response
    {
        // Paso 1: Llamar al servicio para obtener los datos de los países
        $countriesData = $countryService->fetchCountries();

        // Paso 2: Recorrer los datos de cada país y guardarlos/actualizarlos en la base de datos
        foreach ($countriesData as $countryData) {
            // Intentar buscar el país en la base de datos por su código ISO
            $country = $em->getRepository(Country::class)->findOneBy(['codigo_iso' => $countryData['cca3']]);

            // Si no existe, se crea un nuevo país
            if (!$country) {
                $country = new Country();
                $country->setCodigoIso($countryData['cca3']);
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
        return new Response('Los países han sido actualizados y guardados en la base de datos.');
    }
    #[Route('/countries', name: 'countries_list')]
    public function showCountries(EntityManagerInterface $em): Response
    {
        // Obtener todos los países desde la base de datos
        $countries = $em->getRepository(Country::class)->findAll();

        // Renderizar una vista y pasarle los países
        return $this->render('country/index.html.twig', [
            'countries' => $countries,
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
        return $this->redirectToRoute('countries');
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