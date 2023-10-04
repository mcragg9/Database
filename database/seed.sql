-- Provides data for init tables

-- Insert user data
INSERT INTO users (LastName, FirstName, Rights, Status, DateAdded, hashed_password)
VALUES
('Cragg', 'Matthew', 'Admin','Active','2023-10-03','password'),
('Also', 'Matthew', 'Admin', 'Active', '2023-10-03', '1234'),
('Still', 'Matthew', 'Admin', 'Active', '2023-10-03', '1234a');

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

INSERT INTO reports (IncidentDate, CreatedDate, classification_id, impact_id, location_id, Description, CreatedBy, ModifiedDate, ModifiedBy)
VALUES
('2023-10-01','2023-10-03',1,2,2, 'insert description comment',1,'2023-10-03',2);