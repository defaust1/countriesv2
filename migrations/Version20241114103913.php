<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241114103913 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE country ADD region VARCHAR(100) NOT NULL, ADD subregion VARCHAR(100) NOT NULL, ADD capital VARCHAR(255) NOT NULL, ADD poblacion INT NOT NULL, ADD area DOUBLE PRECISION NOT NULL, ADD bandera VARCHAR(255) NOT NULL, ADD idiomas LONGTEXT NOT NULL, ADD monedas VARCHAR(255) NOT NULL, ADD fronteras VARCHAR(255) NOT NULL, ADD lat DOUBLE PRECISION NOT NULL, ADD lng DOUBLE PRECISION NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE country DROP region, DROP subregion, DROP capital, DROP poblacion, DROP area, DROP bandera, DROP idiomas, DROP monedas, DROP fronteras, DROP lat, DROP lng');
    }
}
