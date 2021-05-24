<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200429084053 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE entree (id INT AUTO_INCREMENT NOT NULL, fournisseur_id INT NOT NULL, date_entree DATE NOT NULL, date_bc DATE NOT NULL, reference VARCHAR(255) NOT NULL, num_entree VARCHAR(255) NOT NULL, num_bc VARCHAR(255) NOT NULL, INDEX IDX_598377A6670C757F (fournisseur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ligne_entree (id INT AUTO_INCREMENT NOT NULL, article_id INT NOT NULL, entree_id INT DEFAULT NULL, qte_entr INT NOT NULL, qte_reste INT NOT NULL, INDEX IDX_7F59EBE07294869C (article_id), INDEX IDX_7F59EBE0AF7BD910 (entree_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE entree ADD CONSTRAINT FK_598377A6670C757F FOREIGN KEY (fournisseur_id) REFERENCES fournisseur (id)');
        $this->addSql('ALTER TABLE ligne_entree ADD CONSTRAINT FK_7F59EBE07294869C FOREIGN KEY (article_id) REFERENCES article (id)');
        $this->addSql('ALTER TABLE ligne_entree ADD CONSTRAINT FK_7F59EBE0AF7BD910 FOREIGN KEY (entree_id) REFERENCES entree (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE ligne_entree DROP FOREIGN KEY FK_7F59EBE0AF7BD910');
        $this->addSql('DROP TABLE entree');
        $this->addSql('DROP TABLE ligne_entree');
    }
}
