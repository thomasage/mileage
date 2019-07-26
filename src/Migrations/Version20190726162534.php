<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20190726162534 extends AbstractMigration
{
    /**
     * @param Schema $schema
     * @throws DBALException
     */
    public function up(Schema $schema): void
    {
        $this->abortIf(
            'mysql' !== $this->connection->getDatabasePlatform()->getName(),
            'Migration can only be executed safely on \'mysql\'.'
        );

        $this->addSql('DELETE FROM record WHERE forecast = 1');
        $this->addSql('ALTER TABLE record DROP forecast');
        $this->addSql(
            'ALTER TABLE car CHANGE rental_started_at rental_started_at DATE DEFAULT NULL, CHANGE rental_started_mileage rental_started_mileage INT DEFAULT NULL, CHANGE rental_ended_at rental_ended_at DATE DEFAULT NULL, CHANGE rental_ended_mileage rental_ended_mileage INT DEFAULT NULL'
        );
    }

    /**
     * @param Schema $schema
     * @throws DBALException
     */
    public function down(Schema $schema): void
    {
        $this->abortIf(
            'mysql' !== $this->connection->getDatabasePlatform()->getName(),
            'Migration can only be executed safely on \'mysql\'.'
        );

        $this->addSql(
            'ALTER TABLE car CHANGE rental_started_at rental_started_at DATE DEFAULT \'NULL\', CHANGE rental_started_mileage rental_started_mileage INT DEFAULT NULL, CHANGE rental_ended_at rental_ended_at DATE DEFAULT \'NULL\', CHANGE rental_ended_mileage rental_ended_mileage INT DEFAULT NULL'
        );
        $this->addSql('ALTER TABLE record ADD forecast TINYINT(1) NOT NULL');
    }
}
