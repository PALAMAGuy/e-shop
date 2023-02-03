<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230127065001 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE stock (id INT AUTO_INCREMENT NOT NULL, article_id INT NOT NULL, stockage_id INT NOT NULL, nb_en_stock INT NOT NULL, INDEX IDX_4B3656607294869C (article_id), INDEX IDX_4B365660DAA83D7F (stockage_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE stock ADD CONSTRAINT FK_4B3656607294869C FOREIGN KEY (article_id) REFERENCES produit (id)');
        $this->addSql('ALTER TABLE stock ADD CONSTRAINT FK_4B365660DAA83D7F FOREIGN KEY (stockage_id) REFERENCES stockage (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE stock DROP FOREIGN KEY FK_4B3656607294869C');
        $this->addSql('ALTER TABLE stock DROP FOREIGN KEY FK_4B365660DAA83D7F');
        $this->addSql('DROP TABLE stock');
    }
}
