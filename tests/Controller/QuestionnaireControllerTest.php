<?php

namespace App\Test\Controller;

use App\Entity\Questionnaire;
use App\Repository\QuestionnaireRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class QuestionnaireControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private QuestionnaireRepository $repository;
    private string $path = '/questionnaire/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = (static::getContainer()->get('doctrine'))->getRepository(Questionnaire::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Questionnaire index');

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
            'questionnaire[titre]' => 'Testing',
            'questionnaire[dateCreation]' => 'Testing',
            'questionnaire[contenu]' => 'Testing',
            'questionnaire[lesson]' => 'Testing',
        ]);

        self::assertResponseRedirects('/questionnaire/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Questionnaire();
        $fixture->setTitre('My Title');
        $fixture->setDateCreation('My Title');
        $fixture->setContenu('My Title');
        $fixture->setLesson('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Questionnaire');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Questionnaire();
        $fixture->setTitre('My Title');
        $fixture->setDateCreation('My Title');
        $fixture->setContenu('My Title');
        $fixture->setLesson('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'questionnaire[titre]' => 'Something New',
            'questionnaire[dateCreation]' => 'Something New',
            'questionnaire[contenu]' => 'Something New',
            'questionnaire[lesson]' => 'Something New',
        ]);

        self::assertResponseRedirects('/questionnaire/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getTitre());
        self::assertSame('Something New', $fixture[0]->getDateCreation());
        self::assertSame('Something New', $fixture[0]->getContenu());
        self::assertSame('Something New', $fixture[0]->getLesson());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Questionnaire();
        $fixture->setTitre('My Title');
        $fixture->setDateCreation('My Title');
        $fixture->setContenu('My Title');
        $fixture->setLesson('My Title');

        $this->repository->add($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/questionnaire/');
    }
}
