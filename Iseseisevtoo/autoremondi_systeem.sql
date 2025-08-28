-- Autoremondi süsteemi andmebaas
CREATE DATABASE IF NOT EXISTS autoremondi_systeem CHARACTER SET utf8mb4 COLLATE utf8mb4_estonian_ci;
USE autoremondi_systeem;

-- Kasutajate tabel (admin ja tavakasutajad)
CREATE TABLE kasutajad (
    id INT PRIMARY KEY AUTO_INCREMENT,
    kasutajanimi VARCHAR(50) NOT NULL UNIQUE,
    parool_hash VARCHAR(255) NOT NULL,
    eesnimi VARCHAR(50) NOT NULL,
    perekonnanimi VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    roll ENUM('admin', 'tavakasutaja') DEFAULT 'tavakasutaja',
    loomise_aeg TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    meeldetuletus_token VARCHAR(64) DEFAULT NULL,
    meeldetuletus_aeg DATETIME DEFAULT NULL
);

-- Klientide tabel
CREATE TABLE kliendid (
    id INT PRIMARY KEY AUTO_INCREMENT,
    eesnimi VARCHAR(50) NOT NULL,
    perekonnanimi VARCHAR(50) NOT NULL,
    isikukood VARCHAR(11) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL,
    telefon VARCHAR(20),
    registreerimise_aeg TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Teenuste tabel
CREATE TABLE teenused (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nimetus VARCHAR(100) NOT NULL,
    kirjeldus TEXT,
    kestus_minutites INT NOT NULL, -- minutites
    hind DECIMAL(10,2) NOT NULL,
    aktiivne BOOLEAN DEFAULT TRUE
);

-- Töökohtade tabel
CREATE TABLE tookohad (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nimetus VARCHAR(50) NOT NULL,
    kirjeldus TEXT,
    aktiivne BOOLEAN DEFAULT TRUE
);

-- Broneeringute tabel
CREATE TABLE broneeringud (
    id INT PRIMARY KEY AUTO_INCREMENT,
    klient_id INT NOT NULL,
    teenus_id INT NOT NULL,
    tookoht_id INT NOT NULL,
    algus_aeg DATETIME NOT NULL,
    lopp_aeg DATETIME NOT NULL,
    staatus ENUM('broneeritud', 'tehtud', 'tyhistatud') DEFAULT 'broneeritud',
    loomise_aeg TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (klient_id) REFERENCES kliendid(id) ON DELETE CASCADE,
    FOREIGN KEY (teenus_id) REFERENCES teenused(id) ON DELETE CASCADE,
    FOREIGN KEY (tookoht_id) REFERENCES tookohad(id) ON DELETE CASCADE
);

-- Broneeringute muutmise ajalugu
CREATE TABLE broneeringu_ajalugu (
    id INT PRIMARY KEY AUTO_INCREMENT,
    broneering_id INT NOT NULL,
    muutja_id INT NOT NULL,
    muudatuse_tyyp ENUM('loomine', 'muutmine', 'tyhistamine'),
    vanad_andmed TEXT,
    uued_andmed TEXT,
    muutmise_aeg TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (broneering_id) REFERENCES broneeringud(id) ON DELETE CASCADE,
    FOREIGN KEY (muutja_id) REFERENCES kasutajad(id) ON DELETE CASCADE
);

-- Näidismääramine
INSERT INTO kasutajad (kasutajanimi, parool_hash, eesnimi, perekonnanimi, email, roll) VALUES 
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Admin', 'Administraator', 'admin@autoremond.ee', 'admin'),
('jaan', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Jaan', 'Tamm', 'jaan@example.ee', 'tavakasutaja');

INSERT INTO kliendid (eesnimi, perekonnanimi, isikukood, email, telefon) VALUES
('Mari', 'Maasikas', '48501234567', 'mari@example.ee', '+3725123456'),
('Peeter', 'Pääsuke', '38605123456', 'peeter@example.ee', '+3725345678');

INSERT INTO teenused (nimetus, kirjeldus, kestus_minutites, hind) VALUES
('Õlivahetus', 'Mootoriõli ja õlifiltri vahetus', 30, 25.00),
('Pidurite hooldus', 'Piduriklotside ja ketaste vahetus', 60, 80.00),
('Diagnostika', 'Sõiduki elektroonilise süsteemi diagnostika', 45, 40.00);

INSERT INTO tookohad (nimetus, kirjeldus) VALUES
('Post 1', 'Esimese korruse post number 1'),
('Post 2', 'Esimese korruse post number 2'),
('Post 3', 'Teise korruse post number 1');

INSERT INTO broneeringud (klient_id, teenus_id, tookoht_id, algus_aeg, lopp_aeg) VALUES
(1, 1, 1, NOW() + INTERVAL 1 DAY, NOW() + INTERVAL 1 DAY + INTERVAL 30 MINUTE),
(2, 3, 2, NOW() + INTERVAL 2 DAY, NOW() + INTERVAL 2 DAY + INTERVAL 45 MINUTE);