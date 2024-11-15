<?php

namespace App\Entity;

use App\Repository\CountryRepository;
use Doctrine\ORM\Mapping as ORM;
/*
#[ORM\Entity(repositoryClass: CountryRepository::class)]
class Country
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    
    #[ORM\Column(type: "string", length: 100)]
    private string $nombre = '';

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): self
    {
    $this->nombre = $nombre;
    return $this;
    }
}*/

#[ORM\Entity(repositoryClass: CountryRepository::class)]
class Country
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private ?int $id = null; // Clave primaria

    // Otros atributos como nombre, población, etc.

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    #[ORM\Column(type: 'string', length: 100, nullable: true)]
    private ?string $nombre_comun = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $nombre_oficial = null;

    #[ORM\Column(type: 'string', length: 3, nullable: true)]
    private ?string $codigo_iso = null;

    #[ORM\Column(type: 'string', length: 100, nullable: true)]
    private ?string $region = null;

    #[ORM\Column(type: 'string', length: 100, nullable: true)]
    private ?string $subregion = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $capital = null;

    #[ORM\Column(type: 'integer')]
    private ?string $poblacion = null;

    #[ORM\Column(type: 'float')]
    private ?string $area = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $bandera = null;

    #[ORM\Column(type: 'text')]
    private ?string $idiomas = null;

    #[ORM\Column(type: 'text')]
    private ?string $monedas = null;

    #[ORM\Column(type: 'text')]
    private ?string $fronteras = null;

    #[ORM\Column(type: 'float')]
    private ?string $lat = null;

    #[ORM\Column(type: 'float')]
    private ?string $lng = null;

    public function getNombreComun(): ?string
    {
        return $this->nombre_comun;
    }

    public function setNombreComun(?string $nombre_comun): self
    {
        $this->nombre_comun = $nombre_comun;
        return $this;
    }
    public function getNombreOficial(): ?string
    {
        return $this->nombre_comun;
    }

    public function setNombreOficial(string $nombre_oficial): self
    {
        $this->nombre_oficial = $nombre_oficial;
        return $this;
    }
    public function getCodigoIso(): ?string
    {
        return $this->codigo_iso;
    }

    public function setCodigoIso(string $codigo_iso): self
    {
        $this->codigo_iso = $codigo_iso;
        return $this;
    }
    public function getRegion(): ?string
    {
        return $this->region;
    }

    public function setRegion(string $region): self
    {
        $this->region = $region;
        return $this;
    }
    public function getSubregion(): ?string
    {
        return $this->subregion;
    }

    public function setSubregion(string $subregion): self
    {
        $this->subregion = $subregion;
        return $this;
    }
    public function getCapital(): ?string
    {
        return $this->capital;
    }
    public function setCapital(?string $capital): self
    {
        $this->capital = $capital;
        return $this;
    }
    public function getPoblacion(): ?int
    {
        return $this->poblacion;
    }
    public function setPoblacion(int $poblacion): self
    {
        $this->poblacion = $poblacion;
        return $this;
    }

    public function getArea(): ?string
    {
        return $this->area;
    }
    public function setArea(string $area): self
    {
        $this->area = $area;
        return $this;
    }


    public function getBandera(): ?string
    {
        return $this->bandera;
    }

    public function setBandera(string $bandera): self
    {
        $this->bandera = $bandera;
        return $this;
    }



    public function getIdiomas(): ?string
    {
        return $this->bandera;
    }

    public function setIdiomas(string $idiomas): self
    {
        $this->idiomas = $idiomas;
        return $this;
    }


    public function getMonedas(): ?string
    {
        return $this->monedas;
    }

    public function setMonedas(string $monedas): self
    {
        $this->monedas = $monedas;
        return $this;
    }

    public function getFronteras(): ?string
    {
        return $this->fronteras;
    }

    public function setFronteras(string $fronteras): self
    {
        $this->fronteras = $fronteras;
        return $this;
    }
    public function getLat(): ?float
    {
        return $this->lat;
    }

    public function setLat(float $lat): self
    {
        $this->lat = $lat;
        return $this;
    }
    public function getlng(): ?float
    {
        return $this->lng;
    }

    public function setlng(float $lng): self
    {
        $this->lng = $lng;
        return $this;
    }


    




}
