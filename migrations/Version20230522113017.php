<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230522113017 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE forms_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE questions_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE reponses_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE types_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE values_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE forms (id INT NOT NULL, question_id INT NOT NULL, sended_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, email VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_FD3F1BF71E27F6BF ON forms (question_id)');
        $this->addSql('COMMENT ON COLUMN forms.sended_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE questions (id INT NOT NULL, parent_id INT DEFAULT NULL, type_id INT NOT NULL, value_id INT NOT NULL, category VARCHAR(50) NOT NULL, subject VARCHAR(255) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, modified_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_8ADC54D5727ACA70 ON questions (parent_id)');
        $this->addSql('CREATE INDEX IDX_8ADC54D5C54C8C93 ON questions (type_id)');
        $this->addSql('CREATE INDEX IDX_8ADC54D5F920BBA2 ON questions (value_id)');
        $this->addSql('COMMENT ON COLUMN questions.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN questions.modified_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE reponses (id INT NOT NULL, form_id INT NOT NULL, submit_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_1E512EC65FF69B7D ON reponses (form_id)');
        $this->addSql('COMMENT ON COLUMN reponses.submit_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE types (id INT NOT NULL, type VARCHAR(50) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE values (id INT NOT NULL, parent_id INT DEFAULT NULL, value VARCHAR(50) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_3AA74CE6727ACA70 ON values (parent_id)');
        $this->addSql('ALTER TABLE forms ADD CONSTRAINT FK_FD3F1BF71E27F6BF FOREIGN KEY (question_id) REFERENCES questions (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE questions ADD CONSTRAINT FK_8ADC54D5727ACA70 FOREIGN KEY (parent_id) REFERENCES questions (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE questions ADD CONSTRAINT FK_8ADC54D5C54C8C93 FOREIGN KEY (type_id) REFERENCES types (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE questions ADD CONSTRAINT FK_8ADC54D5F920BBA2 FOREIGN KEY (value_id) REFERENCES values (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE reponses ADD CONSTRAINT FK_1E512EC65FF69B7D FOREIGN KEY (form_id) REFERENCES forms (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE values ADD CONSTRAINT FK_3AA74CE6727ACA70 FOREIGN KEY (parent_id) REFERENCES values (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE forms_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE questions_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE reponses_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE types_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE values_id_seq CASCADE');
        $this->addSql('ALTER TABLE forms DROP CONSTRAINT FK_FD3F1BF71E27F6BF');
        $this->addSql('ALTER TABLE questions DROP CONSTRAINT FK_8ADC54D5727ACA70');
        $this->addSql('ALTER TABLE questions DROP CONSTRAINT FK_8ADC54D5C54C8C93');
        $this->addSql('ALTER TABLE questions DROP CONSTRAINT FK_8ADC54D5F920BBA2');
        $this->addSql('ALTER TABLE reponses DROP CONSTRAINT FK_1E512EC65FF69B7D');
        $this->addSql('ALTER TABLE values DROP CONSTRAINT FK_3AA74CE6727ACA70');
        $this->addSql('DROP TABLE forms');
        $this->addSql('DROP TABLE questions');
        $this->addSql('DROP TABLE reponses');
        $this->addSql('DROP TABLE types');
        $this->addSql('DROP TABLE values');
    }
}
