<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220506212609 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE account CHANGE personal_phone phone VARCHAR(8) DEFAULT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_7D3656A4444F97DD ON account (phone)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_7D3656A4444F97DD ON account');
        $this->addSql('ALTER TABLE account CHANGE phone personal_phone VARCHAR(8) DEFAULT NULL');
    }
}
