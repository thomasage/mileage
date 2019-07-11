<?php
declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20190711074336 extends AbstractMigration
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

        $this->addSql(
            'CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB'
        );
        $this->addSql(
            'CREATE TABLE record (id INT AUTO_INCREMENT NOT NULL, car_id INT NOT NULL, date DATE NOT NULL, value INT NOT NULL, INDEX IDX_9B349F91C3C6F69F (car_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB'
        );
        $this->addSql(
            'CREATE TABLE car (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB'
        );
        $this->addSql('ALTER TABLE record ADD CONSTRAINT FK_9B349F91C3C6F69F FOREIGN KEY (car_id) REFERENCES car (id)');
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

        $this->addSql('ALTER TABLE record DROP FOREIGN KEY FK_9B349F91C3C6F69F');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE record');
        $this->addSql('DROP TABLE car');
    }
}
