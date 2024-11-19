DROP DATABASE IF EXISTS Jamin_b;
CREATE DATABASE Jamin_b;
USE Jamin_b;


-- Create tables
CREATE TABLE Product (
    Id INTEGER PRIMARY KEY,
    Naam VARCHAR(100) NOT NULL,
    Barcode VARCHAR(13) NOT NULL
);

CREATE TABLE Magazijn (
    Id INTEGER PRIMARY KEY,
    ProductId INTEGER NOT NULL,
    VerpakkingsEenheid DECIMAL(5,2) NOT NULL,
    AantalAanwezig INTEGER,
    FOREIGN KEY (ProductId) REFERENCES Product(Id)
);

CREATE TABLE Allergeen (
    Id INTEGER PRIMARY KEY,
    Naam VARCHAR(50) NOT NULL,
    Omschrijving VARCHAR(255) NOT NULL
);

CREATE TABLE ProductPerAllergeen (
    Id INTEGER PRIMARY KEY,
    ProductId INTEGER NOT NULL,
    AllergeenId INTEGER NOT NULL,
    FOREIGN KEY (ProductId) REFERENCES Product(Id),
    FOREIGN KEY (AllergeenId) REFERENCES Allergeen(Id)
);

CREATE TABLE ProductPerLeverancier (
    Id INTEGER PRIMARY KEY,
    LeverancierId INTEGER NOT NULL,
    ProductId INTEGER NOT NULL,
    DatumLevering DATE NOT NULL,
    Aantal INTEGER NOT NULL,
    DatumEerstVolgendeLevering DATE,
    FOREIGN KEY (ProductId) REFERENCES Product(Id)
);

-- Insert sample data
INSERT INTO Product (Id, Naam, Barcode) VALUES 
(1, 'Mintnopjes', '8719587231278'),
(2, 'Schoolkrijt', '8719587326713'),
(3, 'Honingdrop', '8719587327836'),
(4, 'Zure Beren', '8719587321441'),
(5, 'Cola Flesjes', '8719587321237'),
(6, 'Turtles', '8719587322245'),
(7, 'Witte Muizen', '8719587328256'),
(8, 'Reuzen Slangen', '8719587325641'),
(9, 'Zoute Rijen', '8719587322739'),
(10, 'Winegums', '8719587327527'),
(11, 'Drop Munten', '8719587322345'),
(12, 'Kruis Drop', '8719587322265'),
(13, 'Zoute Ruitjes', '8719587323256');

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

-- Create Leverancier table
CREATE TABLE Leverancier (
    Id INTEGER PRIMARY KEY,
    Naam VARCHAR(100) NOT NULL,
    ContactPersoon VARCHAR(100) NOT NULL,
    LeverancierNummer VARCHAR(11) NOT NULL,
    Mobiel VARCHAR(11) NOT NULL
);

-- Insert Leverancier data
INSERT INTO Leverancier (Id, Naam, ContactPersoon, LeverancierNummer, Mobiel) VALUES
(1, 'Venco', 'Bert van Linge', 'L1029384719', '06-28493827'),
(2, 'Astra Sweets', 'Jasper del Monte', 'L1029284315', '06-39398734'),
(3, 'Haribo', 'Sven Stalman', 'L1029324748', '06-24383291'),
(4, 'Basset', 'Joyce Stelterberg', 'L1023845773', '06-48293823'),
(5, 'De Bron', 'Remco Veenstra', 'L1023857736', '06-34291234'),
(6, 'Quality Street', 'Johan Nooij', 'L1029234586', '06-23458456');

-- Add foreign key constraint to ProductPerLeverancier table
ALTER TABLE ProductPerLeverancier
ADD CONSTRAINT FK_ProductPerLeverancier_Leverancier
FOREIGN KEY (LeverancierId) REFERENCES Leverancier(Id);