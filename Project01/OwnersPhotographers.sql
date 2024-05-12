CREATE TABLE OwnersPhotographers (
    OwnerPhotographerID INT PRIMARY KEY,
    Name VARCHAR(50) NOT NULL,
    Email VARCHAR(50) NOT NULL UNIQUE,
    PhoneNumber VARCHAR(15) NOT NULL,
    NICNumber VARCHAR(15) NOT NULL UNIQUE,
    AdminID INT,
    FOREIGN KEY (AdminID) REFERENCES Admins(AdminID)
);