-- Provides data for init tables

-- Insert user data
INSERT INTO users (LastName, FirstName, Rights, Status, DateAdded, hashed_password)
VALUES
('Cragg', 'Matthew', 'Admin','Active',10/03/2023,'password'),
('Also', 'Matthew', 'Admin', 'Active', '2023-10-03', '1234'),
('Still', 'Matthew', 'Admin', 'Active', '2023-10-03', '1234');

INSERT INTO classification (ClassificationName)
VALUES
('Severe'),
('Significant'),
('Problem'),
('Noted');

INSERT INTO impact (ImpactPhrase)
VALUES
('Woah'),
('Crap'),
('Not Great'),
('Ehhh, could be worse');

INSERT INTO location (LocationDescription)
VALUES
('Computer Lab'),
('Bottom of the Ocean'),
('PSR J1719-1438b');