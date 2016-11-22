<?php

namespace Application\Resources\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161120114707 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE category (id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', name VARCHAR(50) NOT NULL, `label` VARCHAR(50) NOT NULL, deleted TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE feedback (id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', category_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', screenshot LONGTEXT DEFAULT NULL, body LONGTEXT NOT NULL, deleted TINYINT(1) NOT NULL, status VARCHAR(10) NOT NULL, sender_ip VARCHAR(255) NOT NULL, referrer VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_D229445812469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, profile_picture_id INT DEFAULT NULL, first_name VARCHAR(100) NOT NULL, last_name VARCHAR(100) NOT NULL, username VARCHAR(25) NOT NULL, password VARCHAR(64) NOT NULL, salt VARCHAR(32) NOT NULL, email VARCHAR(60) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', is_active TINYINT(1) NOT NULL, phone VARCHAR(50) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, type VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_USERNAME (username), UNIQUE INDEX UNIQ_EMAIL (email), UNIQUE INDEX UNIQ_PROFILEPICTURE (profile_picture_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE profile_picture (id INT AUTO_INCREMENT NOT NULL, profile_picture_name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE student (id INT AUTO_INCREMENT NOT NULL, profile_picture_id INT DEFAULT NULL, grade_class_id INT DEFAULT NULL, email VARCHAR(60) DEFAULT NULL, is_active TINYINT(1) NOT NULL, first_name VARCHAR(50) NOT NULL, last_name VARCHAR(50) NOT NULL, username VARCHAR(101) NOT NULL, number INT NOT NULL, barcode VARCHAR(20) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_B723AF3396901F54 (number), UNIQUE INDEX UNIQ_B723AF3397AE0266 (barcode), INDEX IDX_B723AF33A4FEC5D6 (grade_class_id), UNIQUE INDEX UNIQ_USERNAME (username), UNIQUE INDEX UNIQ_EMAIL (email), UNIQUE INDEX UNIQ_PROFILEPICTURE (profile_picture_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE student_student_parent (student_id INT NOT NULL, student_parent_id INT NOT NULL, INDEX IDX_A45A9A74CB944F1A (student_id), INDEX IDX_A45A9A7415140BF0 (student_parent_id), PRIMARY KEY(student_id, student_parent_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE page (id INT AUTO_INCREMENT NOT NULL, author_id INT DEFAULT NULL, title VARCHAR(100) NOT NULL, slug VARCHAR(100) NOT NULL, body LONGTEXT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, INDEX IDX_140AB620F675F31B (author_id), UNIQUE INDEX UNIQ_SLUG (slug), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE course_content (id INT AUTO_INCREMENT NOT NULL, parent_id INT DEFAULT NULL, name VARCHAR(100) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, INDEX IDX_PARENT (parent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE course_content_teacher (course_content_id INT NOT NULL, teacher_id INT NOT NULL, INDEX IDX_4EB547345B42ED6E (course_content_id), INDEX IDX_4EB5473441807E1D (teacher_id), PRIMARY KEY(course_content_id, teacher_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE course_content_grade (course_content_id INT NOT NULL, grade_id INT NOT NULL, INDEX IDX_7114BE3F5B42ED6E (course_content_id), INDEX IDX_7114BE3FFE19A1A8 (grade_id), PRIMARY KEY(course_content_id, grade_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE course_content_course_titular (course_content_id INT NOT NULL, course_titular_id INT NOT NULL, INDEX IDX_70C538A25B42ED6E (course_content_id), INDEX IDX_70C538A22612B1E7 (course_titular_id), PRIMARY KEY(course_content_id, course_titular_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE grade (id INT AUTO_INCREMENT NOT NULL, grade INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_GRADE (grade), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE grade_class (id INT AUTO_INCREMENT NOT NULL, grade_id INT NOT NULL, titular_id INT DEFAULT NULL, section VARCHAR(30) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, INDEX IDX_F0526BB6FE19A1A8 (grade_id), INDEX IDX_F0526BB6F9F0FF64 (titular_id), UNIQUE INDEX UNIQ_GRADE_CLASS (grade_id, section), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lesson (id INT AUTO_INCREMENT NOT NULL, teacher_id INT NOT NULL, course_content_id INT NOT NULL, start_date DATETIME NOT NULL, end_date DATETIME NOT NULL, room VARCHAR(10) NOT NULL, remarks LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, INDEX IDX_F87474F341807E1D (teacher_id), INDEX IDX_F87474F35B42ED6E (course_content_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lesson_grade (lesson_id INT NOT NULL, grade_id INT NOT NULL, INDEX IDX_13BC7AB3CDF80196 (lesson_id), INDEX IDX_13BC7AB3FE19A1A8 (grade_id), PRIMARY KEY(lesson_id, grade_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE student_registration (id INT AUTO_INCREMENT NOT NULL, student_id INT DEFAULT NULL, lesson_id INT DEFAULT NULL, check_in DATETIME DEFAULT NULL, check_out DATETIME DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, INDEX IDX_FB761610CB944F1A (student_id), INDEX IDX_FB761610CDF80196 (lesson_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE feedback ADD CONSTRAINT FK_D229445812469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE `user` ADD CONSTRAINT FK_8D93D649292E8AE2 FOREIGN KEY (profile_picture_id) REFERENCES profile_picture (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE student ADD CONSTRAINT FK_B723AF33292E8AE2 FOREIGN KEY (profile_picture_id) REFERENCES profile_picture (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE student ADD CONSTRAINT FK_B723AF33A4FEC5D6 FOREIGN KEY (grade_class_id) REFERENCES grade_class (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE student_student_parent ADD CONSTRAINT FK_A45A9A74CB944F1A FOREIGN KEY (student_id) REFERENCES student (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE student_student_parent ADD CONSTRAINT FK_A45A9A7415140BF0 FOREIGN KEY (student_parent_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE page ADD CONSTRAINT FK_140AB620F675F31B FOREIGN KEY (author_id) REFERENCES user (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE course_content ADD CONSTRAINT FK_F6063545727ACA70 FOREIGN KEY (parent_id) REFERENCES course_content (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE course_content_teacher ADD CONSTRAINT FK_4EB547345B42ED6E FOREIGN KEY (course_content_id) REFERENCES course_content (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE course_content_teacher ADD CONSTRAINT FK_4EB5473441807E1D FOREIGN KEY (teacher_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE course_content_grade ADD CONSTRAINT FK_7114BE3F5B42ED6E FOREIGN KEY (course_content_id) REFERENCES course_content (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE course_content_grade ADD CONSTRAINT FK_7114BE3FFE19A1A8 FOREIGN KEY (grade_id) REFERENCES grade (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE course_content_course_titular ADD CONSTRAINT FK_70C538A25B42ED6E FOREIGN KEY (course_content_id) REFERENCES course_content (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE course_content_course_titular ADD CONSTRAINT FK_70C538A22612B1E7 FOREIGN KEY (course_titular_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE grade_class ADD CONSTRAINT FK_F0526BB6FE19A1A8 FOREIGN KEY (grade_id) REFERENCES grade (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE grade_class ADD CONSTRAINT FK_F0526BB6F9F0FF64 FOREIGN KEY (titular_id) REFERENCES user (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE lesson ADD CONSTRAINT FK_F87474F341807E1D FOREIGN KEY (teacher_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE lesson ADD CONSTRAINT FK_F87474F35B42ED6E FOREIGN KEY (course_content_id) REFERENCES course_content (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE lesson_grade ADD CONSTRAINT FK_13BC7AB3CDF80196 FOREIGN KEY (lesson_id) REFERENCES lesson (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE lesson_grade ADD CONSTRAINT FK_13BC7AB3FE19A1A8 FOREIGN KEY (grade_id) REFERENCES grade (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE student_registration ADD CONSTRAINT FK_FB761610CB944F1A FOREIGN KEY (student_id) REFERENCES student (id)');
        $this->addSql('ALTER TABLE student_registration ADD CONSTRAINT FK_FB761610CDF80196 FOREIGN KEY (lesson_id) REFERENCES lesson (id)');

        $this->addSql('INSERT INTO `page` (`id`, `author_id`, `title`, `slug`, `body`, `created_at`, `updated_at`, `deleted_at`) VALUES (\'0\', NULL, \'Accueil\', \'accueil\', \'<h1>Bienvenue !</h1><p>Il faut changer le contenu de la page</p>\', \'2016-11-20 20:51:41\', \'2016-11-20 20:51:41\', NULL)');
        $this->addSql('INSERT INTO `user` (`id`, `profile_picture_id`, `first_name`, `last_name`, `username`, `password`, `salt`, `email`, `roles`, `is_active`, `phone`, `created_at`, `updated_at`, `deleted_at`, `type`) VALUES (\'0\', NULL, \'Cedric\', \'Michaux\', \'superadmin\', \'$2y$13$PCeJTszQd4X0yR3eNU8eruyEBUvh6gwS3eYqkL6xX.KLhCpfDVSfa\', \'2ccae6061d27971118f82a0f0460b767\', \'cedric@arg-das.be\', \'a:1:{i:0;s:16:"ROLE_SUPER_ADMIN";}\', \'1\', \'123456\', \'2016-11-20 20:51:30\', \'2016-11-20 20:51:30\', NULL, \'super_admin\')');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE feedback DROP FOREIGN KEY FK_D229445812469DE2');
        $this->addSql('ALTER TABLE student_student_parent DROP FOREIGN KEY FK_A45A9A7415140BF0');
        $this->addSql('ALTER TABLE page DROP FOREIGN KEY FK_140AB620F675F31B');
        $this->addSql('ALTER TABLE course_content_teacher DROP FOREIGN KEY FK_4EB5473441807E1D');
        $this->addSql('ALTER TABLE course_content_course_titular DROP FOREIGN KEY FK_70C538A22612B1E7');
        $this->addSql('ALTER TABLE grade_class DROP FOREIGN KEY FK_F0526BB6F9F0FF64');
        $this->addSql('ALTER TABLE lesson DROP FOREIGN KEY FK_F87474F341807E1D');
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D649292E8AE2');
        $this->addSql('ALTER TABLE student DROP FOREIGN KEY FK_B723AF33292E8AE2');
        $this->addSql('ALTER TABLE student_student_parent DROP FOREIGN KEY FK_A45A9A74CB944F1A');
        $this->addSql('ALTER TABLE student_registration DROP FOREIGN KEY FK_FB761610CB944F1A');
        $this->addSql('ALTER TABLE course_content DROP FOREIGN KEY FK_F6063545727ACA70');
        $this->addSql('ALTER TABLE course_content_teacher DROP FOREIGN KEY FK_4EB547345B42ED6E');
        $this->addSql('ALTER TABLE course_content_grade DROP FOREIGN KEY FK_7114BE3F5B42ED6E');
        $this->addSql('ALTER TABLE course_content_course_titular DROP FOREIGN KEY FK_70C538A25B42ED6E');
        $this->addSql('ALTER TABLE lesson DROP FOREIGN KEY FK_F87474F35B42ED6E');
        $this->addSql('ALTER TABLE course_content_grade DROP FOREIGN KEY FK_7114BE3FFE19A1A8');
        $this->addSql('ALTER TABLE grade_class DROP FOREIGN KEY FK_F0526BB6FE19A1A8');
        $this->addSql('ALTER TABLE lesson_grade DROP FOREIGN KEY FK_13BC7AB3FE19A1A8');
        $this->addSql('ALTER TABLE student DROP FOREIGN KEY FK_B723AF33A4FEC5D6');
        $this->addSql('ALTER TABLE lesson_grade DROP FOREIGN KEY FK_13BC7AB3CDF80196');
        $this->addSql('ALTER TABLE student_registration DROP FOREIGN KEY FK_FB761610CDF80196');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE feedback');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE profile_picture');
        $this->addSql('DROP TABLE student');
        $this->addSql('DROP TABLE student_student_parent');
        $this->addSql('DROP TABLE page');
        $this->addSql('DROP TABLE course_content');
        $this->addSql('DROP TABLE course_content_teacher');
        $this->addSql('DROP TABLE course_content_grade');
        $this->addSql('DROP TABLE course_content_course_titular');
        $this->addSql('DROP TABLE grade');
        $this->addSql('DROP TABLE grade_class');
        $this->addSql('DROP TABLE lesson');
        $this->addSql('DROP TABLE lesson_grade');
        $this->addSql('DROP TABLE student_registration');
    }
}
