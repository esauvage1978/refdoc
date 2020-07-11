<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200711074315 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE mprocessus (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, is_enable TINYINT(1) NOT NULL, content LONGTEXT DEFAULT NULL, ref VARCHAR(5) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mprocessusvalidators_user (mprocessus_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_4ED4911F98281311 (mprocessus_id), INDEX IDX_4ED4911FA76ED395 (user_id), PRIMARY KEY(mprocessus_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mprocessuscontributors_user (mprocessus_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_64F093B98281311 (mprocessus_id), INDEX IDX_64F093BA76ED395 (user_id), PRIMARY KEY(mprocessus_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mpsubscription (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, m_processus_id INT DEFAULT NULL, created_at DATETIME NOT NULL, is_enable TINYINT(1) NOT NULL, INDEX IDX_887B588DA76ED395 (user_id), INDEX IDX_887B588D1AE58B42 (m_processus_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE mprocessusvalidators_user ADD CONSTRAINT FK_4ED4911F98281311 FOREIGN KEY (mprocessus_id) REFERENCES mprocessus (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE mprocessusvalidators_user ADD CONSTRAINT FK_4ED4911FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE mprocessuscontributors_user ADD CONSTRAINT FK_64F093B98281311 FOREIGN KEY (mprocessus_id) REFERENCES mprocessus (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE mprocessuscontributors_user ADD CONSTRAINT FK_64F093BA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE mpsubscription ADD CONSTRAINT FK_887B588DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE mpsubscription ADD CONSTRAINT FK_887B588D1AE58B42 FOREIGN KEY (m_processus_id) REFERENCES mprocessus (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE mprocessusvalidators_user DROP FOREIGN KEY FK_4ED4911F98281311');
        $this->addSql('ALTER TABLE mprocessuscontributors_user DROP FOREIGN KEY FK_64F093B98281311');
        $this->addSql('ALTER TABLE mpsubscription DROP FOREIGN KEY FK_887B588D1AE58B42');
        $this->addSql('DROP TABLE mprocessus');
        $this->addSql('DROP TABLE mprocessusvalidators_user');
        $this->addSql('DROP TABLE mprocessuscontributors_user');
        $this->addSql('DROP TABLE mpsubscription');
    }
}
