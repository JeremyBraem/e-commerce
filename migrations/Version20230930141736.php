<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230930141736 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE hobby (id INT AUTO_INCREMENT NOT NULL, designation VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE job (id INT AUTO_INCREMENT NOT NULL, designation VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE profil (id INT AUTO_INCREMENT NOT NULL, url VARCHAR(255) NOT NULL, rs VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users_hobby (users_id INT NOT NULL, hobby_id INT NOT NULL, INDEX IDX_DE13577E67B3B43D (users_id), INDEX IDX_DE13577E322B2123 (hobby_id), PRIMARY KEY(users_id, hobby_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE users_hobby ADD CONSTRAINT FK_DE13577E67B3B43D FOREIGN KEY (users_id) REFERENCES users (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE users_hobby ADD CONSTRAINT FK_DE13577E322B2123 FOREIGN KEY (hobby_id) REFERENCES hobby (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE personne');
        $this->addSql('ALTER TABLE users ADD profile_id INT DEFAULT NULL, ADD job_id INT DEFAULT NULL, DROP job');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E9CCFA12B8 FOREIGN KEY (profile_id) REFERENCES profil (id)');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E9BE04EA9 FOREIGN KEY (job_id) REFERENCES job (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E9CCFA12B8 ON users (profile_id)');
        $this->addSql('CREATE INDEX IDX_1483A5E9BE04EA9 ON users (job_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE users DROP FOREIGN KEY FK_1483A5E9BE04EA9');
        $this->addSql('ALTER TABLE users DROP FOREIGN KEY FK_1483A5E9CCFA12B8');
        $this->addSql('CREATE TABLE personne (id INT AUTO_INCREMENT NOT NULL, firstname VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, age SMALLINT NOT NULL, job VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE users_hobby DROP FOREIGN KEY FK_DE13577E67B3B43D');
        $this->addSql('ALTER TABLE users_hobby DROP FOREIGN KEY FK_DE13577E322B2123');
        $this->addSql('DROP TABLE hobby');
        $this->addSql('DROP TABLE job');
        $this->addSql('DROP TABLE profil');
        $this->addSql('DROP TABLE users_hobby');
        $this->addSql('DROP INDEX UNIQ_1483A5E9CCFA12B8 ON users');
        $this->addSql('DROP INDEX IDX_1483A5E9BE04EA9 ON users');
        $this->addSql('ALTER TABLE users ADD job VARCHAR(255) DEFAULT NULL, DROP profile_id, DROP job_id');
    }
}
