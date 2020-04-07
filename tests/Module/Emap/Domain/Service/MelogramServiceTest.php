<?php

namespace App\Tests\Module\Emap\Domain\Service;

use App\Module\Emap\Domain\Exception\DuplicateMelogramNameException;
use App\Module\Emap\Domain\Exception\EmptyMelogramFileException;
use App\Module\Emap\Domain\Exception\EmptyMelogramNameException;
use App\Module\Emap\Domain\Exception\MelogramNotExistsException;
use App\Module\Emap\Domain\Model\Melogram;
use App\Module\Emap\Domain\Model\MelogramRepositoryInterface;
use App\Module\Emap\Domain\Service\MelogramService;
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

    private function getMelogramWithoutName() : Melogram
    {
        $fPath = __DIR__."\melo1.mid";
        return new Melogram(1, "", 1,
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

        $actual = $repository->getMelogram($melogram->getId());
        $this->assertEquals($melogram, $actual);
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

        $actual = $repository->getMelogram($melogram->getId());
        $this->assertEquals($updated, $actual);
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

    public function testCanNotUpdateNonExistedMelogram()
    {
        $this->expectException(MelogramNotExistsException::class);
        $melogram = $this->getMelogram();
        $repository = $this->createMock(MelogramRepositoryInterface::class);
        $service = new MelogramService($repository);
        $service->updateMelogram($melogram);
    }

    public function testCanNotAddDuplicatedMelogram() {
        $this->expectException(DuplicateMelogramNameException::class);
        $melogram = $this->getMelogram();
        $duplicated = $this->getMelogram();

        $repository = $this->createMock(MelogramRepositoryInterface::class);
        $service = new MelogramService($repository);

        $service->addMelogram($melogram);
        $repository->expects($this->once())
            ->method('hasMelogram')
            ->willReturn(true);
        $service->addMelogram($duplicated);
    }

    public function testCanNotAddMelogramWithoutName()
    {
        $this->expectException(EmptyMelogramNameException::class);
        $repository = $this->createMock(MelogramRepositoryInterface::class);
        $service = new MelogramService($repository);

        $melogram = $this->getMelogramWithoutName();
        $service->addMelogram($melogram);
    }

    public function testCanNotAddMelogramWithoutFile()
    {
        $this->expectException(EmptyMelogramFileException::class);
        $repository = $this->createMock(MelogramRepositoryInterface::class);
        $service = new MelogramService($repository);

        $melogram = $this->getMelogram();
        $melogram->setFile("");
        $service->addMelogram($melogram);
    }
}
