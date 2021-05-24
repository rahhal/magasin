<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200817090946 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE fonction ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE fonction ADD CONSTRAINT FK_900D5BDA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_900D5BDA76ED395 ON fonction (user_id)');
        $this->addSql('ALTER TABLE fournisseur ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE fournisseur ADD CONSTRAINT FK_369ECA32A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_369ECA32A76ED395 ON fournisseur (user_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE fonction DROP FOREIGN KEY FK_900D5BDA76ED395');
        $this->addSql('DROP INDEX IDX_900D5BDA76ED395 ON fonction');
        $this->addSql('ALTER TABLE fonction DROP user_id');
        $this->addSql('ALTER TABLE fournisseur DROP FOREIGN KEY FK_369ECA32A76ED395');
        $this->addSql('DROP INDEX IDX_369ECA32A76ED395 ON fournisseur');
        $this->addSql('ALTER TABLE fournisseur DROP user_id');
    }
}
