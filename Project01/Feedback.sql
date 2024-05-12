CREATE TABLE Feedback (
    FeedbackID INT PRIMARY KEY,
    UserID INT,
    EventID INT,
    FeedbackText TEXT,
    Rating INT NOT NULL,
    FOREIGN KEY (UserID) REFERENCES Users(UserID),
    FOREIGN KEY (EventID) REFERENCES Events(EventID)
);