<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230126071818 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE produit_marque (produit_id INT NOT NULL, marque_id INT NOT NULL, INDEX IDX_AD3D5AF4F347EFB (produit_id), INDEX IDX_AD3D5AF44827B9B2 (marque_id), PRIMARY KEY(produit_id, marque_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE produit_marque ADD CONSTRAINT FK_AD3D5AF4F347EFB FOREIGN KEY (produit_id) REFERENCES produit (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE produit_marque ADD CONSTRAINT FK_AD3D5AF44827B9B2 FOREIGN KEY (marque_id) REFERENCES marque (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE produit ADD categorie_id INT NOT NULL');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC27BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie_produit (id)');
        $this->addSql('CREATE INDEX IDX_29A5EC27BCF5E72D ON produit (categorie_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE produit_marque DROP FOREIGN KEY FK_AD3D5AF4F347EFB');
        $this->addSql('ALTER TABLE produit_marque DROP FOREIGN KEY FK_AD3D5AF44827B9B2');
        $this->addSql('DROP TABLE produit_marque');
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC27BCF5E72D');
        $this->addSql('DROP INDEX IDX_29A5EC27BCF5E72D ON produit');
        $this->addSql('ALTER TABLE produit DROP categorie_id');
    }
}
