<?php

namespace App\Controller;

use App\Entity\Socio;
use App\Repository\EmpresaRepository;
use App\Repository\SocioRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class SocioController extends AbstractController
{
    #[Route('/socio', name: 'socio', methods: ['GET'])]
    public function index(SocioRepository $socioRepository): JsonResponse
    {
        $socios = $socioRepository->findAll();
        return $this->json($socios);
    }

    #[Route('/socio', name: 'socio_create', methods: ['POST'])]
    public function create(Request $request, SocioRepository $socioRepository, EmpresaRepository $empresaRepository): JsonResponse
    {
        $data = $request->toArray();
        $empresa = $empresaRepository->find($data['empresa_id']);
        if (is_null($empresa))
            return $this->json([
                'error_message' => "Empresa não encontrada"
            ], 400);
        $socio = new Socio();
        $socio->setNome($data['nome']);
        $socio->setCpf($data['cpf']);
        $socio->setEmpresaId($empresa);
        $socioRepository->save($socio);
        return $this->json($socio);
    }

    #[Route('/socio/{id}', name: 'socio_show', methods: ['GET'])]
    public function show(Socio $socio): JsonResponse
    {
        return $this->json($socio);
    }

    #[Route('/socio/{id}', name: 'socio_update', methods: ['PUT'])]
    public function update(Request $request, Socio $socio, SocioRepository $socioRepository, EmpresaRepository $empresaRepository)
    {
        $data = $request->toArray();
        $empresa = $empresaRepository->find($data['empresa_id']);
        if (is_null($empresa))
            return $this->json([
                'error_message' => "Empresa não encontrada"
            ], 400);
        $socio->setNome($data['nome']);
        $socio->setCpf($data['cpf']);
        $socio->setEmpresaId($empresa);
        $socioRepository->update();
        return $this->json($socio);
    }

    #[Route('/socio/{id}', name: 'socio_delete', methods: ['DELETE'])]
    public function remove(Socio $socio, SocioRepository $socioRepository)
    {
        $socioRepository->remove($socio);
        return $this->json($socio);
    }
}
