<?php

namespace Tests\Unit;

use App\Services\AddressService;
use App\Services\AppliqueService;
use App\Services\CategorieService;
use App\Services\ClassifieService;
use App\Services\CommandeService;
use App\Services\ComposeService;
use App\Services\ConcerneService;
use App\Services\ContientService;
use App\Services\EffectueService;
use App\Services\EtageService;
use App\Services\FactureService;
use App\Services\FileService;
use App\Services\InclutService;
use App\Services\LigneService;
use App\Services\LocaliseService;
use App\Services\PavCustomService;
use App\Services\PavService;
use App\Services\PavStandardService;
use App\Services\ProduitService;
use App\Services\ReductionGlobaleService;
use App\Services\ReductionPersonnelService;
use App\Services\ReductionService;
use Tests\TestCase;

class DomainServiceResolutionTest extends TestCase
{
    /**
     * Test domain services resolve from the container.
     *
     * @return void
     */
    public function test_domain_services_resolve_from_container(): void
    {
        $services = [
            AddressService::class,
            AppliqueService::class,
            CategorieService::class,
            ClassifieService::class,
            CommandeService::class,
            ComposeService::class,
            ConcerneService::class,
            ContientService::class,
            EffectueService::class,
            EtageService::class,
            FactureService::class,
            FileService::class,
            InclutService::class,
            LigneService::class,
            LocaliseService::class,
            PavCustomService::class,
            PavService::class,
            PavStandardService::class,
            ProduitService::class,
            ReductionGlobaleService::class,
            ReductionPersonnelService::class,
            ReductionService::class,
        ];

        foreach ($services as $service) {
            $this->assertInstanceOf($service, app($service));
        }
    }
}
