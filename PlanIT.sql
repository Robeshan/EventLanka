CREATE DATABASE PlanIT;

USE PlanIT;


CREATE TABLE Users (
    UserID INT PRIMARY KEY,
    Username VARCHAR(50) NOT NULL,
    Email VARCHAR(50) NOT NULL UNIQUE,
    PhoneNumber VARCHAR(15) NOT NULL,
    NICNumber VARCHAR(15) NOT NULL UNIQUE,
    Password VARCHAR(50) NOT NULL,
    ConfirmPassword VARCHAR(50) NOT NULL,
    NICPhotos BLOB,
    UserType VARCHAR(10) NOT NULL
);


CREATE TABLE EventTypes (
    EventTypeID INT PRIMARY KEY,
    EventTypeName VARCHAR(50) NOT NULL,
    EventTypeDescription TEXT
);


CREATE TABLE Events (
    EventID INT PRIMARY KEY,
    EventType VARCHAR(50) NOT NULL,
    EventName VARCHAR(50) NOT NULL,
    EventDescription TEXT,
    Venue VARCHAR(100) NOT NULL
);


CREATE TABLE Services (
    ServiceID INT PRIMARY KEY,
    ServiceName VARCHAR(50) NOT NULL,
    ServiceDescription TEXT
);


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


CREATE TABLE Feedback (
    FeedbackID INT PRIMARY KEY,
    UserID INT,
    EventID INT,
    FeedbackText TEXT,
    Rating INT NOT NULL,
    FOREIGN KEY (UserID) REFERENCES Users(UserID),
    FOREIGN KEY (EventID) REFERENCES Events(EventID)
);


CREATE TABLE Admins (
    AdminID INT PRIMARY KEY,
    Username VARCHAR(50) NOT NULL,
    Email VARCHAR(50) NOT NULL UNIQUE,
    Password VARCHAR(50) NOT NULL,
    NICNumber VARCHAR(15) NOT NULL UNIQUE
);


CREATE TABLE OwnersPhotographers (
    OwnerPhotographerID INT PRIMARY KEY,
    Name VARCHAR(50) NOT NULL,
    Email VARCHAR(50) NOT NULL UNIQUE,
    PhoneNumber VARCHAR(15) NOT NULL,
    NICNumber VARCHAR(15) NOT NULL UNIQUE,
    AdminID INT,
    FOREIGN KEY (AdminID) REFERENCES Admins(AdminID)
);