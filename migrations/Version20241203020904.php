<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241203020904 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bibliotheque ADD titre_doc VARCHAR(255) NOT NULL, ADD auteur_doc VARCHAR(255) NOT NULL, ADD date_doc DATE NOT NULL, DROP titre_document, DROP auteur_document, DROP description_doc, DROP date_pub');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bibliotheque ADD titre_document VARCHAR(255) NOT NULL, ADD auteur_document VARCHAR(255) NOT NULL, ADD description_doc VARCHAR(255) NOT NULL, ADD date_pub VARCHAR(255) NOT NULL, DROP titre_doc, DROP auteur_doc, DROP date_doc');
    }
}
