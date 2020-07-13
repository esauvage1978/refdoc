<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200713141534 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE subscription (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, m_process_id INT DEFAULT NULL, process_id INT DEFAULT NULL, created_at DATETIME NOT NULL, is_enable TINYINT(1) NOT NULL, INDEX IDX_A3C664D3A76ED395 (user_id), INDEX IDX_A3C664D3BB261F69 (m_process_id), INDEX IDX_A3C664D37EC2F574 (process_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE subscription ADD CONSTRAINT FK_A3C664D3A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE subscription ADD CONSTRAINT FK_A3C664D3BB261F69 FOREIGN KEY (m_process_id) REFERENCES mprocess (id)');
        $this->addSql('ALTER TABLE subscription ADD CONSTRAINT FK_A3C664D37EC2F574 FOREIGN KEY (process_id) REFERENCES process (id)');
        $this->addSql('DROP TABLE mpsubscription');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE mpsubscription (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, m_process_id INT DEFAULT NULL, created_at DATETIME NOT NULL, is_enable TINYINT(1) NOT NULL, INDEX IDX_887B588DBB261F69 (m_process_id), INDEX IDX_887B588DA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE mpsubscription ADD CONSTRAINT FK_887B588DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE mpsubscription ADD CONSTRAINT FK_887B588DBB261F69 FOREIGN KEY (m_process_id) REFERENCES mprocess (id)');
        $this->addSql('DROP TABLE subscription');
    }
}
