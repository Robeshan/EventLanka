<<<<<<< HEAD
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
=======
USE event_planner;

CREATE TABLE event (
  event_id INT PRIMARY KEY,
  event_name VARCHAR(255) NOT NULL,
  event_date DATE NOT NULL,
  no_of_guests INT NOT NULL,
  event_venue VARCHAR(255) NOT NULL,
  event_organizer VARCHAR(255) NOT NULL,
  event_password VARCHAR(255) NOT NULL,
  event_venue_owner VARCHAR(255) NOT NULL,
  event_venue_rating DECIMAL(3,2) NOT NULL,
  event_venue_comments TEXT,
  event_venue_feedback BOOLEAN NOT NULL,
  event_venue_feedback_owner VARCHAR(255) NOT NULL,
  event_venue_feedback_comments TEXT
);

CREATE TABLE service (
  service_id INT PRIMARY KEY,
  service_name VARCHAR(255) NOT NULL,
  service_type VARCHAR(255) NOT NULL,
  service_price DECIMAL(10,2) NOT NULL,
  service_password VARCHAR(255) NOT NULL
);

CREATE TABLE user (
  user_id INT PRIMARY KEY,
  user_name VARCHAR(255) NOT NULL,
  user_password VARCHAR(255) NOT NULL,
  user_nic_number VARCHAR(255) NOT NULL,
  user_contact VARCHAR(255) NOT NULL,
  user_address VARCHAR(255) NOT NULL,
  user_package_id INT NOT NULL,
  user_package_amount DECIMAL(10,2) NOT NULL,
  user_package_advance DECIMAL(10,2) NOT NULL,
  user_package_due DECIMAL(10,2) NOT NULL
);

CREATE TABLE package (
  package_id INT PRIMARY KEY,
  package_type VARCHAR(255) NOT NULL,
  package_amount DECIMAL(10,2) NOT NULL
);

CREATE TABLE photography (
  photography_id INT PRIMARY KEY,
  photography_type VARCHAR(255) NOT NULL,
  photography_price DECIMAL(10,2) NOT NULL
);

CREATE TABLE cosmetics_makeup (
  cosmetics_makeup_id INT PRIMARY KEY,
  cosmetics_makeup_type VARCHAR(255) NOT NULL,
  cosmetics_makeup_price DECIMAL(10,2) NOT NULL
);

CREATE TABLE vehicle (
  vehicle_id INT PRIMARY KEY,
  vehicle_type VARCHAR(255) NOT NULL,
  vehicle_price DECIMAL(10,2) NOT NULL
);

CREATE TABLE catering (
  catering_id INT PRIMARY KEY,
  catering_type VARCHAR(255) NOT NULL,
  catering_price DECIMAL(10,2) NOT NULL
);

\c event_planner;

CREATE TABLE event (
  event_id SERIAL PRIMARY KEY,
  event_name VARCHAR(255) NOT NULL,
  event_date DATE NOT NULL,
  no_of_guests INT NOT NULL,
  event_venue VARCHAR(255) NOT NULL,
  event_organizer VARCHAR(255) NOT NULL,
  event_password VARCHAR(255) NOT NULL,
  event_venue_owner VARCHAR(255) NOT NULL,
 
>>>>>>> e9345cd012dc8f3773c37961a5dcf4128cfd3f20
