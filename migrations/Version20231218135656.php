<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231218135656 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE candidacy (id INT AUTO_INCREMENT NOT NULL, person_id INT DEFAULT NULL, vote_id INT DEFAULT NULL, program LONGTEXT DEFAULT NULL, pub_date DATETIME DEFAULT NULL, INDEX IDX_D930569D217BBB47 (person_id), INDEX IDX_D930569D72DCDAFC (vote_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE person (id INT AUTO_INCREMENT NOT NULL, owner_id INT DEFAULT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, middlename VARCHAR(255) DEFAULT NULL, address VARCHAR(255) DEFAULT NULL, barrau VARCHAR(20) NOT NULL, UNIQUE INDEX UNIQ_34DCD1767E3C61F9 (owner_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, person_id INT DEFAULT NULL, username VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, otp VARCHAR(10) DEFAULT NULL, created_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_8D93D649217BBB47 (person_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_connection (id INT AUTO_INCREMENT NOT NULL, owner_id INT DEFAULT NULL, reason VARCHAR(255) DEFAULT NULL, connexion_date DATETIME DEFAULT NULL, suspect TINYINT(1) DEFAULT NULL, INDEX IDX_8E90B58A7E3C61F9 (owner_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_vote (id INT AUTO_INCREMENT NOT NULL, voter_id INT DEFAULT NULL, vote_id INT DEFAULT NULL, candidate_id INT DEFAULT NULL, vote_date DATETIME NOT NULL, INDEX IDX_2091C9ADEBB4B8AD (voter_id), INDEX IDX_2091C9AD72DCDAFC (vote_id), INDEX IDX_2091C9AD91BD8781 (candidate_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vote (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) NOT NULL, requirements LONGTEXT DEFAULT NULL, start_date DATETIME NOT NULL, end_date DATETIME NOT NULL, visible TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE candidacy ADD CONSTRAINT FK_D930569D217BBB47 FOREIGN KEY (person_id) REFERENCES person (id)');
        $this->addSql('ALTER TABLE candidacy ADD CONSTRAINT FK_D930569D72DCDAFC FOREIGN KEY (vote_id) REFERENCES vote (id)');
        $this->addSql('ALTER TABLE person ADD CONSTRAINT FK_34DCD1767E3C61F9 FOREIGN KEY (owner_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE `user` ADD CONSTRAINT FK_8D93D649217BBB47 FOREIGN KEY (person_id) REFERENCES person (id)');
        $this->addSql('ALTER TABLE user_connection ADD CONSTRAINT FK_8E90B58A7E3C61F9 FOREIGN KEY (owner_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE user_vote ADD CONSTRAINT FK_2091C9ADEBB4B8AD FOREIGN KEY (voter_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE user_vote ADD CONSTRAINT FK_2091C9AD72DCDAFC FOREIGN KEY (vote_id) REFERENCES vote (id)');
        $this->addSql('ALTER TABLE user_vote ADD CONSTRAINT FK_2091C9AD91BD8781 FOREIGN KEY (candidate_id) REFERENCES candidacy (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE candidacy DROP FOREIGN KEY FK_D930569D217BBB47');
        $this->addSql('ALTER TABLE candidacy DROP FOREIGN KEY FK_D930569D72DCDAFC');
        $this->addSql('ALTER TABLE person DROP FOREIGN KEY FK_34DCD1767E3C61F9');
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D649217BBB47');
        $this->addSql('ALTER TABLE user_connection DROP FOREIGN KEY FK_8E90B58A7E3C61F9');
        $this->addSql('ALTER TABLE user_vote DROP FOREIGN KEY FK_2091C9ADEBB4B8AD');
        $this->addSql('ALTER TABLE user_vote DROP FOREIGN KEY FK_2091C9AD72DCDAFC');
        $this->addSql('ALTER TABLE user_vote DROP FOREIGN KEY FK_2091C9AD91BD8781');
        $this->addSql('DROP TABLE candidacy');
        $this->addSql('DROP TABLE person');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE user_connection');
        $this->addSql('DROP TABLE user_vote');
        $this->addSql('DROP TABLE vote');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
