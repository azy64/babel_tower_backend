<?php

namespace App\Test\Controller;

use App\Entity\Teacher;
use App\Repository\TeacherRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TeacherControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private TeacherRepository $repository;
    private string $path = '/teacher/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = (static::getContainer()->get('doctrine'))->getRepository(Teacher::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Teacher index');

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
            'teacher[nom]' => 'Testing',
            'teacher[prenom]' => 'Testing',
            'teacher[langue]' => 'Testing',
            'teacher[email]' => 'Testing',
            'teacher[password]' => 'Testing',
        ]);

        self::assertResponseRedirects('/teacher/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Teacher();
        $fixture->setNom('My Title');
        $fixture->setPrenom('My Title');
        $fixture->setLangue('My Title');
        $fixture->setEmail('My Title');
        $fixture->setPassword('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Teacher');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Teacher();
        $fixture->setNom('My Title');
        $fixture->setPrenom('My Title');
        $fixture->setLangue('My Title');
        $fixture->setEmail('My Title');
        $fixture->setPassword('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'teacher[nom]' => 'Something New',
            'teacher[prenom]' => 'Something New',
            'teacher[langue]' => 'Something New',
            'teacher[email]' => 'Something New',
            'teacher[password]' => 'Something New',
        ]);

        self::assertResponseRedirects('/teacher/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getNom());
        self::assertSame('Something New', $fixture[0]->getPrenom());
        self::assertSame('Something New', $fixture[0]->getLangue());
        self::assertSame('Something New', $fixture[0]->getEmail());
        self::assertSame('Something New', $fixture[0]->getPassword());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Teacher();
        $fixture->setNom('My Title');
        $fixture->setPrenom('My Title');
        $fixture->setLangue('My Title');
        $fixture->setEmail('My Title');
        $fixture->setPassword('My Title');

        $this->repository->add($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/teacher/');
    }
}
