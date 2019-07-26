<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190724223132 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE responsable DROP FOREIGN KEY FK_52520D07CCF9E01E');
        $this->addSql('DROP INDEX UNIQ_52520D07CCF9E01E ON responsable');
        $this->addSql('ALTER TABLE responsable DROP departement_id');
        $this->addSql('ALTER TABLE departement ADD responsable_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE departement ADD CONSTRAINT FK_C1765B6353C59D72 FOREIGN KEY (responsable_id) REFERENCES responsable (id)');
        $this->addSql('CREATE INDEX IDX_C1765B6353C59D72 ON departement (responsable_id)');
        $this->addSql('ALTER TABLE contact ADD departement_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE contact ADD CONSTRAINT FK_4C62E638CCF9E01E FOREIGN KEY (departement_id) REFERENCES departement (id)');
        $this->addSql('CREATE INDEX IDX_4C62E638CCF9E01E ON contact (departement_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE contact DROP FOREIGN KEY FK_4C62E638CCF9E01E');
        $this->addSql('DROP INDEX IDX_4C62E638CCF9E01E ON contact');
        $this->addSql('ALTER TABLE contact DROP departement_id');
        $this->addSql('ALTER TABLE departement DROP FOREIGN KEY FK_C1765B6353C59D72');
        $this->addSql('DROP INDEX IDX_C1765B6353C59D72 ON departement');
        $this->addSql('ALTER TABLE departement DROP responsable_id');
        $this->addSql('ALTER TABLE responsable ADD departement_id INT NOT NULL');
        $this->addSql('ALTER TABLE responsable ADD CONSTRAINT FK_52520D07CCF9E01E FOREIGN KEY (departement_id) REFERENCES departement (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_52520D07CCF9E01E ON responsable (departement_id)');
    }
}
