<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200818172151 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE benificiaire ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE benificiaire ADD CONSTRAINT FK_57742B16A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_57742B16A76ED395 ON benificiaire (user_id)');
        $this->addSql('ALTER TABLE entree ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE entree ADD CONSTRAINT FK_598377A6A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_598377A6A76ED395 ON entree (user_id)');
        $this->addSql('ALTER TABLE fonction ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE fonction ADD CONSTRAINT FK_900D5BDA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_900D5BDA76ED395 ON fonction (user_id)');
        $this->addSql('ALTER TABLE fournisseur ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE fournisseur ADD CONSTRAINT FK_369ECA32A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_369ECA32A76ED395 ON fournisseur (user_id)');
        $this->addSql('ALTER TABLE inventaire ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE inventaire ADD CONSTRAINT FK_338920E0A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_338920E0A76ED395 ON inventaire (user_id)');
        $this->addSql('ALTER TABLE sortie ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE sortie ADD CONSTRAINT FK_3C3FD3F2A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_3C3FD3F2A76ED395 ON sortie (user_id)');
        $this->addSql('ALTER TABLE stock ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE stock ADD CONSTRAINT FK_4B365660A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_4B365660A76ED395 ON stock (user_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE benificiaire DROP FOREIGN KEY FK_57742B16A76ED395');
        $this->addSql('DROP INDEX IDX_57742B16A76ED395 ON benificiaire');
        $this->addSql('ALTER TABLE benificiaire DROP user_id');
        $this->addSql('ALTER TABLE entree DROP FOREIGN KEY FK_598377A6A76ED395');
        $this->addSql('DROP INDEX IDX_598377A6A76ED395 ON entree');
        $this->addSql('ALTER TABLE entree DROP user_id');
        $this->addSql('ALTER TABLE fonction DROP FOREIGN KEY FK_900D5BDA76ED395');
        $this->addSql('DROP INDEX IDX_900D5BDA76ED395 ON fonction');
        $this->addSql('ALTER TABLE fonction DROP user_id');
        $this->addSql('ALTER TABLE fournisseur DROP FOREIGN KEY FK_369ECA32A76ED395');
        $this->addSql('DROP INDEX IDX_369ECA32A76ED395 ON fournisseur');
        $this->addSql('ALTER TABLE fournisseur DROP user_id');
        $this->addSql('ALTER TABLE inventaire DROP FOREIGN KEY FK_338920E0A76ED395');
        $this->addSql('DROP INDEX IDX_338920E0A76ED395 ON inventaire');
        $this->addSql('ALTER TABLE inventaire DROP user_id');
        $this->addSql('ALTER TABLE sortie DROP FOREIGN KEY FK_3C3FD3F2A76ED395');
        $this->addSql('DROP INDEX IDX_3C3FD3F2A76ED395 ON sortie');
        $this->addSql('ALTER TABLE sortie DROP user_id');
        $this->addSql('ALTER TABLE stock DROP FOREIGN KEY FK_4B365660A76ED395');
        $this->addSql('DROP INDEX IDX_4B365660A76ED395 ON stock');
        $this->addSql('ALTER TABLE stock DROP user_id');
    }
}
