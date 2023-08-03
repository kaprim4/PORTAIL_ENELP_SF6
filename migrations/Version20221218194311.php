<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221218194311 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE grade_type');
        $this->addSql('ALTER TABLE gas_station_grade ADD CONSTRAINT FK_65A79ED0916BFF50 FOREIGN KEY (gas_station_id) REFERENCES `gas_station` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE gas_station_grade ADD CONSTRAINT FK_65A79ED0FE19A1A8 FOREIGN KEY (grade_id) REFERENCES `grade` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE widget ADD CONSTRAINT FK_85F91ED0B2D2ECCF FOREIGN KEY (hook_id) REFERENCES `hook` (id)');
        $this->addSql('ALTER TABLE widget ADD CONSTRAINT FK_85F91ED0AFC2B591 FOREIGN KEY (module_id) REFERENCES `module` (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE grade_type (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, is_activated TINYINT(1) DEFAULT 0 NOT NULL, is_deleted TINYINT(1) DEFAULT 0 NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE gas_station_grade DROP FOREIGN KEY FK_65A79ED0916BFF50');
        $this->addSql('ALTER TABLE gas_station_grade DROP FOREIGN KEY FK_65A79ED0FE19A1A8');
        $this->addSql('ALTER TABLE `widget` DROP FOREIGN KEY FK_85F91ED0B2D2ECCF');
        $this->addSql('ALTER TABLE `widget` DROP FOREIGN KEY FK_85F91ED0AFC2B591');
    }
}
