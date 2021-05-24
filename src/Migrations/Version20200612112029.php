<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200612112029 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE ligne_inventaire DROP FOREIGN KEY FK_D025CEFD1EBAF6CC');
        $this->addSql('DROP INDEX IDX_D025CEFD1EBAF6CC ON ligne_inventaire');
        $this->addSql('ALTER TABLE ligne_inventaire CHANGE articles_id article_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE ligne_inventaire ADD CONSTRAINT FK_D025CEFD7294869C FOREIGN KEY (article_id) REFERENCES article (id)');
        $this->addSql('CREATE INDEX IDX_D025CEFD7294869C ON ligne_inventaire (article_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE ligne_inventaire DROP FOREIGN KEY FK_D025CEFD7294869C');
        $this->addSql('DROP INDEX IDX_D025CEFD7294869C ON ligne_inventaire');
        $this->addSql('ALTER TABLE ligne_inventaire CHANGE article_id articles_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE ligne_inventaire ADD CONSTRAINT FK_D025CEFD1EBAF6CC FOREIGN KEY (articles_id) REFERENCES article (id)');
        $this->addSql('CREATE INDEX IDX_D025CEFD1EBAF6CC ON ligne_inventaire (articles_id)');
    }
}
