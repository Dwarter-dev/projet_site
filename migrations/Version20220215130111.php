<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220215130111 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE produit_genre_produit (produit_id INT NOT NULL, genre_produit_id INT NOT NULL, INDEX IDX_3C7ED901F347EFB (produit_id), INDEX IDX_3C7ED901735DF2DE (genre_produit_id), PRIMARY KEY(produit_id, genre_produit_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE produit_langue_produit (produit_id INT NOT NULL, langue_produit_id INT NOT NULL, INDEX IDX_4364A1C4F347EFB (produit_id), INDEX IDX_4364A1C4EEB4416B (langue_produit_id), PRIMARY KEY(produit_id, langue_produit_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE produit_genre_produit ADD CONSTRAINT FK_3C7ED901F347EFB FOREIGN KEY (produit_id) REFERENCES produit (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE produit_genre_produit ADD CONSTRAINT FK_3C7ED901735DF2DE FOREIGN KEY (genre_produit_id) REFERENCES genre_produit (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE produit_langue_produit ADD CONSTRAINT FK_4364A1C4F347EFB FOREIGN KEY (produit_id) REFERENCES produit (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE produit_langue_produit ADD CONSTRAINT FK_4364A1C4EEB4416B FOREIGN KEY (langue_produit_id) REFERENCES langue_produit (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE commande ADD adresse_id INT NOT NULL, ADD user_id INT NOT NULL, CHANGE date_paiement date_paiement DATE NOT NULL');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D4DE7DC5C FOREIGN KEY (adresse_id) REFERENCES adresse (id)');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_6EEAA67D4DE7DC5C ON commande (adresse_id)');
        $this->addSql('CREATE INDEX IDX_6EEAA67DA76ED395 ON commande (user_id)');
        $this->addSql('ALTER TABLE ligne_commande ADD produit_id INT NOT NULL, ADD commande_id INT NOT NULL');
        $this->addSql('ALTER TABLE ligne_commande ADD CONSTRAINT FK_3170B74BF347EFB FOREIGN KEY (produit_id) REFERENCES produit (id)');
        $this->addSql('ALTER TABLE ligne_commande ADD CONSTRAINT FK_3170B74B82EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id)');
        $this->addSql('CREATE INDEX IDX_3170B74BF347EFB ON ligne_commande (produit_id)');
        $this->addSql('CREATE INDEX IDX_3170B74B82EA2E54 ON ligne_commande (commande_id)');
        $this->addSql('ALTER TABLE produit ADD region_produit_id INT DEFAULT NULL, ADD etat_produit_id INT NOT NULL, ADD categorie_produit_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC272ED34A1A FOREIGN KEY (region_produit_id) REFERENCES region_produit (id)');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC27A67842EE FOREIGN KEY (etat_produit_id) REFERENCES etat_produit (id)');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC2791FDB457 FOREIGN KEY (categorie_produit_id) REFERENCES categorie_produit (id)');
        $this->addSql('CREATE INDEX IDX_29A5EC272ED34A1A ON produit (region_produit_id)');
        $this->addSql('CREATE INDEX IDX_29A5EC27A67842EE ON produit (etat_produit_id)');
        $this->addSql('CREATE INDEX IDX_29A5EC2791FDB457 ON produit (categorie_produit_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE produit_genre_produit');
        $this->addSql('DROP TABLE produit_langue_produit');
        $this->addSql('ALTER TABLE adresse CHANGE destinataire destinataire VARCHAR(75) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE adresse adresse VARCHAR(150) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE complement complement VARCHAR(150) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE ville ville VARCHAR(75) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE pays pays VARCHAR(50) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE categorie_produit CHANGE nom_categorie nom_categorie VARCHAR(25) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67D4DE7DC5C');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67DA76ED395');
        $this->addSql('DROP INDEX IDX_6EEAA67D4DE7DC5C ON commande');
        $this->addSql('DROP INDEX IDX_6EEAA67DA76ED395 ON commande');
        $this->addSql('ALTER TABLE commande DROP adresse_id, DROP user_id, CHANGE date_paiement date_paiement DATETIME NOT NULL');
        $this->addSql('ALTER TABLE etat_produit CHANGE nom_etat nom_etat VARCHAR(25) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE genre_produit CHANGE nom_genre nom_genre VARCHAR(25) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE langue_produit CHANGE nom_langue nom_langue VARCHAR(25) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE ligne_commande DROP FOREIGN KEY FK_3170B74BF347EFB');
        $this->addSql('ALTER TABLE ligne_commande DROP FOREIGN KEY FK_3170B74B82EA2E54');
        $this->addSql('DROP INDEX IDX_3170B74BF347EFB ON ligne_commande');
        $this->addSql('DROP INDEX IDX_3170B74B82EA2E54 ON ligne_commande');
        $this->addSql('ALTER TABLE ligne_commande DROP produit_id, DROP commande_id');
        $this->addSql('ALTER TABLE messenger_messages CHANGE body body LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE headers headers LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE queue_name queue_name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC272ED34A1A');
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC27A67842EE');
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC2791FDB457');
        $this->addSql('DROP INDEX IDX_29A5EC272ED34A1A ON produit');
        $this->addSql('DROP INDEX IDX_29A5EC27A67842EE ON produit');
        $this->addSql('DROP INDEX IDX_29A5EC2791FDB457 ON produit');
        $this->addSql('ALTER TABLE produit DROP region_produit_id, DROP etat_produit_id, DROP categorie_produit_id, CHANGE nom_produit nom_produit VARCHAR(100) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE description_produit description_produit LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE image_produit image_produit VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE region_produit CHANGE nom_region nom_region VARCHAR(25) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE user CHANGE email email VARCHAR(180) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE password password VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
