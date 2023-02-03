<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230202062606 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande ADD annule TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE commande_produit ADD frais_port DOUBLE PRECISION NOT NULL, ADD assurance TINYINT(1) NOT NULL, ADD tva DOUBLE PRECISION NOT NULL, ADD prix DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE panier_produit CHANGE panier_id panier_id INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE panier_produit CHANGE panier_id panier_id INT NOT NULL');
        $this->addSql('ALTER TABLE commande DROP annule');
        $this->addSql('ALTER TABLE commande_produit DROP frais_port, DROP assurance, DROP tva, DROP prix');
    }
}
