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
 