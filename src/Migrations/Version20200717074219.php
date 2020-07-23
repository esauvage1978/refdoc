<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200717074219 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE mprocesspolevalidators_user (mprocess_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_D94568186D8FF7D1 (mprocess_id), INDEX IDX_D9456818A76ED395 (user_id), PRIMARY KEY(mprocess_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mprocessdirvalidators_user (mprocess_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_263B773C6D8FF7D1 (mprocess_id), INDEX IDX_263B773CA76ED395 (user_id), PRIMARY KEY(mprocess_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE mprocesspolevalidators_user ADD CONSTRAINT FK_D94568186D8FF7D1 FOREIGN KEY (mprocess_id) REFERENCES mprocess (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE mprocesspolevalidators_user ADD CONSTRAINT FK_D9456818A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE mprocessdirvalidators_user ADD CONSTRAINT FK_263B773C6D8FF7D1 FOREIGN KEY (mprocess_id) REFERENCES mprocess (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE mprocessdirvalidators_user ADD CONSTRAINT FK_263B773CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE mprocessvalidators_user');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE mprocessvalidators_user (mprocess_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_1E790E576D8FF7D1 (mprocess_id), INDEX IDX_1E790E57A76ED395 (user_id), PRIMARY KEY(mprocess_id, user_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE mprocessvalidators_user ADD CONSTRAINT FK_1E790E576D8FF7D1 FOREIGN KEY (mprocess_id) REFERENCES mprocess (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE mprocessvalidators_user ADD CONSTRAINT FK_1E790E57A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE mprocesspolevalidators_user');
        $this->addSql('DROP TABLE mprocessdirvalidators_user');
    }
}
