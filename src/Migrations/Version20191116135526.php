<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191116135526 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE questions_tags (questions_id INT NOT NULL, tags_id INT NOT NULL, INDEX IDX_721C3074BCB134CE (questions_id), INDEX IDX_721C30748D7B4FB4 (tags_id), PRIMARY KEY(questions_id, tags_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE questions_tags ADD CONSTRAINT FK_721C3074BCB134CE FOREIGN KEY (questions_id) REFERENCES questions (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE questions_tags ADD CONSTRAINT FK_721C30748D7B4FB4 FOREIGN KEY (tags_id) REFERENCES tags (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE tags_questions');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE tags_questions (tags_id INT NOT NULL, questions_id INT NOT NULL, INDEX IDX_EEDD6A898D7B4FB4 (tags_id), INDEX IDX_EEDD6A89BCB134CE (questions_id), PRIMARY KEY(tags_id, questions_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE tags_questions ADD CONSTRAINT FK_EEDD6A898D7B4FB4 FOREIGN KEY (tags_id) REFERENCES tags (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tags_questions ADD CONSTRAINT FK_EEDD6A89BCB134CE FOREIGN KEY (questions_id) REFERENCES questions (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE questions_tags');
    }
}
