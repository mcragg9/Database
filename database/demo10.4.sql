-- Demo for 10/04 Lecture

SELECT reports.IncidentDate, reports.createdby, users.FirstName, users.LastName
FROM reports
JOIN users ON reports.CreatedBy = users.user_id;