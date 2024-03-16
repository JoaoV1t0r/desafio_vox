<?php

namespace App\Controller;

use App\Entity\Empresa;
use App\Repository\EmpresaRepository;
use App\Repository\SocioRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class EmpresaController extends AbstractController
{
    #[Route('/empresa', name: 'empresa', methods: ['GET'])]
    public function index(EmpresaRepository $empresaRepository): JsonResponse
    {
        $empresas = $empresaRepository->findAll();
        return $this->json($empresas);
    }

    #[Route('/empresa', name: 'empresa_create', methods: ['POST'])]
    public function create(Request $request, EmpresaRepository $empresaRepository): JsonResponse
    {
        $data = $request->toArray();
        $empresa = new Empresa();
        $empresa->setNome($data['nome']);
        $empresa->setCnpj($data['cnpj']);
        $empresaRepository->save($empresa);
        return $this->json($empresa);
    }

    #[Route('/empresa/{id}', name: 'empresa_show', methods: ['GET'])]
    public function show(Empresa $empresa): JsonResponse
    {
        return $this->json($empresa);
    }

    #[Route('/empresa/{id}', name: 'empresa_update', methods: ['PUT'])]
    public function update(Request $request, Empresa $empresa, EmpresaRepository $empresaRepository)
    {
        $data = $request->toArray();
        $empresa->setNome($data['nome']);
        $empresa->setCnpj($data['cnpj']);
        $empresaRepository->update();
        return $this->json($empresa);
    }

    #[Route('/empresa/{id}', name: 'empresa_delete', methods: ['DELETE'])]
    public function remove(Empresa $empresa, EmpresaRepository $empresaRepository, SocioRepository $socioRepository)
    {
        $socios = $socioRepository->findByEmpresaId($empresa->getId());
        foreach ($socios as $socio) {
            $socioRepository->remove($socio);
        }
        $empresaRepository->remove($empresa);
        return $this->json($empresa);
    }
}
