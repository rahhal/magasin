<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200609140523 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE ligne_sortie (id INT AUTO_INCREMENT NOT NULL, article_id INT NOT NULL, sortie_id INT DEFAULT NULL, reference VARCHAR(255) NOT NULL, qte INT NOT NULL, INDEX IDX_1AE54FB47294869C (article_id), INDEX IDX_1AE54FB4CC72D953 (sortie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sortie (id INT AUTO_INCREMENT NOT NULL, annee_id INT DEFAULT NULL, benificiaire_id INT NOT NULL, date DATE NOT NULL, bon_sortie VARCHAR(255) NOT NULL, num VARCHAR(255) NOT NULL, INDEX IDX_3C3FD3F2543EC5F0 (annee_id), INDEX IDX_3C3FD3F25FF252E9 (benificiaire_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ligne_sortie ADD CONSTRAINT FK_1AE54FB47294869C FOREIGN KEY (article_id) REFERENCES article (id)');
        $this->addSql('ALTER TABLE ligne_sortie ADD CONSTRAINT FK_1AE54FB4CC72D953 FOREIGN KEY (sortie_id) REFERENCES sortie (id)');
        $this->addSql('ALTER TABLE sortie ADD CONSTRAINT FK_3C3FD3F2543EC5F0 FOREIGN KEY (annee_id) REFERENCES annee (id)');
        $this->addSql('ALTER TABLE sortie ADD CONSTRAINT FK_3C3FD3F25FF252E9 FOREIGN KEY (benificiaire_id) REFERENCES benificiaire (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE ligne_sortie DROP FOREIGN KEY FK_1AE54FB4CC72D953');
        $this->addSql('DROP TABLE ligne_sortie');
        $this->addSql('DROP TABLE sortie');
    }
}
