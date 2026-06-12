<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260612072450 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE editor (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE game (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, release_date DATETIME NOT NULL, image_name VARCHAR(255) DEFAULT NULL, image_size INT DEFAULT NULL, updated_at DATETIME DEFAULT NULL, editor_id INT DEFAULT NULL, INDEX IDX_232B318C6995AC4C (editor_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE game_genre (game_id INT NOT NULL, genre_id INT NOT NULL, INDEX IDX_B1634A77E48FD905 (game_id), INDEX IDX_B1634A774296D31F (genre_id), PRIMARY KEY (game_id, genre_id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE genre (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE review (id INT AUTO_INCREMENT NOT NULL, review TINYINT NOT NULL, comment LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL, user_id INT NOT NULL, game_id INT NOT NULL, INDEX IDX_794381C6A76ED395 (user_id), INDEX IDX_794381C6E48FD905 (game_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, username VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE wishlist_item (id INT AUTO_INCREMENT NOT NULL, created_at DATETIME NOT NULL, user_id INT NOT NULL, game_id INT NOT NULL, INDEX IDX_6424F4E8A76ED395 (user_id), INDEX IDX_6424F4E8E48FD905 (game_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0E3BD61CE16BA31DBBF396750 (queue_name, available_at, delivered_at, id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318C6995AC4C FOREIGN KEY (editor_id) REFERENCES editor (id)');
        $this->addSql('ALTER TABLE game_genre ADD CONSTRAINT FK_B1634A77E48FD905 FOREIGN KEY (game_id) REFERENCES game (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE game_genre ADD CONSTRAINT FK_B1634A774296D31F FOREIGN KEY (genre_id) REFERENCES genre (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE review ADD CONSTRAINT FK_794381C6A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE review ADD CONSTRAINT FK_794381C6E48FD905 FOREIGN KEY (game_id) REFERENCES game (id)');
        $this->addSql('ALTER TABLE wishlist_item ADD CONSTRAINT FK_6424F4E8A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE wishlist_item ADD CONSTRAINT FK_6424F4E8E48FD905 FOREIGN KEY (game_id) REFERENCES game (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY FK_232B318C6995AC4C');
        $this->addSql('ALTER TABLE game_genre DROP FOREIGN KEY FK_B1634A77E48FD905');
        $this->addSql('ALTER TABLE game_genre DROP FOREIGN KEY FK_B1634A774296D31F');
        $this->addSql('ALTER TABLE review DROP FOREIGN KEY FK_794381C6A76ED395');
        $this->addSql('ALTER TABLE review DROP FOREIGN KEY FK_794381C6E48FD905');
        $this->addSql('ALTER TABLE wishlist_item DROP FOREIGN KEY FK_6424F4E8A76ED395');
        $this->addSql('ALTER TABLE wishlist_item DROP FOREIGN KEY FK_6424F4E8E48FD905');
        $this->addSql('DROP TABLE editor');
        $this->addSql('DROP TABLE game');
        $this->addSql('DROP TABLE game_genre');
        $this->addSql('DROP TABLE genre');
        $this->addSql('DROP TABLE review');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE wishlist_item');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
