<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241114205835 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE country CHANGE nombre_comun nombre_comun VARCHAR(100) DEFAULT NULL, CHANGE nombre_oficial nombre_oficial VARCHAR(255) DEFAULT NULL, CHANGE region region VARCHAR(100) DEFAULT NULL, CHANGE subregion subregion VARCHAR(100) DEFAULT NULL, CHANGE capital capital VARCHAR(255) DEFAULT NULL, CHANGE bandera bandera VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE country CHANGE nombre_comun nombre_comun VARCHAR(100) NOT NULL, CHANGE nombre_oficial nombre_oficial VARCHAR(255) NOT NULL, CHANGE region region VARCHAR(100) NOT NULL, CHANGE subregion subregion VARCHAR(100) NOT NULL, CHANGE capital capital VARCHAR(255) NOT NULL, CHANGE bandera bandera VARCHAR(255) NOT NULL');
    }
}
