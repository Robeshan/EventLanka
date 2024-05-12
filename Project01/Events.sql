CREATE TABLE Events (
    EventID INT PRIMARY KEY,
    EventType VARCHAR(50) NOT NULL,
    EventName VARCHAR(50) NOT NULL,
    EventDescription TEXT,
    Venue VARCHAR(100) NOT NULL
);