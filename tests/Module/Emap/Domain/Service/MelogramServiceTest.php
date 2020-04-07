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

    private MelogramService $service;
    private $repository;
    private $fPath;
    protected function setUp(): void
    {
        $this->repository = $this->createMock(MelogramRepositoryInterface::class);
        $this->service = new MelogramService($this->repository);
        $this->fPath = __DIR__."\melo1.mid";
    }

    private function getMelogram() : Melogram
    {
        return new Melogram(1, 1, 1,
            1,1, 1,1, file_get_contents($this->fPath));
    }

    private function getUpdatedMelogram() : Melogram
    {
        return new Melogram(1, 2, 1,
            1,1, 1,1, file_get_contents($this->fPath));
    }

    private function getMelogramWithoutName() : Melogram
    {
        return new Melogram(1, "", 1,
            1,1, 1,1, file_get_contents($this->fPath));
    }

    public function testAddMelogram()
    {
        $melogram = $this->getMelogram();
        $this->repository->expects($this->once())
            ->method('getMelogram')
            ->willReturn($melogram);

        $this->service->addMelogram($melogram);

        $actual = $this->repository->getMelogram($melogram->getId());
        $this->assertEquals($melogram, $actual);
    }

    public function testUpdateMelogram()
    {
        $melogram = $this->getMelogram();
        $updated = $this->getUpdatedMelogram();

        $this->repository->expects($this->any())
            ->method('getMelogram')
            ->willReturn($updated);

        $this->service->addMelogram($melogram);
        $this->repository->expects($this->once())
            ->method('hasFamily')
            ->willReturn(true);

        $this->service->updateMelogram($updated);

        $actual = $this->repository->getMelogram($melogram->getId());
        $this->assertEquals($updated, $actual);
    }

    public function testRemoveMelogram()
    {
        $melogram = $this->getMelogram();
        $this->service->addMelogram($melogram);
        $this->service->removeMelogram($melogram->getId());
        $this->repository->expects($this->once())
            ->method('getMelogram')
            ->willReturn(null);
        $actual = $this->repository->getMelogram($melogram->getId());

        $this->assertNull($actual);
    }

    public function testCanNotUpdateNonExistedMelogram()
    {
        $this->expectException(MelogramNotExistsException::class);
        $melogram = $this->getMelogram();
        $this->service->updateMelogram($melogram);
    }

    public function testCanNotAddDuplicatedMelogram() {
        $this->expectException(DuplicateMelogramNameException::class);
        $melogram = $this->getMelogram();
        $duplicated = $this->getMelogram();

        $this->service->addMelogram($melogram);
        $this->repository->expects($this->once())
            ->method('hasMelogram')
            ->willReturn(true);
        $this->service->addMelogram($duplicated);
    }

    public function testCanNotAddMelogramWithoutName()
    {
        $this->expectException(EmptyMelogramNameException::class);
        $melogram = $this->getMelogramWithoutName();
        $this->service->addMelogram($melogram);
    }

    public function testCanNotAddMelogramWithoutFile()
    {
        $this->expectException(EmptyMelogramFileException::class);
        $melogram = $this->getMelogram();
        $melogram->setFile("");
        $this->service->addMelogram($melogram);
    }
}
