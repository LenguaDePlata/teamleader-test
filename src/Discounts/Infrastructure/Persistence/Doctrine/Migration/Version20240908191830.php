<?php

declare(strict_types=1);

namespace App\Discounts\Infrastructure\Persistence\Migration;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240908191830 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE products (_id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, id VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, category INTEGER NOT NULL, price DOUBLE PRECISION NOT NULL)');
        $this->addSql('CREATE INDEX IDX_B3BA5A5ABF396750 ON products (id)');
        $this->addSql('CREATE INDEX IDX_B3BA5A5A64C19C1 ON products (category)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE products');
    }
}
