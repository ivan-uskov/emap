<?php

namespace App\Tests\Module\Emap\Domain\Service;

use App\Module\Emap\Api\Output\MelogramOutput;
use App\Module\Emap\Domain\Model\Melogram;
use App\Module\Emap\Domain\Model\MelogramRepositoryInterface;
use App\Module\Emap\Domain\Service\MelogramService;
use App\Module\Emap\Infrastructure\Persistence\Doctrine\MelogramQueryService;
use App\Module\Emap\Infrastructure\Persistence\Doctrine\MelogramRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Persistence\ObjectRepository;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class MelogramServiceTest extends KernelTestCase
{
    private function getMelogram(): Melogram
    {
        $fPath = __DIR__."\melo1.mid";
        return new Melogram(null, 1, 1,
            1,1, 1,1, file_get_contents($fPath));
    }


    public function testAddMelogram()
    {
        $melogram = $this->getMelogram();
        $repository = $this->createMock(MelogramRepositoryInterface::class);
        $repository->expects($this->any())
            ->method('getMelogram')
            ->willReturn($melogram);
        $service = new MelogramService($repository);
        $service->addMelogram($melogram);

        $actual = $repository->getMelogram(1);
        $this->assertEquals($melogram->getItemId(), $actual->getItemId());
        $this->assertEquals($melogram->getFamilyId(), $actual->getFamilyId());
        $this->assertEquals($melogram->getColonyId(), $actual->getColonyId());
        $this->assertEquals($melogram->getPopulationId(), $actual->getPopulationId());
        $this->assertEquals($melogram->getSpecieId(), $actual->getSpecieId());
        $this->assertEquals($melogram->getFile(), $actual->getFile());
    }

    public function testUpdateMelogram()
    {

    }

    public function testRemoveMelogram()
    {

    }
}
