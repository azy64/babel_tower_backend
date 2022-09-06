<?php

namespace App\Test\Controller;

use App\Entity\Lesson;
use App\Repository\LessonRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LessonControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private LessonRepository $repository;
    private string $path = '/lesson/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = (static::getContainer()->get('doctrine'))->getRepository(Lesson::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Lesson index');

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
            'lesson[title]' => 'Testing',
            'lesson[consigneOne]' => 'Testing',
            'lesson[consigneTwo]' => 'Testing',
            'lesson[dateLesson]' => 'Testing',
            'lesson[teacher]' => 'Testing',
            'lesson[classRoom]' => 'Testing',
            'lesson[contenus]' => 'Testing',
        ]);

        self::assertResponseRedirects('/lesson/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Lesson();
        $fixture->setTitle('My Title');
        $fixture->setConsigneOne('My Title');
        $fixture->setConsigneTwo('My Title');
        $fixture->setDateLesson('My Title');
        $fixture->setTeacher('My Title');
        $fixture->setClassRoom('My Title');
        $fixture->setContenus('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Lesson');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Lesson();
        $fixture->setTitle('My Title');
        $fixture->setConsigneOne('My Title');
        $fixture->setConsigneTwo('My Title');
        $fixture->setDateLesson('My Title');
        $fixture->setTeacher('My Title');
        $fixture->setClassRoom('My Title');
        $fixture->setContenus('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'lesson[title]' => 'Something New',
            'lesson[consigneOne]' => 'Something New',
            'lesson[consigneTwo]' => 'Something New',
            'lesson[dateLesson]' => 'Something New',
            'lesson[teacher]' => 'Something New',
            'lesson[classRoom]' => 'Something New',
            'lesson[contenus]' => 'Something New',
        ]);

        self::assertResponseRedirects('/lesson/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getTitle());
        self::assertSame('Something New', $fixture[0]->getConsigneOne());
        self::assertSame('Something New', $fixture[0]->getConsigneTwo());
        self::assertSame('Something New', $fixture[0]->getDateLesson());
        self::assertSame('Something New', $fixture[0]->getTeacher());
        self::assertSame('Something New', $fixture[0]->getClassRoom());
        self::assertSame('Something New', $fixture[0]->getContenus());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Lesson();
        $fixture->setTitle('My Title');
        $fixture->setConsigneOne('My Title');
        $fixture->setConsigneTwo('My Title');
        $fixture->setDateLesson('My Title');
        $fixture->setTeacher('My Title');
        $fixture->setClassRoom('My Title');
        $fixture->setContenus('My Title');

        $this->repository->add($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/lesson/');
    }
}
