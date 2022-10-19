<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221019202634 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE book_lend_book DROP CONSTRAINT fk_cef580441125faca');
        $this->addSql('ALTER TABLE book_lend_book DROP CONSTRAINT fk_cef5804416a2b381');
        $this->addSql('DROP TABLE book_lend_book');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE TABLE book_lend_book (book_lend_id INT NOT NULL, book_id INT NOT NULL, PRIMARY KEY(book_lend_id, book_id))');
        $this->addSql('CREATE INDEX idx_cef5804416a2b381 ON book_lend_book (book_id)');
        $this->addSql('CREATE INDEX idx_cef580441125faca ON book_lend_book (book_lend_id)');
        $this->addSql('ALTER TABLE book_lend_book ADD CONSTRAINT fk_cef580441125faca FOREIGN KEY (book_lend_id) REFERENCES book_lend (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE book_lend_book ADD CONSTRAINT fk_cef5804416a2b381 FOREIGN KEY (book_id) REFERENCES book (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }
}
