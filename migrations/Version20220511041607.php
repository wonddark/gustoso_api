<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220511041607 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comment ADD replying_to_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CCDC1BC7C FOREIGN KEY (replying_to_id) REFERENCES comment (id)');
        $this->addSql('CREATE INDEX IDX_9474526CCDC1BC7C ON comment (replying_to_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526CCDC1BC7C');
        $this->addSql('DROP INDEX IDX_9474526CCDC1BC7C ON comment');
        $this->addSql('ALTER TABLE comment DROP replying_to_id');
    }
}
