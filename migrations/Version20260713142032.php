<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260713142032 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE mascota (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(100) NOT NULL, tipo VARCHAR(50) NOT NULL, color VARCHAR(50) NOT NULL, genero VARCHAR(20) NOT NULL, foto VARCHAR(255) NOT NULL, codigo_qr VARCHAR(255) NOT NULL, estado VARCHAR(30) NOT NULL, user_id INT NOT NULL, tarjeta_id_id INT NOT NULL, INDEX IDX_11298D77A76ED395 (user_id), UNIQUE INDEX UNIQ_11298D77F1D4C0C4 (tarjeta_id_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE persona (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(100) NOT NULL, apellido VARCHAR(100) NOT NULL, dni VARCHAR(20) NOT NULL, direccion VARCHAR(255) NOT NULL, telefono VARCHAR(30) NOT NULL, fecha_alta DATETIME NOT NULL, activo TINYINT NOT NULL, UNIQUE INDEX UNIQ_51E5B69B7F8F253B (dni), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE reporte_mascota (id INT AUTO_INCREMENT NOT NULL, tipo_reporte VARCHAR(20) NOT NULL, nombre_mascota VARCHAR(100) NOT NULL, tipo_mascota VARCHAR(50) NOT NULL, color VARCHAR(50) NOT NULL, descripcion LONGTEXT NOT NULL, ubicacion VARCHAR(255) NOT NULL, fecha_reporte DATETIME NOT NULL, persona_reporta VARCHAR(150) NOT NULL, foto VARCHAR(255) DEFAULT NULL, mascota_id INT NOT NULL, INDEX IDX_DE1EBF3BFB60C59E (mascota_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE tarjeta_id (id INT AUTO_INCREMENT NOT NULL, numero_tarjeta VARCHAR(50) NOT NULL, fecha_emision DATETIME NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, persona_id INT NOT NULL, INDEX IDX_8D93D649F5F88DB9 (persona_id), UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE vacuna (id INT AUTO_INCREMENT NOT NULL, tipo_vacuna VARCHAR(100) NOT NULL, fecha_aplicacion DATE NOT NULL, veterinario VARCHAR(100) NOT NULL, mascota_id INT NOT NULL, INDEX IDX_7289F433FB60C59E (mascota_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE mascota ADD CONSTRAINT FK_11298D77A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE mascota ADD CONSTRAINT FK_11298D77F1D4C0C4 FOREIGN KEY (tarjeta_id_id) REFERENCES tarjeta_id (id)');
        $this->addSql('ALTER TABLE reporte_mascota ADD CONSTRAINT FK_DE1EBF3BFB60C59E FOREIGN KEY (mascota_id) REFERENCES mascota (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649F5F88DB9 FOREIGN KEY (persona_id) REFERENCES persona (id)');
        $this->addSql('ALTER TABLE vacuna ADD CONSTRAINT FK_7289F433FB60C59E FOREIGN KEY (mascota_id) REFERENCES mascota (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE mascota DROP FOREIGN KEY FK_11298D77A76ED395');
        $this->addSql('ALTER TABLE mascota DROP FOREIGN KEY FK_11298D77F1D4C0C4');
        $this->addSql('ALTER TABLE reporte_mascota DROP FOREIGN KEY FK_DE1EBF3BFB60C59E');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649F5F88DB9');
        $this->addSql('ALTER TABLE vacuna DROP FOREIGN KEY FK_7289F433FB60C59E');
        $this->addSql('DROP TABLE mascota');
        $this->addSql('DROP TABLE persona');
        $this->addSql('DROP TABLE reporte_mascota');
        $this->addSql('DROP TABLE tarjeta_id');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE vacuna');
    }
}
