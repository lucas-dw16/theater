-- ====================================================================
 -- Doel: Maak een nieuwe database voor Fitness
 -- ====================================================================
 
 -- Verwijder oude database indien deze bestaat
 DROP DATABASE IF EXISTS `fitness`;
 
 -- Maak een nieuwe database
 CREATE DATABASE `fitness`;
 
 -- Gebruik de nieuwe database
 USE `fitness`;
 
 -- ====================================================================
 -- Tabel: Gebruiker
 -- ====================================================================
 CREATE TABLE Gebruiker (
     Id                 INT             NOT NULL AUTO_INCREMENT,
     Voornaam           VARCHAR(50)     NOT NULL,
     Tussenvoegsel      VARCHAR(10)     DEFAULT NULL,
     Achternaam         VARCHAR(50)     NOT NULL,
     Gebruikersnaam     VARCHAR(100)    NOT NULL,
     Email              VARCHAR(100)    NOT NULL,
     Wachtwoord         VARCHAR(20)     NOT NULL,
     IsIngelogd         BIT             NOT NULL DEFAULT 0,
     Ingelogd           DATE            NOT NULL,
     Uitgelogd          DATE            NOT NULL,
     IsActief           BIT             NOT NULL DEFAULT 1,
     Opmerking          VARCHAR(250)    DEFAULT NULL,
     DatumAangemaakt    DATETIME(6)     NOT NULL,
     DatumGewijzigd     DATETIME(6)     NOT NULL,
     CONSTRAINT PK_Gebruiker_Id PRIMARY KEY (Id)
 ) ENGINE=InnoDB;
 
 -- ====================================================================
 -- Tabel: Rol
 -- ====================================================================
 CREATE TABLE Rol (
     Id                 INT             NOT NULL AUTO_INCREMENT,
     GebruikerId        INT             NOT NULL,
     Naam               VARCHAR(100)    NOT NULL,
     IsActief           BIT             NOT NULL DEFAULT 1,
     Opmerking          VARCHAR(250)    DEFAULT NULL,
     DatumAangemaakt    DATETIME(6)     NOT NULL,
     DatumGewijzigd     DATETIME(6)     NOT NULL,
     CONSTRAINT PK_Rol_Id PRIMARY KEY (Id),
     CONSTRAINT FK_Rol_Gebruiker FOREIGN KEY (GebruikerId) REFERENCES Gebruiker(Id)
 ) ENGINE=InnoDB;
 
 -- ====================================================================
 -- Tabel: Medewerker
 -- ====================================================================
 CREATE TABLE Medewerker (
     Id                 INT             NOT NULL AUTO_INCREMENT,
     Voornaam           VARCHAR(50)     NOT NULL,
     Tussenvoegsel      VARCHAR(10)     DEFAULT NULL,
     Achternaam         VARCHAR(50)     NOT NULL,
     Nummer             MEDIUMINT       NOT NULL,
     Medewerkersoort    VARCHAR(20)     NOT NULL,
     IsActief           BIT             NOT NULL DEFAULT 1,
     Opmerking          VARCHAR(250)    DEFAULT NULL,
     DatumAangemaakt    DATETIME(6)     NOT NULL,
     DatumGewijzigd     DATETIME(6)     NOT NULL,
     CONSTRAINT PK_Medewerker_Id PRIMARY KEY (Id)
 ) ENGINE=InnoDB;
 
 -- ====================================================================
 -- Tabel: Lid
 -- ====================================================================
 CREATE TABLE Lid (
    Id                 INT             NOT NULL AUTO_INCREMENT,
    Voornaam           VARCHAR(50)     NOT NULL,
    Tussenvoegsel      VARCHAR(10)     DEFAULT NULL,
    Achternaam         VARCHAR(50)     NOT NULL,
    Relatienummer      MEDIUMINT       NOT NULL,
    Mobiel             VARCHAR(20)     NOT NULL,
    Email              VARCHAR(100)    NOT NULL,
    DatumInschrijving  TIMESTAMP       DEFAULT CURRENT_TIMESTAMP,
    IsActief           BIT             NOT NULL DEFAULT 1,
    Opmerking          VARCHAR(250)    DEFAULT NULL,
    DatumAangemaakt    DATETIME(6)     NOT NULL,
    DatumGewijzigd     DATETIME(6)     NOT NULL,
    CONSTRAINT PK_Lid_Id PRIMARY KEY (Id)
) ENGINE=InnoDB;
 
 -- ====================================================================
 -- Tabel: Les
 -- ====================================================================
 CREATE TABLE Les (
     Id                 INT             NOT NULL AUTO_INCREMENT,
     Naam               VARCHAR(50)     NOT NULL,
     Datum              DATE            NOT NULL,
     Tijd               TIME            NOT NULL,
     MinAantalPersonen  TINYINT          NOT NULL,
     MaxAantalPersonen  TINYINT          NOT NULL,
     LesPrijs           DECIMAL(5,2)    NOT NULL,
     Beschikbaarheid    VARCHAR(50)     NOT NULL,
     IsActief           BIT             NOT NULL DEFAULT 1,
     Opmerking          VARCHAR(250)    DEFAULT NULL,
     DatumAangemaakt    DATETIME(6)     NOT NULL,
     DatumGewijzigd     DATETIME(6)     NOT NULL,
     CONSTRAINT PK_Les_Id PRIMARY KEY (Id)
 ) ENGINE=InnoDB;
 
 
 
 -- ====================================================================
 -- Tabel: Reservering
 -- ====================================================================
 CREATE TABLE Reservering (
     Id                 INT             NOT NULL AUTO_INCREMENT,
     Voornaam           VARCHAR(50)     NOT NULL,
     Tussenvoegsel      VARCHAR(10)     DEFAULT NULL,
     Achternaam         VARCHAR(50)     NOT NULL,
     Nummer             MEDIUMINT       NOT NULL,
     Datum              DATE            NOT NULL,
     Tijd               TIME            NOT NULL,
     Reserveringstatus  VARCHAR(20)     NOT NULL,
     IsActief           BIT             NOT NULL DEFAULT 1,
     Opmerking          VARCHAR(250)    DEFAULT NULL,
     DatumAangemaakt    DATETIME(6)     NOT NULL,
     DatumGewijzigd     DATETIME(6)     NOT NULL,
     CONSTRAINT PK_Reservering_Id PRIMARY KEY (Id)
 ) ENGINE=InnoDB;
 
 
 -- ====================================================================
 -- Insert into
 -- ====================================================================
 
 -- Gebruiker
 INSERT INTO Gebruiker (Voornaam, Tussenvoegsel, Achternaam, Gebruikersnaam, Wachtwoord, Ingelogd, Uitgelogd, DatumAangemaakt, DatumGewijzigd) 
 VALUES 
 ('Jan', NULL, 'Jansen', 'jan01', 'wachtwoord', NOW(), NOW(), NOW(), NOW()),
 ('Piet', 'de', 'Vries', 'piet02', 'wachtwoord', NOW(), NOW(), NOW(), NOW()),
 ('Kees', NULL, 'Bakker', 'kees03', 'wachtwoord', NOW(), NOW(), NOW(), NOW()),
 ('Anna', 'van', 'Dijk', 'anna04', 'wachtwoord', NOW(), NOW(), NOW(), NOW()),
 ('Sara', NULL, 'Smit', 'sara05', 'wachtwoord', NOW(), NOW(), NOW(), NOW());
 
 -- Rol
 INSERT INTO Rol (GebruikerId, Naam, DatumAangemaakt, DatumGewijzigd) 
 VALUES 
 (1, 'Admin', NOW(), NOW()),
 (2, 'Lid', NOW(), NOW()),
 (3, 'Trainer', NOW(), NOW()),
 (4, 'Medewerker', NOW(), NOW()),
 (5, 'Lid', NOW(), NOW());
 
 -- Medewerker
 INSERT INTO Medewerker (Voornaam, Tussenvoegsel, Achternaam, Nummer, Medewerkersoort, DatumAangemaakt, DatumGewijzigd) 
 VALUES 
 ('Henk', NULL, 'Peters', 1001, 'Trainer', NOW(), NOW()),
 ('Linda', 'van', 'Bergen', 1002, 'Trainer', NOW(), NOW()),
 ('Tom', NULL, 'Kramer', 1003, 'Receptionist', NOW(), NOW()),
 ('Monique', 'de', 'Waal', 1004, 'Trainer', NOW(), NOW()),
 ('Erik', NULL, 'Vos', 1005, 'Schoonmaker', NOW(), NOW());
 
 -- Lid
INSERT INTO Lid (Voornaam, Tussenvoegsel, Achternaam, Relatienummer, Mobiel, Email, DatumAangemaakt, DatumGewijzigd) 
VALUES 
('Kevin', NULL, 'Hofman', 2001, '0612345678', 'kevin@mail.com', NOW(), NOW()),
('Laura', 'van', 'Kampen', 2002, '0623456789', 'laura@mail.com', NOW(), NOW()),
('Marco', NULL, 'Klaassen', 2003, '0634567890', 'marco@mail.com', NOW(), NOW()),
('Sanne', 'de', 'Boer', 2004, '0645678901', 'sanne@mail.com', NOW(), NOW()),
('Jasper', NULL, 'Meijer', 2005, '0656789012', 'jasper@mail.com', NOW(), NOW());

 
 -- Les
 INSERT INTO Les (Naam, Datum, Tijd, MinAantalPersonen, MaxAantalPersonen, LesPrijs, Beschikbaarheid, DatumAangemaakt, DatumGewijzigd) 
 VALUES 
 ('Yoga', '2025-03-10', '09:00:00', 5, 15, 15.50, 'Beschikbaar', NOW(), NOW()),
 ('Spinning', '2025-03-11', '10:00:00', 6, 20, 12.00, 'Vol', NOW(), NOW()),
 ('Pilates', '2025-03-12', '11:00:00', 4, 10, 10.00, 'Beschikbaar', NOW(), NOW()),
 ('Zumba', '2025-03-13', '12:00:00', 8, 25, 18.00, 'Beschikbaar', NOW(), NOW()),
 ('Kickboksen', '2025-03-14', '13:00:00', 10, 20, 20.00, 'Beschikbaar', NOW(), NOW());
 
 -- Reservering
 INSERT INTO Reservering (Voornaam, Tussenvoegsel, Achternaam, Nummer, Datum, Tijd, Reserveringstatus, DatumAangemaakt, DatumGewijzigd) 
 VALUES 
 ('Kevin', NULL, 'Hofman', 2001, '2025-03-10', '09:00:00', 'Bevestigd', NOW(), NOW()),
 ('Laura', 'van', 'Kampen', 2002, '2025-03-11', '10:00:00', 'Bevestigd', NOW(), NOW()),
 ('Marco', NULL, 'Klaassen', 2003, '2025-03-12', '11:00:00', 'Geannuleerd', NOW(), NOW()),
 ('Sanne', 'de', 'Boer', 2004, '2025-03-13', '12:00:00', 'Bevestigd', NOW(), NOW()),
 ('Jasper', NULL, 'Meijer', 2005, '2025-03-14', '13:00:00', 'Bevestigd', NOW(), NOW());