<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230904074643 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE artiste (id INT AUTO_INCREMENT NOT NULL, nom_scene VARCHAR(255) NOT NULL, style VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE departement (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(100) NOT NULL, code VARCHAR(2) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE main (id INT AUTO_INCREMENT NOT NULL, departement_id INT NOT NULL, nom VARCHAR(100) NOT NULL, lieu VARCHAR(100) NOT NULL, date_creation DATE NOT NULL, INDEX IDX_57CF789CCF9E01E (departement_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE festival_artiste (festival_id INT NOT NULL, artiste_id INT NOT NULL, INDEX IDX_B1E20C5E8AEBAF57 (festival_id), INDEX IDX_B1E20C5E21D25844 (artiste_id), PRIMARY KEY(festival_id, artiste_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE main ADD CONSTRAINT FK_57CF789CCF9E01E FOREIGN KEY (departement_id) REFERENCES departement (id)');
        $this->addSql('ALTER TABLE festival_artiste ADD CONSTRAINT FK_B1E20C5E8AEBAF57 FOREIGN KEY (festival_id) REFERENCES main (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE festival_artiste ADD CONSTRAINT FK_B1E20C5E21D25844 FOREIGN KEY (artiste_id) REFERENCES artiste (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE main DROP FOREIGN KEY FK_57CF789CCF9E01E');
        $this->addSql('ALTER TABLE festival_artiste DROP FOREIGN KEY FK_B1E20C5E8AEBAF57');
        $this->addSql('ALTER TABLE festival_artiste DROP FOREIGN KEY FK_B1E20C5E21D25844');
        $this->addSql('DROP TABLE artiste');
        $this->addSql('DROP TABLE departement');
        $this->addSql('DROP TABLE main');
        $this->addSql('DROP TABLE festival_artiste');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
