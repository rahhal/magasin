<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201014115434 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE annee (id INT AUTO_INCREMENT NOT NULL, libele_an VARCHAR(255) NOT NULL, courante TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE article (id INT AUTO_INCREMENT NOT NULL, categorie_id INT NOT NULL, type_id INT NOT NULL, user_id INT DEFAULT NULL, libele VARCHAR(255) NOT NULL, qte_min INT NOT NULL, qte_ini INT NOT NULL, remarque VARCHAR(255) DEFAULT NULL, INDEX IDX_23A0E66BCF5E72D (categorie_id), INDEX IDX_23A0E66C54C8C93 (type_id), INDEX IDX_23A0E66A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE benificiaire (id INT AUTO_INCREMENT NOT NULL, fonction_id INT NOT NULL, user_id INT DEFAULT NULL, benificiaire VARCHAR(255) NOT NULL, remarque VARCHAR(255) DEFAULT NULL, INDEX IDX_57742B1657889920 (fonction_id), INDEX IDX_57742B16A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categorie (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, designation VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, INDEX IDX_497DD634A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE date (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE entree (id INT AUTO_INCREMENT NOT NULL, fournisseur_id INT NOT NULL, user_id INT DEFAULT NULL, date_entree DATE NOT NULL, date_bc DATE NOT NULL, reference VARCHAR(255) NOT NULL, num_entree VARCHAR(255) NOT NULL, num_bc VARCHAR(255) NOT NULL, INDEX IDX_598377A6670C757F (fournisseur_id), INDEX IDX_598377A6A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fonction (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, fonction VARCHAR(255) NOT NULL, remarque VARCHAR(255) DEFAULT NULL, INDEX IDX_900D5BDA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fournisseur (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, cin INT DEFAULT NULL, matricule VARCHAR(255) DEFAULT NULL, tel VARCHAR(255) NOT NULL, adresse VARCHAR(255) NOT NULL, email VARCHAR(255) DEFAULT NULL, INDEX IDX_369ECA32A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE inventaire (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, num_inv VARCHAR(255) NOT NULL, date DATE NOT NULL, INDEX IDX_338920E0A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ligne_entree (id INT AUTO_INCREMENT NOT NULL, article_id INT NOT NULL, entree_id INT DEFAULT NULL, qte_entr INT NOT NULL, qte_reste INT DEFAULT NULL, INDEX IDX_7F59EBE07294869C (article_id), INDEX IDX_7F59EBE0AF7BD910 (entree_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ligne_inventaire (id INT AUTO_INCREMENT NOT NULL, article_id INT DEFAULT NULL, inventaire_id INT NOT NULL, stock_id INT NOT NULL, qte_inv INT NOT NULL, INDEX IDX_D025CEFD7294869C (article_id), INDEX IDX_D025CEFDCE430A85 (inventaire_id), INDEX IDX_D025CEFDDCD6110 (stock_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ligne_sortie (id INT AUTO_INCREMENT NOT NULL, article_id INT NOT NULL, sortie_id INT DEFAULT NULL, reference VARCHAR(255) NOT NULL, qte INT NOT NULL, INDEX IDX_1AE54FB47294869C (article_id), INDEX IDX_1AE54FB4CC72D953 (sortie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ligne_sortie_stock (ligne_sortie_id INT NOT NULL, stock_id INT NOT NULL, INDEX IDX_6AE6B3AB397D6DB (ligne_sortie_id), INDEX IDX_6AE6B3ABDCD6110 (stock_id), PRIMARY KEY(ligne_sortie_id, stock_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE societe (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, nom_soc VARCHAR(255) NOT NULL, ministere VARCHAR(255) NOT NULL, siege VARCHAR(255) NOT NULL, adresse VARCHAR(255) NOT NULL, ville VARCHAR(255) NOT NULL, magasinier VARCHAR(255) NOT NULL, directeur VARCHAR(255) NOT NULL, tel VARCHAR(255) NOT NULL, fax VARCHAR(255) NOT NULL, INDEX IDX_19653DBDA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sortie (id INT AUTO_INCREMENT NOT NULL, annee_id INT DEFAULT NULL, benificiaire_id INT NOT NULL, user_id INT DEFAULT NULL, date DATE NOT NULL, bon_sortie VARCHAR(255) NOT NULL, num VARCHAR(255) NOT NULL, INDEX IDX_3C3FD3F2543EC5F0 (annee_id), INDEX IDX_3C3FD3F25FF252E9 (benificiaire_id), INDEX IDX_3C3FD3F2A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE stock (id INT AUTO_INCREMENT NOT NULL, article_id INT NOT NULL, ligne_entree_id INT NOT NULL, user_id INT DEFAULT NULL, date DATE NOT NULL, qte INT NOT NULL, qte_reste INT NOT NULL, INDEX IDX_4B3656607294869C (article_id), INDEX IDX_4B365660609ED698 (ligne_entree_id), INDEX IDX_4B365660A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, designation VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, INDEX IDX_8CDE5729A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, fullname VARCHAR(255) DEFAULT NULL, societe VARCHAR(255) DEFAULT NULL, rib VARCHAR(255) DEFAULT NULL, cin INT DEFAULT NULL, tel VARCHAR(255) DEFAULT NULL, adresse VARCHAR(255) DEFAULT NULL, avatar VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E66BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id)');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E66C54C8C93 FOREIGN KEY (type_id) REFERENCES type (id)');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E66A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE benificiaire ADD CONSTRAINT FK_57742B1657889920 FOREIGN KEY (fonction_id) REFERENCES fonction (id)');
        $this->addSql('ALTER TABLE benificiaire ADD CONSTRAINT FK_57742B16A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE categorie ADD CONSTRAINT FK_497DD634A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE entree ADD CONSTRAINT FK_598377A6670C757F FOREIGN KEY (fournisseur_id) REFERENCES fournisseur (id)');
        $this->addSql('ALTER TABLE entree ADD CONSTRAINT FK_598377A6A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE fonction ADD CONSTRAINT FK_900D5BDA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE fournisseur ADD CONSTRAINT FK_369ECA32A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE inventaire ADD CONSTRAINT FK_338920E0A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE ligne_entree ADD CONSTRAINT FK_7F59EBE07294869C FOREIGN KEY (article_id) REFERENCES article (id)');
        $this->addSql('ALTER TABLE ligne_entree ADD CONSTRAINT FK_7F59EBE0AF7BD910 FOREIGN KEY (entree_id) REFERENCES entree (id)');
        $this->addSql('ALTER TABLE ligne_inventaire ADD CONSTRAINT FK_D025CEFD7294869C FOREIGN KEY (article_id) REFERENCES article (id)');
        $this->addSql('ALTER TABLE ligne_inventaire ADD CONSTRAINT FK_D025CEFDCE430A85 FOREIGN KEY (inventaire_id) REFERENCES inventaire (id)');
        $this->addSql('ALTER TABLE ligne_inventaire ADD CONSTRAINT FK_D025CEFDDCD6110 FOREIGN KEY (stock_id) REFERENCES stock (id)');
        $this->addSql('ALTER TABLE ligne_sortie ADD CONSTRAINT FK_1AE54FB47294869C FOREIGN KEY (article_id) REFERENCES article (id)');
        $this->addSql('ALTER TABLE ligne_sortie ADD CONSTRAINT FK_1AE54FB4CC72D953 FOREIGN KEY (sortie_id) REFERENCES sortie (id)');
        $this->addSql('ALTER TABLE ligne_sortie_stock ADD CONSTRAINT FK_6AE6B3AB397D6DB FOREIGN KEY (ligne_sortie_id) REFERENCES ligne_sortie (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ligne_sortie_stock ADD CONSTRAINT FK_6AE6B3ABDCD6110 FOREIGN KEY (stock_id) REFERENCES stock (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE societe ADD CONSTRAINT FK_19653DBDA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE sortie ADD CONSTRAINT FK_3C3FD3F2543EC5F0 FOREIGN KEY (annee_id) REFERENCES annee (id)');
        $this->addSql('ALTER TABLE sortie ADD CONSTRAINT FK_3C3FD3F25FF252E9 FOREIGN KEY (benificiaire_id) REFERENCES benificiaire (id)');
        $this->addSql('ALTER TABLE sortie ADD CONSTRAINT FK_3C3FD3F2A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE stock ADD CONSTRAINT FK_4B3656607294869C FOREIGN KEY (article_id) REFERENCES article (id)');
        $this->addSql('ALTER TABLE stock ADD CONSTRAINT FK_4B365660609ED698 FOREIGN KEY (ligne_entree_id) REFERENCES ligne_entree (id)');
        $this->addSql('ALTER TABLE stock ADD CONSTRAINT FK_4B365660A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE type ADD CONSTRAINT FK_8CDE5729A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE sortie DROP FOREIGN KEY FK_3C3FD3F2543EC5F0');
        $this->addSql('ALTER TABLE ligne_entree DROP FOREIGN KEY FK_7F59EBE07294869C');
        $this->addSql('ALTER TABLE ligne_inventaire DROP FOREIGN KEY FK_D025CEFD7294869C');
        $this->addSql('ALTER TABLE ligne_sortie DROP FOREIGN KEY FK_1AE54FB47294869C');
        $this->addSql('ALTER TABLE stock DROP FOREIGN KEY FK_4B3656607294869C');
        $this->addSql('ALTER TABLE sortie DROP FOREIGN KEY FK_3C3FD3F25FF252E9');
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E66BCF5E72D');
        $this->addSql('ALTER TABLE ligne_entree DROP FOREIGN KEY FK_7F59EBE0AF7BD910');
        $this->addSql('ALTER TABLE benificiaire DROP FOREIGN KEY FK_57742B1657889920');
        $this->addSql('ALTER TABLE entree DROP FOREIGN KEY FK_598377A6670C757F');
        $this->addSql('ALTER TABLE ligne_inventaire DROP FOREIGN KEY FK_D025CEFDCE430A85');
        $this->addSql('ALTER TABLE stock DROP FOREIGN KEY FK_4B365660609ED698');
        $this->addSql('ALTER TABLE ligne_sortie_stock DROP FOREIGN KEY FK_6AE6B3AB397D6DB');
        $this->addSql('ALTER TABLE ligne_sortie DROP FOREIGN KEY FK_1AE54FB4CC72D953');
        $this->addSql('ALTER TABLE ligne_inventaire DROP FOREIGN KEY FK_D025CEFDDCD6110');
        $this->addSql('ALTER TABLE ligne_sortie_stock DROP FOREIGN KEY FK_6AE6B3ABDCD6110');
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E66C54C8C93');
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E66A76ED395');
        $this->addSql('ALTER TABLE benificiaire DROP FOREIGN KEY FK_57742B16A76ED395');
        $this->addSql('ALTER TABLE categorie DROP FOREIGN KEY FK_497DD634A76ED395');
        $this->addSql('ALTER TABLE entree DROP FOREIGN KEY FK_598377A6A76ED395');
        $this->addSql('ALTER TABLE fonction DROP FOREIGN KEY FK_900D5BDA76ED395');
        $this->addSql('ALTER TABLE fournisseur DROP FOREIGN KEY FK_369ECA32A76ED395');
        $this->addSql('ALTER TABLE inventaire DROP FOREIGN KEY FK_338920E0A76ED395');
        $this->addSql('ALTER TABLE societe DROP FOREIGN KEY FK_19653DBDA76ED395');
        $this->addSql('ALTER TABLE sortie DROP FOREIGN KEY FK_3C3FD3F2A76ED395');
        $this->addSql('ALTER TABLE stock DROP FOREIGN KEY FK_4B365660A76ED395');
        $this->addSql('ALTER TABLE type DROP FOREIGN KEY FK_8CDE5729A76ED395');
        $this->addSql('DROP TABLE annee');
        $this->addSql('DROP TABLE article');
        $this->addSql('DROP TABLE benificiaire');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE date');
        $this->addSql('DROP TABLE entree');
        $this->addSql('DROP TABLE fonction');
        $this->addSql('DROP TABLE fournisseur');
        $this->addSql('DROP TABLE inventaire');
        $this->addSql('DROP TABLE ligne_entree');
        $this->addSql('DROP TABLE ligne_inventaire');
        $this->addSql('DROP TABLE ligne_sortie');
        $this->addSql('DROP TABLE ligne_sortie_stock');
        $this->addSql('DROP TABLE societe');
        $this->addSql('DROP TABLE sortie');
        $this->addSql('DROP TABLE stock');
        $this->addSql('DROP TABLE type');
        $this->addSql('DROP TABLE user');
    }
}
