<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200611093343 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE ligne_sortie_stock (ligne_sortie_id INT NOT NULL, stock_id INT NOT NULL, INDEX IDX_6AE6B3AB397D6DB (ligne_sortie_id), INDEX IDX_6AE6B3ABDCD6110 (stock_id), PRIMARY KEY(ligne_sortie_id, stock_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ligne_sortie_stock ADD CONSTRAINT FK_6AE6B3AB397D6DB FOREIGN KEY (ligne_sortie_id) REFERENCES ligne_sortie (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ligne_sortie_stock ADD CONSTRAINT FK_6AE6B3ABDCD6110 FOREIGN KEY (stock_id) REFERENCES stock (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE ligne_sortie_stock');
    }
}
