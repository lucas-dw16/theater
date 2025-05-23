-- DATABASE AANMAKEN
CREATE DATABASE IF NOT EXISTS theater;
USE theater;

-- 1. TABEL: Gebruiker
CREATE TABLE IF NOT EXISTS Gebruiker (
    Id INT AUTO_INCREMENT PRIMARY KEY,
    Voornaam VARCHAR(50) NOT NULL,
    Tussenvoegsel VARCHAR(10),
    Achternaam VARCHAR(50) NOT NULL,
    Gebruikersnaam VARCHAR(100) NOT NULL UNIQUE, -- e-mailadres
    Wachtwoord VARCHAR(255) NOT NULL,
    IsIngelogd BIT NOT NULL DEFAULT 0,
    Ingelogd DATETIME,
    Uitgelogd DATETIME,
    Isactief BIT NOT NULL DEFAULT 1,
    Opmerking VARCHAR(250),
    Datumaangemaakt DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
    Datumgewijzigd DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6)
);

-- 2. TABEL: Rol
CREATE TABLE IF NOT EXISTS Rol (
    Id INT AUTO_INCREMENT PRIMARY KEY,
    GebruikerId INT NOT NULL UNIQUE,
    Naam VARCHAR(100) NOT NULL,
    Isactief BIT NOT NULL DEFAULT 1,
    Opmerking VARCHAR(250),
    Datumaangemaakt DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
    Datumgewijzigd DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6),
    FOREIGN KEY (GebruikerId) REFERENCES Gebruiker(Id) ON DELETE CASCADE
);

-- 3. TABEL: Contact
CREATE TABLE IF NOT EXISTS Contact (
    Id INT AUTO_INCREMENT PRIMARY KEY,
    GebruikerId INT NOT NULL UNIQUE,
    Email VARCHAR(100) NOT NULL,
    Mobiel VARCHAR(20),
    Isactief BIT NOT NULL DEFAULT 1,
    Opmerking VARCHAR(250),
    Datumaangemaakt DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
    Datumgewijzigd DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6),
    FOREIGN KEY (GebruikerId) REFERENCES Gebruiker(Id) ON DELETE CASCADE
);

-- 4. TABEL: Medewerker
CREATE TABLE IF NOT EXISTS Medewerker (
    Id INT AUTO_INCREMENT PRIMARY KEY,
    GebruikerId INT NOT NULL UNIQUE,
    Nummer MEDIUMINT NOT NULL UNIQUE,
    Medewerkersoort VARCHAR(50) NOT NULL,
    Isactief BIT NOT NULL DEFAULT 1,
    Opmerking VARCHAR(250),
    Datumaangemaakt DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
    Datumgewijzigd DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6),
    FOREIGN KEY (GebruikerId) REFERENCES Gebruiker(Id) ON DELETE CASCADE
);

-- 5. TABEL: Bezoeker
CREATE TABLE IF NOT EXISTS Bezoeker (
    Id INT AUTO_INCREMENT PRIMARY KEY,
    GebruikerId INT NOT NULL UNIQUE,
    Relatienummer MEDIUMINT NOT NULL UNIQUE,
    Isactief BIT NOT NULL DEFAULT 1,
    Opmerking VARCHAR(250),
    Datumaangemaakt DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
    Datumgewijzigd DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6),
    FOREIGN KEY (GebruikerId) REFERENCES Gebruiker(Id) ON DELETE CASCADE
);

-- 6. TABEL: Prijs
CREATE TABLE IF NOT EXISTS Prijs (
    Id INT AUTO_INCREMENT PRIMARY KEY,
    Tarief DECIMAL(6,2) NOT NULL,
    Isactief BIT NOT NULL DEFAULT 1,
    Opmerking VARCHAR(250),
    Datumaangemaakt DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
    Datumgewijzigd DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6)
);

-- 7. TABEL: Voorstelling
CREATE TABLE IF NOT EXISTS Voorstelling (
    Id INT AUTO_INCREMENT PRIMARY KEY,
    MedewerkerId INT NOT NULL,
    Naam VARCHAR(100) NOT NULL,
    Beschrijving TEXT,
    Datum DATE NOT NULL,
    Tijd TIME NOT NULL,
    MaxAantalTickets INT NOT NULL,
    Beschikbaarheid VARCHAR(50) NOT NULL,
    Isactief BIT NOT NULL DEFAULT 1,
    Opmerking VARCHAR(250),
    Datumaangemaakt DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
    Datumgewijzigd DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6),
    FOREIGN KEY (MedewerkerId) REFERENCES Medewerker(Id) ON DELETE CASCADE
);

-- 8. TABEL: Ticket
CREATE TABLE IF NOT EXISTS Ticket (
    Id INT AUTO_INCREMENT PRIMARY KEY,
    BezoekerId INT NOT NULL,
    VoorstellingId INT NOT NULL,
    PrijsId INT NOT NULL,
    Nummer MEDIUMINT NOT NULL UNIQUE,
    Barcode VARCHAR(50) NOT NULL UNIQUE,
    Datum DATE NOT NULL,
    Tijd TIME NOT NULL,
    Status VARCHAR(30) NOT NULL,
    Isactief BIT NOT NULL DEFAULT 1,
    Opmerking VARCHAR(250),
    Datumaangemaakt DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
    Datumgewijzigd DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6),
    FOREIGN KEY (BezoekerId) REFERENCES Bezoeker(Id),
    FOREIGN KEY (VoorstellingId) REFERENCES Voorstelling(Id),
    FOREIGN KEY (PrijsId) REFERENCES Prijs(Id)
);

-- 9. TABEL: Melding
CREATE TABLE IF NOT EXISTS Melding (
    Id INT AUTO_INCREMENT PRIMARY KEY,
    BezoekerId INT,
    MedewerkerId INT,
    Nummer MEDIUMINT NOT NULL UNIQUE,
    Type VARCHAR(30) NOT NULL,
    Bericht TEXT NOT NULL,
    Isactief BIT NOT NULL DEFAULT 1,
    Opmerking VARCHAR(250),
    Datumaangemaakt DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
    Datumgewijzigd DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6),
    FOREIGN KEY (BezoekerId) REFERENCES Bezoeker(Id),
    FOREIGN KEY (MedewerkerId) REFERENCES Medewerker(Id)
);
