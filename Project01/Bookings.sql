CREATE TABLE Bookings (
    BookingID INT PRIMARY KEY,
    UserID INT,
    EventID INT,
    ServiceID INT,
    BookingDate DATE NOT NULL,
    AdvancePayment DECIMAL(10, 2) NOT NULL,
    BalancePayment DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (UserID) REFERENCES Users(UserID),
    FOREIGN KEY (EventID) REFERENCES Events(EventID),
    FOREIGN KEY (ServiceID) REFERENCES Services(ServiceID)
);