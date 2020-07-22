<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191113171702 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE tags_questions (tags_id INT NOT NULL, questions_id INT NOT NULL, INDEX IDX_EEDD6A898D7B4FB4 (tags_id), INDEX IDX_EEDD6A89BCB134CE (questions_id), PRIMARY KEY(tags_id, questions_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE tags_questions ADD CONSTRAINT FK_EEDD6A898D7B4FB4 FOREIGN KEY (tags_id) REFERENCES tags (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tags_questions ADD CONSTRAINT FK_EEDD6A89BCB134CE FOREIGN KEY (questions_id) REFERENCES questions (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE questions ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE questions ADD CONSTRAINT FK_8ADC54D5A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_8ADC54D5A76ED395 ON questions (user_id)');
        $this->addSql('ALTER TABLE responses ADD user_id INT DEFAULT NULL, ADD question_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE responses ADD CONSTRAINT FK_315F9F94A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE responses ADD CONSTRAINT FK_315F9F941E27F6BF FOREIGN KEY (question_id) REFERENCES questions (id)');
        $this->addSql('CREATE INDEX IDX_315F9F94A76ED395 ON responses (user_id)');
        $this->addSql('CREATE INDEX IDX_315F9F941E27F6BF ON responses (question_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE tags_questions');
        $this->addSql('ALTER TABLE questions DROP FOREIGN KEY FK_8ADC54D5A76ED395');
        $this->addSql('DROP INDEX IDX_8ADC54D5A76ED395 ON questions');
        $this->addSql('ALTER TABLE questions DROP user_id');
        $this->addSql('ALTER TABLE responses DROP FOREIGN KEY FK_315F9F94A76ED395');
        $this->addSql('ALTER TABLE responses DROP FOREIGN KEY FK_315F9F941E27F6BF');
        $this->addSql('DROP INDEX IDX_315F9F94A76ED395 ON responses');
        $this->addSql('DROP INDEX IDX_315F9F941E27F6BF ON responses');
        $this->addSql('ALTER TABLE responses DROP user_id, DROP question_id');
    }
}
