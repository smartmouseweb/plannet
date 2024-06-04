<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240604130745 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE partner (id INT AUTO_INCREMENT NOT NULL, url VARCHAR(255) DEFAULT NULL, code VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_312B3E1677153098 (code), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE prize (id INT AUTO_INCREMENT NOT NULL, partner_id INT NOT NULL, code VARCHAR(255) NOT NULL, INDEX IDX_51C88BC19393F8FE (partner_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE prize_to_user (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, prize_id INT NOT NULL, date_added DATE NOT NULL, INDEX IDX_DAE0A5F8A76ED395 (user_id), INDEX IDX_DAE0A5F8BBE43214 (prize_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE setting (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, value VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE translation (id INT AUTO_INCREMENT NOT NULL, type_id INT NOT NULL, locale_id INT NOT NULL, bind_id INT NOT NULL, field VARCHAR(255) NOT NULL, value LONGTEXT DEFAULT NULL, INDEX IDX_B469456FC54C8C93 (type_id), INDEX IDX_B469456FE559DFD1 (locale_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE translation_locale (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE translation_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, api_token VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE prize ADD CONSTRAINT FK_51C88BC19393F8FE FOREIGN KEY (partner_id) REFERENCES partner (id)');
        $this->addSql('ALTER TABLE prize_to_user ADD CONSTRAINT FK_DAE0A5F8A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE prize_to_user ADD CONSTRAINT FK_DAE0A5F8BBE43214 FOREIGN KEY (prize_id) REFERENCES prize (id)');
        $this->addSql('ALTER TABLE translation ADD CONSTRAINT FK_B469456FC54C8C93 FOREIGN KEY (type_id) REFERENCES translation_type (id)');
        $this->addSql('ALTER TABLE translation ADD CONSTRAINT FK_B469456FE559DFD1 FOREIGN KEY (locale_id) REFERENCES translation_locale (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE prize DROP FOREIGN KEY FK_51C88BC19393F8FE');
        $this->addSql('ALTER TABLE prize_to_user DROP FOREIGN KEY FK_DAE0A5F8A76ED395');
        $this->addSql('ALTER TABLE prize_to_user DROP FOREIGN KEY FK_DAE0A5F8BBE43214');
        $this->addSql('ALTER TABLE translation DROP FOREIGN KEY FK_B469456FC54C8C93');
        $this->addSql('ALTER TABLE translation DROP FOREIGN KEY FK_B469456FE559DFD1');
        $this->addSql('DROP TABLE partner');
        $this->addSql('DROP TABLE prize');
        $this->addSql('DROP TABLE prize_to_user');
        $this->addSql('DROP TABLE setting');
        $this->addSql('DROP TABLE translation');
        $this->addSql('DROP TABLE translation_locale');
        $this->addSql('DROP TABLE translation_type');
        $this->addSql('DROP TABLE user');
    }
}
