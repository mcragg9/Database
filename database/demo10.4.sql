-- Demo for 10/04 Lecture


-- Perform a join
-- SELECT reports.IncidentDate, users.LastName, users.FirstName
-- FROM reports
-- JOIN users ON reports.CreatedBy = users.user_id;

-- Perform a inner join (multiple)
SELECT FirstName, LastName, CreatedDate, impact.ImpactPhrase
FROM reports AS r
	INNER JOIN users
    ON r.CreatedBy = users.user_id
    ON r.ModifiedBy = users.user_id
    INNER JOIN impact
    ON r.impact_id = impact.impact_id;



-- Performs an insert to users
-- INSERT INTO users (LastName, FirstName, Rights, Status, DateAdded, hashed_password)
-- VALUES
-- ('Stuck As', 'Matthew', 'Input','Active','2023-10-03','LamePassword');

-- Performs an update to user names
-- UPDATE users 
-- SET LastName = 'Also'
-- WHERE user_id = 3;

-- Performs a delete row of a user
-- DELETE FROM users
-- WHERE user_id = 4;
