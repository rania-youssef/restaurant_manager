<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251219183837 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE dish (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE dish_ingredient (id INT AUTO_INCREMENT NOT NULL, quantity VARCHAR(255) DEFAULT NULL, unit VARCHAR(255) DEFAULT NULL, dish_id INT DEFAULT NULL, ingredient_id INT DEFAULT NULL, INDEX IDX_77196056148EB0CB (dish_id), INDEX IDX_77196056933FE08C (ingredient_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE ingredient (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) DEFAULT NULL, quantity_value VARCHAR(255) DEFAULT NULL, unit VARCHAR(255) DEFAULT NULL, validity VARCHAR(255) DEFAULT NULL, category_id INT DEFAULT NULL, INDEX IDX_6BAF787012469DE2 (category_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE ingredient_category (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE dish_ingredient ADD CONSTRAINT FK_77196056148EB0CB FOREIGN KEY (dish_id) REFERENCES dish (id)');
        $this->addSql('ALTER TABLE dish_ingredient ADD CONSTRAINT FK_77196056933FE08C FOREIGN KEY (ingredient_id) REFERENCES ingredient (id)');
        $this->addSql('ALTER TABLE ingredient ADD CONSTRAINT FK_6BAF787012469DE2 FOREIGN KEY (category_id) REFERENCES ingredient_category (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE dish_ingredient DROP FOREIGN KEY FK_77196056148EB0CB');
        $this->addSql('ALTER TABLE dish_ingredient DROP FOREIGN KEY FK_77196056933FE08C');
        $this->addSql('ALTER TABLE ingredient DROP FOREIGN KEY FK_6BAF787012469DE2');
        $this->addSql('DROP TABLE dish');
        $this->addSql('DROP TABLE dish_ingredient');
        $this->addSql('DROP TABLE ingredient');
        $this->addSql('DROP TABLE ingredient_category');
    }
}
