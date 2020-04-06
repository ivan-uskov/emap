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
    private function getMelogram() : Melogram
    {
        $fPath = __DIR__."\melo1.mid";
        return new Melogram(1, 1, 1,
            1,1, 1,1, file_get_contents($fPath));
    }

    private function getUpdatedMelogram() : Melogram
    {
        $fPath = __DIR__."\melo1.mid";
        return new Melogram(1, 2, 1,
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
        $melogram = $this->getMelogram();
        $repository = $this->createMock(MelogramRepositoryInterface::class);

        $updated = $this->getUpdatedMelogram();

        $repository->expects($this->any())
            ->method('getMelogram')
            ->willReturn($updated);

        $service = new MelogramService($repository);
        $service->addMelogram($melogram);
        $repository->expects($this->any())
            ->method('hasFamily')
            ->willReturn(true);

        $service->updateMelogram($updated);

        $actual = $repository->getMelogram(1);
        $this->assertEquals($updated->getItemId(), $actual->getItemId());
        $this->assertEquals($updated->getFamilyId(), $actual->getFamilyId());
        $this->assertEquals($updated->getColonyId(), $actual->getColonyId());
        $this->assertEquals($updated->getPopulationId(), $actual->getPopulationId());
        $this->assertEquals($updated->getSpecieId(), $actual->getSpecieId());
        $this->assertEquals($updated->getFile(), $actual->getFile());

    }

    public function testRemoveMelogram()
    {
        $melogram = $this->getMelogram();
        $repository = $this->createMock(MelogramRepositoryInterface::class);

        $service = new MelogramService($repository);
        $service->addMelogram($melogram);
        $service->removeMelogram($melogram->getId());
        $repository->expects($this->once())
            ->method('getMelogram')
            ->willReturn(null);
        $actual = $repository->getMelogram($melogram->getId());

        $this->assertNull($actual);
    }
}
