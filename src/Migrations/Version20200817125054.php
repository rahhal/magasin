<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200817125054 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE ligne_entree ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE ligne_entree ADD CONSTRAINT FK_7F59EBE0A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_7F59EBE0A76ED395 ON ligne_entree (user_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE ligne_entree DROP FOREIGN KEY FK_7F59EBE0A76ED395');
        $this->addSql('DROP INDEX IDX_7F59EBE0A76ED395 ON ligne_entree');
        $this->addSql('ALTER TABLE ligne_entree DROP user_id');
    }
}
