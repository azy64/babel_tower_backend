<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220809084900 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE class_room (id INT AUTO_INCREMENT NOT NULL, teacher_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, creation_class DATETIME NOT NULL, INDEX IDX_C6E266D441807E1D (teacher_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contenu (id INT AUTO_INCREMENT NOT NULL, type_contenu_id INT NOT NULL, libelle VARCHAR(255) NOT NULL, file_name VARCHAR(255) NOT NULL, INDEX IDX_89C2003F211F12AD (type_contenu_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contenu_lesson (contenu_id INT NOT NULL, lesson_id INT NOT NULL, INDEX IDX_5CE804C13C1CC488 (contenu_id), INDEX IDX_5CE804C1CDF80196 (lesson_id), PRIMARY KEY(contenu_id, lesson_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lecture (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, speed INT NOT NULL, repetition INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lesson (id INT AUTO_INCREMENT NOT NULL, teacher_id INT NOT NULL, class_room_id INT NOT NULL, title VARCHAR(255) NOT NULL, consigne_one VARCHAR(255) NOT NULL, consigne_two VARCHAR(255) DEFAULT NULL, date_lesson DATETIME NOT NULL, INDEX IDX_F87474F341807E1D (teacher_id), INDEX IDX_F87474F39162176F (class_room_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE membership (id INT AUTO_INCREMENT NOT NULL, teacher_id INT NOT NULL, student_id INT NOT NULL, classroom_id INT NOT NULL, date_membership DATETIME NOT NULL, INDEX IDX_86FFD28541807E1D (teacher_id), INDEX IDX_86FFD285CB944F1A (student_id), INDEX IDX_86FFD2856278D5A8 (classroom_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE modality (id INT AUTO_INCREMENT NOT NULL, lesson_id INT NOT NULL, contenu_id INT NOT NULL, lecture_id INT NOT NULL, INDEX IDX_307988C0CDF80196 (lesson_id), INDEX IDX_307988C03C1CC488 (contenu_id), INDEX IDX_307988C035E32FCD (lecture_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE question (id INT AUTO_INCREMENT NOT NULL, questionnaire_id INT DEFAULT NULL, libelle VARCHAR(255) NOT NULL, reponse VARCHAR(255) NOT NULL, assertion1 VARCHAR(255) NOT NULL, assertion2 VARCHAR(255) DEFAULT NULL, assertion3 VARCHAR(255) DEFAULT NULL, INDEX IDX_B6F7494ECE07E8FF (questionnaire_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE questionnaire (id INT AUTO_INCREMENT NOT NULL, contenu_id INT NOT NULL, lesson_id INT NOT NULL, titre VARCHAR(255) NOT NULL, date_creation DATE NOT NULL, UNIQUE INDEX UNIQ_7A64DAF3C1CC488 (contenu_id), INDEX IDX_7A64DAFCDF80196 (lesson_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE resolution (id INT AUTO_INCREMENT NOT NULL, student_id INT NOT NULL, question_id INT NOT NULL, lesson_id INT NOT NULL, date_debut_resolution DATETIME NOT NULL, date_fin_resolution DATETIME NOT NULL, date_resolution DATETIME NOT NULL, libelle_response VARCHAR(255) NOT NULL, INDEX IDX_FDD30F8ACB944F1A (student_id), UNIQUE INDEX UNIQ_FDD30F8A1E27F6BF (question_id), INDEX IDX_FDD30F8ACDF80196 (lesson_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE student (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(50) NOT NULL, prenom VARCHAR(50) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE teacher (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(50) NOT NULL, prenom VARCHAR(50) NOT NULL, langue VARCHAR(50) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_contenu (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE class_room ADD CONSTRAINT FK_C6E266D441807E1D FOREIGN KEY (teacher_id) REFERENCES teacher (id)');
        $this->addSql('ALTER TABLE contenu ADD CONSTRAINT FK_89C2003F211F12AD FOREIGN KEY (type_contenu_id) REFERENCES type_contenu (id)');
        $this->addSql('ALTER TABLE contenu_lesson ADD CONSTRAINT FK_5CE804C13C1CC488 FOREIGN KEY (contenu_id) REFERENCES contenu (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE contenu_lesson ADD CONSTRAINT FK_5CE804C1CDF80196 FOREIGN KEY (lesson_id) REFERENCES lesson (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE lesson ADD CONSTRAINT FK_F87474F341807E1D FOREIGN KEY (teacher_id) REFERENCES teacher (id)');
        $this->addSql('ALTER TABLE lesson ADD CONSTRAINT FK_F87474F39162176F FOREIGN KEY (class_room_id) REFERENCES class_room (id)');
        $this->addSql('ALTER TABLE membership ADD CONSTRAINT FK_86FFD28541807E1D FOREIGN KEY (teacher_id) REFERENCES teacher (id)');
        $this->addSql('ALTER TABLE membership ADD CONSTRAINT FK_86FFD285CB944F1A FOREIGN KEY (student_id) REFERENCES student (id)');
        $this->addSql('ALTER TABLE membership ADD CONSTRAINT FK_86FFD2856278D5A8 FOREIGN KEY (classroom_id) REFERENCES class_room (id)');
        $this->addSql('ALTER TABLE modality ADD CONSTRAINT FK_307988C0CDF80196 FOREIGN KEY (lesson_id) REFERENCES lesson (id)');
        $this->addSql('ALTER TABLE modality ADD CONSTRAINT FK_307988C03C1CC488 FOREIGN KEY (contenu_id) REFERENCES contenu (id)');
        $this->addSql('ALTER TABLE modality ADD CONSTRAINT FK_307988C035E32FCD FOREIGN KEY (lecture_id) REFERENCES lecture (id)');
        $this->addSql('ALTER TABLE question ADD CONSTRAINT FK_B6F7494ECE07E8FF FOREIGN KEY (questionnaire_id) REFERENCES questionnaire (id)');
        $this->addSql('ALTER TABLE questionnaire ADD CONSTRAINT FK_7A64DAF3C1CC488 FOREIGN KEY (contenu_id) REFERENCES contenu (id)');
        $this->addSql('ALTER TABLE questionnaire ADD CONSTRAINT FK_7A64DAFCDF80196 FOREIGN KEY (lesson_id) REFERENCES lesson (id)');
        $this->addSql('ALTER TABLE resolution ADD CONSTRAINT FK_FDD30F8ACB944F1A FOREIGN KEY (student_id) REFERENCES student (id)');
        $this->addSql('ALTER TABLE resolution ADD CONSTRAINT FK_FDD30F8A1E27F6BF FOREIGN KEY (question_id) REFERENCES question (id)');
        $this->addSql('ALTER TABLE resolution ADD CONSTRAINT FK_FDD30F8ACDF80196 FOREIGN KEY (lesson_id) REFERENCES lesson (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE lesson DROP FOREIGN KEY FK_F87474F39162176F');
        $this->addSql('ALTER TABLE membership DROP FOREIGN KEY FK_86FFD2856278D5A8');
        $this->addSql('ALTER TABLE contenu_lesson DROP FOREIGN KEY FK_5CE804C13C1CC488');
        $this->addSql('ALTER TABLE modality DROP FOREIGN KEY FK_307988C03C1CC488');
        $this->addSql('ALTER TABLE questionnaire DROP FOREIGN KEY FK_7A64DAF3C1CC488');
        $this->addSql('ALTER TABLE modality DROP FOREIGN KEY FK_307988C035E32FCD');
        $this->addSql('ALTER TABLE contenu_lesson DROP FOREIGN KEY FK_5CE804C1CDF80196');
        $this->addSql('ALTER TABLE modality DROP FOREIGN KEY FK_307988C0CDF80196');
        $this->addSql('ALTER TABLE questionnaire DROP FOREIGN KEY FK_7A64DAFCDF80196');
        $this->addSql('ALTER TABLE resolution DROP FOREIGN KEY FK_FDD30F8ACDF80196');
        $this->addSql('ALTER TABLE resolution DROP FOREIGN KEY FK_FDD30F8A1E27F6BF');
        $this->addSql('ALTER TABLE question DROP FOREIGN KEY FK_B6F7494ECE07E8FF');
        $this->addSql('ALTER TABLE membership DROP FOREIGN KEY FK_86FFD285CB944F1A');
        $this->addSql('ALTER TABLE resolution DROP FOREIGN KEY FK_FDD30F8ACB944F1A');
        $this->addSql('ALTER TABLE class_room DROP FOREIGN KEY FK_C6E266D441807E1D');
        $this->addSql('ALTER TABLE lesson DROP FOREIGN KEY FK_F87474F341807E1D');
        $this->addSql('ALTER TABLE membership DROP FOREIGN KEY FK_86FFD28541807E1D');
        $this->addSql('ALTER TABLE contenu DROP FOREIGN KEY FK_89C2003F211F12AD');
        $this->addSql('DROP TABLE class_room');
        $this->addSql('DROP TABLE contenu');
        $this->addSql('DROP TABLE contenu_lesson');
        $this->addSql('DROP TABLE lecture');
        $this->addSql('DROP TABLE lesson');
        $this->addSql('DROP TABLE membership');
        $this->addSql('DROP TABLE modality');
        $this->addSql('DROP TABLE question');
        $this->addSql('DROP TABLE questionnaire');
        $this->addSql('DROP TABLE resolution');
        $this->addSql('DROP TABLE student');
        $this->addSql('DROP TABLE teacher');
        $this->addSql('DROP TABLE type_contenu');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
