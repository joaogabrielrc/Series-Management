<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230519231002 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE episode_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE season_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE episodes_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE seasons_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE episodes (id INT NOT NULL, season_id INT NOT NULL, number INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_7DD55EDD4EC001D1 ON episodes (season_id)');
        $this->addSql('CREATE TABLE seasons (id INT NOT NULL, series_id INT NOT NULL, number INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_B4F4301C5278319C ON seasons (series_id)');
        $this->addSql('ALTER TABLE episodes ADD CONSTRAINT FK_7DD55EDD4EC001D1 FOREIGN KEY (season_id) REFERENCES seasons (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE seasons ADD CONSTRAINT FK_B4F4301C5278319C FOREIGN KEY (series_id) REFERENCES series (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE season DROP CONSTRAINT fk_f0e45ba95278319c');
        $this->addSql('ALTER TABLE episode DROP CONSTRAINT fk_ddaa1cda4ec001d1');
        $this->addSql('DROP TABLE season');
        $this->addSql('DROP TABLE episode');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE episodes_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE seasons_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE episode_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE season_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE season (id INT NOT NULL, series_id INT NOT NULL, number INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_f0e45ba95278319c ON season (series_id)');
        $this->addSql('CREATE TABLE episode (id INT NOT NULL, season_id INT NOT NULL, number INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_ddaa1cda4ec001d1 ON episode (season_id)');
        $this->addSql('ALTER TABLE season ADD CONSTRAINT fk_f0e45ba95278319c FOREIGN KEY (series_id) REFERENCES series (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE episode ADD CONSTRAINT fk_ddaa1cda4ec001d1 FOREIGN KEY (season_id) REFERENCES season (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE episodes DROP CONSTRAINT FK_7DD55EDD4EC001D1');
        $this->addSql('ALTER TABLE seasons DROP CONSTRAINT FK_B4F4301C5278319C');
        $this->addSql('DROP TABLE episodes');
        $this->addSql('DROP TABLE seasons');
    }
}
