<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191116105509 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE questions DROP FOREIGN KEY FK_8ADC54D5A76ED395');
        $this->addSql('ALTER TABLE questions ADD CONSTRAINT FK_8ADC54D5A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE responses DROP FOREIGN KEY FK_315F9F94A76ED395');
        $this->addSql('ALTER TABLE responses ADD is_best TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE responses ADD CONSTRAINT FK_315F9F94A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE questions DROP FOREIGN KEY FK_8ADC54D5A76ED395');
        $this->addSql('ALTER TABLE questions ADD CONSTRAINT FK_8ADC54D5A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE responses DROP FOREIGN KEY FK_315F9F94A76ED395');
        $this->addSql('ALTER TABLE responses DROP is_best');
        $this->addSql('ALTER TABLE responses ADD CONSTRAINT FK_315F9F94A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
    }
}
