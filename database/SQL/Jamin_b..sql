DROP DATABASE IF EXISTS Jamin_b;
CREATE DATABASE Jamin_b;
USE Jamin_b;

-- Create tables
CREATE TABLE Product (
    Id INT AUTO_INCREMENT PRIMARY KEY,
    Naam VARCHAR(100) NOT NULL,
    Barcode VARCHAR(13) NOT NULL,
    IsActief BOOLEAN DEFAULT TRUE
);

CREATE TABLE Magazijn (
    Id INT AUTO_INCREMENT PRIMARY KEY,
    ProductId INT NOT NULL,
    VerpakkingsEenheid DECIMAL(5,2) NOT NULL,
    AantalAanwezig INT,
    LaatsteLevering DATETIME NULL,
    FOREIGN KEY (ProductId) REFERENCES Product(Id)
);

CREATE TABLE Allergeen (
    Id INT AUTO_INCREMENT PRIMARY KEY,
    Naam VARCHAR(50) NOT NULL,
    Omschrijving VARCHAR(255) NOT NULL
);

CREATE TABLE ProductPerAllergeen (
    Id INT AUTO_INCREMENT PRIMARY KEY,
    ProductId INT NOT NULL,
    AllergeenId INT NOT NULL,
    FOREIGN KEY (ProductId) REFERENCES Product(Id),
    FOREIGN KEY (AllergeenId) REFERENCES Allergeen(Id)
);

CREATE TABLE Leverancier (
    Id INT PRIMARY KEY,
    Naam VARCHAR(100) NOT NULL,
    ContactPersoon VARCHAR(100) NOT NULL,
    LeverancierNummer VARCHAR(11) NOT NULL,
    Mobiel VARCHAR(11) NOT NULL,
    ContactId INT NOT NULL,
    FOREIGN KEY (ContactId) REFERENCES Contact(Id)
);

CREATE TABLE Contact (
    Id INT PRIMARY KEY,
    Straat VARCHAR(100) NOT NULL,
    Huisnummer INT NOT NULL,
    Postcode VARCHAR(6) NOT NULL,
    Stad VARCHAR(100) NOT NULL
);

CREATE TABLE ProductPerLeverancier (
    Id INT AUTO_INCREMENT PRIMARY KEY,
    LeverancierId INT NOT NULL,
    ProductId INT NOT NULL,
    DatumLevering DATE NOT NULL,
    Aantal INT NOT NULL,
    DatumEerstVolgendeLevering DATE,
    FOREIGN KEY (ProductId) REFERENCES Product(Id),
    FOREIGN KEY (LeverancierId) REFERENCES Leverancier(Id)
);

-- Insert sample data
INSERT INTO Product (Id, Naam, Barcode, IsActief) VALUES 
(2, 'Schoolkrijt', '8719587326713', TRUE),
(3, 'Honingdrop', '8719587327836', TRUE),
(5, 'Cola Flesjes', '8719587321237', TRUE),
(6, 'Turtles', '8719587322245', TRUE),
(8, 'Reuzen Slangen', '8719587325641', TRUE),
(9, 'Zoute Rijen', '8719587322739', TRUE),
(10, 'Winegums', '8719587327527', FALSE), 
(12, 'Kruis Drop', '8719587322265', TRUE),
(13, 'Zoute Ruitjes', '8719587323256', TRUE);

INSERT INTO Magazijn (Id, ProductId, VerpakkingsEenheid, AantalAanwezig) VALUES
(1, 1, 5, 453),
(2, 2, 2.5, 400),
(3, 3, 5, 1),
(4, 4, 1, 800),
(5, 5, 3, 234),
(6, 6, 2, 345),
(7, 7, 1, 795),
(8, 8, 10, 233),
(9, 9, 2.5, 123),
(10, 10, 3, NULL),
(11, 11, 2, 367),
(12, 12, 1, 467),
(13, 13, 5, 20);

INSERT INTO Allergeen (Id, Naam, Omschrijving) VALUES
(1, 'Gluten', 'Dit product bevat gluten'),
(2, 'Gelatine', 'Dit product bevat gelatine'),
(3, 'AZO-Kleurstof', 'Dit product bevat AZO-kleurstoffen'),
(4, 'Lactose', 'Dit product bevat lactose'),
(5, 'Soja', 'Dit product bevat soja');

INSERT INTO ProductPerAllergeen (Id, ProductId, AllergeenId) VALUES
(1, 1, 2),
(2, 1, 1),
(3, 1, 3),
(4, 3, 4),
(5, 6, 5),
(6, 9, 2),
(7, 9, 5),
(8, 10, 2),
(9, 12, 4),
(10, 13, 1),
(11, 13, 4),
(12, 13, 5);

INSERT INTO Contact (Id, Straat, Huisnummer, Postcode, Stad) VALUES
(1, 'Van Gilslaan', 34, '1045CB', 'Hilvarenbeek'),
(2, 'Den Dolderpad', 2, '1067RC', 'Utrecht'),
(3, 'Fredo Raalteweg', 257, '1236OP', 'Nijmegen'),
(4, 'Bertrand Russellhof', 21, '2034AP', 'Den Haag'),
(5, 'Leon van Bonstraat', 213, '145XC', 'Lunteren'),
(6, 'Bea van Lingenlaan', 234, '2197FG', 'Sint Pancras');

INSERT INTO Leverancier (Id, Naam, ContactPersoon, LeverancierNummer, Mobiel, ContactId) VALUES
(1, 'Venco', 'Bert van Linge', 'L1029384719', '06-28493827', 1),
(2, 'Astra Sweets', 'Jasper del Monte', 'L1029284315', '06-39398734', 2),
(3, 'Haribo', 'Sven Stalman', 'L1029324748', '06-24383291', 3),
(4, 'Basset', 'Joyce Stelterberg', 'L1023845773', '06-48293823', 4),
(5, 'De Bron', 'Remco Veenstra', 'L1023857736', '06-34291234', 5),
(6, 'Quality Street', 'Johan Nooij', 'L1029234586', '06-23458456', 6);

INSERT INTO ProductPerLeverancier (Id, LeverancierId, ProductId, DatumLevering, Aantal, DatumEerstVolgendeLevering) VALUES
(1, 1, 1, '2024-11-09', 23, '2024-11-16'),
(2, 1, 1, '2024-11-18', 21, '2024-11-25'),
(3, 1, 2, '2024-11-09', 12, '2024-11-16'),
(4, 1, 3, '2024-11-10', 11, '2024-11-17'),
(5, 2, 4, '2024-11-14', 16, '2024-11-21'),
(6, 2, 4, '2024-11-21', 23, '2024-11-28'),
(7, 2, 5, '2024-11-14', 45, '2024-11-21'),
(8, 2, 6, '2024-11-14', 30, '2024-11-21'),
(9, 3, 7, '2024-11-12', 12, '2024-11-19'),
(10, 3, 7, '2024-11-19', 23, '2024-11-26'),
(11, 3, 8, '2024-11-10', 12, '2024-11-17'),
(12, 3, 9, '2024-11-11', 1, '2024-11-18'),
(13, 4, 10, '2024-11-16', 24, '2024-11-30'),
(14, 5, 11, '2024-11-10', 47, '2024-11-17'),
(15, 5, 11, '2024-11-19', 60, '2024-11-26'),
(16, 5, 12, '2024-11-11', 45, NULL),
(17, 5, 13, '2024-11-12', 23, NULL);