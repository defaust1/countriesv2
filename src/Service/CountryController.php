<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class CountryService
{
    private HttpClientInterface $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function fetchCountries(): array
    {
        $response = $this->client->request(
            'GET',
            'https://restcountries.com/v3.1/all',
            [
                'timeout' => 150, // Aumenta el tiempo de espera a 15 segundos (puedes ajustarlo según lo necesites)
            ]
        );
        dump($response->toArray()); // Esto imprimirá el contenido en la consola o en el navegador
        return $response->toArray();
    }
}


/* namespace App\Controller;

use App\Entity\Country;
use App\Repository\CountryRepository;
use App\Service\RestCountriesService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CountryController extends AbstractController
{
    private $restCountriesService;
    private $entityManager;

    public function __construct(RestCountriesService $restCountriesService, EntityManagerInterface $entityManager)
    {
        $this->restCountriesService = $restCountriesService;
        $this->entityManager = $entityManager;
    }

    #[Route('/country/update', name: 'country_update')]
    public function updateCountries(CountryRepository $countryRepository): Response
    {
        $countriesData = $this->restCountriesService->fetchCountries();

        foreach ($countriesData as $data) {
            $country = $countryRepository->findOneBy(['alpha2Code' => $data['cca2']]);

            if (!$country) {
                $country = new Country();
            }

            $country->setName($data['name']['common']);
            $country->setAlpha2Code($data['cca2']);
            $country->setAlpha3Code($data['cca3']);
            $country->setRegion($data['region'] ?? null);
            $country->setSubregion($data['subregion'] ?? null);
            $country->setPopulation($data['population'] ?? 0);

            $this->entityManager->persist($country);
        }

        $this->entityManager->flush();

        return $this->redirectToRoute('country_index');
    }
}*/