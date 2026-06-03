<?php

namespace Tests\Unit;

use App\Repositories\Eloquents\AddressEloquent;
use App\Repositories\Eloquents\AppliqueEloquent;
use App\Repositories\Eloquents\AuditLogEloquent;
use App\Repositories\Eloquents\AuthEloquent;
use App\Repositories\Eloquents\CategorieEloquent;
use App\Repositories\Eloquents\ClassifieEloquent;
use App\Repositories\Eloquents\CommandeEloquent;
use App\Repositories\Eloquents\ComposeEloquent;
use App\Repositories\Eloquents\ConcerneEloquent;
use App\Repositories\Eloquents\ContientEloquent;
use App\Repositories\Eloquents\EffectueEloquent;
use App\Repositories\Eloquents\EtageEloquent;
use App\Repositories\Eloquents\FactureEloquent;
use App\Repositories\Eloquents\FileEloquent;
use App\Repositories\Eloquents\InclutEloquent;
use App\Repositories\Eloquents\LigneEloquent;
use App\Repositories\Eloquents\LocaliseEloquent;
use App\Repositories\Eloquents\PavCustomEloquent;
use App\Repositories\Eloquents\PavEloquent;
use App\Repositories\Eloquents\PavStandardEloquent;
use App\Repositories\Eloquents\ProduitEloquent;
use App\Repositories\Eloquents\ReductionEloquent;
use App\Repositories\Eloquents\ReductionGlobaleEloquent;
use App\Repositories\Eloquents\ReductionPersonnelEloquent;
use App\Repositories\Eloquents\RoleEloquent;
use App\Repositories\Eloquents\StoreEloquent;
use App\Repositories\Eloquents\UserEloquent;
use App\Repositories\Interfaces\AuthRepositoryInterface;
use App\Repositories\Interfaces\RoleInterface;
use App\Repositories\Interfaces\StoreInterface;
use App\Repositories\Interfaces\UserInterface;
use Tests\TestCase;

class RepositoryBindingTest extends TestCase
{
    /**
     * Test application repository interfaces.
     */
    public function test_application_repository_interfaces_are_bound(): void
    {
        $bindings = [
            AuthRepositoryInterface::class => AuthEloquent::class,
            RoleInterface::class => RoleEloquent::class,
            StoreInterface::class => StoreEloquent::class,
            UserInterface::class => UserEloquent::class,
        ];

        foreach ($bindings as $interface => $implementation) {
            $this->assertInstanceOf($implementation, app($interface));
        }
    }

    /**
     * Test simple repositories can be resolved as concrete classes.
     */
    public function test_simple_domain_repositories_are_auto_resolved(): void
    {
        $repositories = [
            AddressEloquent::class,
            AppliqueEloquent::class,
            AuditLogEloquent::class,
            CategorieEloquent::class,
            ClassifieEloquent::class,
            CommandeEloquent::class,
            ComposeEloquent::class,
            ConcerneEloquent::class,
            ContientEloquent::class,
            EffectueEloquent::class,
            EtageEloquent::class,
            FactureEloquent::class,
            FileEloquent::class,
            InclutEloquent::class,
            LigneEloquent::class,
            LocaliseEloquent::class,
            PavCustomEloquent::class,
            PavEloquent::class,
            PavStandardEloquent::class,
            ProduitEloquent::class,
            ReductionEloquent::class,
            ReductionGlobaleEloquent::class,
            ReductionPersonnelEloquent::class,
        ];

        foreach ($repositories as $repository) {
            $this->assertInstanceOf($repository, app($repository));
        }
    }
}
