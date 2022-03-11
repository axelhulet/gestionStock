<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220311074550 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs

    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE client CHANGE nom nom VARCHAR(50) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, CHANGE prenom prenom VARCHAR(50) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, CHANGE email email VARCHAR(255) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, CHANGE tel tel VARCHAR(20) CHARACTER SET latin1 DEFAULT NULL COLLATE `latin1_swedish_ci`, CHANGE reference reference VARCHAR(8) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67D19EB6921');
        $this->addSql('ALTER TABLE commande CHANGE reference reference VARCHAR(10) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`');
        $this->addSql('ALTER TABLE ligne_commande DROP FOREIGN KEY FK_3170B74B82EA2E54');
        $this->addSql('ALTER TABLE ligne_commande DROP FOREIGN KEY FK_3170B74BF347EFB');
        $this->addSql('ALTER TABLE messenger_messages CHANGE body body LONGTEXT CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, CHANGE headers headers LONGTEXT CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, CHANGE queue_name queue_name VARCHAR(255) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`');
        $this->addSql('ALTER TABLE produit CHANGE reference reference VARCHAR(8) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, CHANGE nom nom VARCHAR(50) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, CHANGE description description TINYTEXT CHARACTER SET latin1 DEFAULT NULL COLLATE `latin1_swedish_ci`');
    }
}
