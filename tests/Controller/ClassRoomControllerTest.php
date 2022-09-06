<?php

namespace App\Test\Controller;

use App\Entity\ClassRoom;
use App\Repository\ClassRoomRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ClassRoomControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private ClassRoomRepository $repository;
    private string $path = '/class/room/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = (static::getContainer()->get('doctrine'))->getRepository(ClassRoom::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('ClassRoom index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $originalNumObjectsInRepository = count($this->repository->findAll());

        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'class_room[nom]' => 'Testing',
            'class_room[creationClass]' => 'Testing',
            'class_room[teacher]' => 'Testing',
        ]);

        self::assertResponseRedirects('/class/room/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new ClassRoom();
        $fixture->setNom('My Title');
        $fixture->setCreationClass('My Title');
        $fixture->setTeacher('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('ClassRoom');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new ClassRoom();
        $fixture->setNom('My Title');
        $fixture->setCreationClass('My Title');
        $fixture->setTeacher('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'class_room[nom]' => 'Something New',
            'class_room[creationClass]' => 'Something New',
            'class_room[teacher]' => 'Something New',
        ]);

        self::assertResponseRedirects('/class/room/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getNom());
        self::assertSame('Something New', $fixture[0]->getCreationClass());
        self::assertSame('Something New', $fixture[0]->getTeacher());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new ClassRoom();
        $fixture->setNom('My Title');
        $fixture->setCreationClass('My Title');
        $fixture->setTeacher('My Title');

        $this->repository->add($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/class/room/');
    }
}
