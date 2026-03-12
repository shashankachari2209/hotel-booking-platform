-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 09, 2025 at 11:24 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hotelbook`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `adminID` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`adminID`, `name`, `email`, `password`) VALUES
(1, 'Super Admin', 'admin@example.com', '$2y$10$OUBUILE6eafJvcS78uSSr.1qjwQec.oyGPcWKlZehZjvjck7dqrNW');

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `bookingID` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `roomID` int(11) NOT NULL,
  `checkInDate` date NOT NULL,
  `checkOutDate` date NOT NULL,
  `status` enum('Confirmed','Cancelled','Pending') DEFAULT 'Pending',
  `paymentID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`bookingID`, `user_id`, `roomID`, `checkInDate`, `checkOutDate`, `status`, `paymentID`) VALUES
(1, 1, 15, '2025-03-18', '2025-03-20', 'Confirmed', 1),
(2, 5, 9, '2025-04-07', '2025-04-09', 'Confirmed', 2),
(3, 5, 7, '2025-04-09', '2025-04-16', 'Confirmed', 3);

-- --------------------------------------------------------

--
-- Table structure for table `hotels`
--

CREATE TABLE `hotels` (
  `hotelID` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `contactInfo` varchar(255) NOT NULL,
  `amenities` text NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hotels`
--

INSERT INTO `hotels` (`hotelID`, `name`, `location`, `description`, `contactInfo`, `amenities`, `image`) VALUES
(1, 'Novotel Pune', 'Hadapsar, Pune, India', 'A 5-star luxury hotel near Magarpatta.', 'contact@novotel.com', 'Free WiFi, Pool, Gym, Spa', 'novotel.jpg'),
(2, 'The Westin Pune', 'Hadapsar, Pune, India', 'A premium hotel with riverside views.', 'contact@westin.com', 'Fine Dining, Free Parking, Bar', 'westin.jpg'),
(3, 'Radisson Blu Pune', 'Hadapsar, Pune, India', 'Comfortable stay with great service.', 'contact@radisson.com', 'Airport Shuttle, Free WiFi, Gym', 'radisson_pune.jpg'),
(4, 'Marriott Hotel', 'New York, USA', 'Luxury hotel in downtown New York.', 'contact@marriott.com', 'Free WiFi, Pool, Gym, Spa', 'marriott.jpg'),
(5, 'Hyatt Regency', 'Los Angeles, USA', 'Elegant hotel with premium services.', 'contact@hyatt.com', 'Free Breakfast, Gym, Parking, Bar', 'hyatt.jpg'),
(6, 'Radisson Blu', 'Dubai, UAE', 'Premium stay in the heart of Dubai.', 'contact@radisson.com', 'Luxury Rooms, Spa, Bar', 'radisson_dubai.jpg'),
(7, 'Hilton Resort', 'Miami, USA', 'A beachfront resort with scenic views.', 'contact@hilton.com', 'Private Beach, Free Parking, Pool', 'hilton.jpg'),
(8, 'Taj Palace', 'Mumbai, India', 'A royal stay experience in Mumbai.', 'contact@tajhotels.com', 'Luxury Spa, Fine Dining, Gym', 'taj.jpg'),
(9, 'Le Meridien', 'Paris, France', 'French luxury in the heart of Paris.', 'contact@lemeridien.com', 'Concierge, Free Parking, Pool', 'lemeridien.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `paymentID` int(11) NOT NULL,
  `bookingID` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `paymentMethod` enum('Credit Card','Debit Card','UPI','Net Banking') NOT NULL,
  `status` enum('Success','Failed','Pending') DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`paymentID`, `bookingID`, `user_id`, `amount`, `paymentMethod`, `status`) VALUES
(1, 1, 1, 20000.00, 'Debit Card', 'Success'),
(2, 2, 5, 14000.00, 'Debit Card', 'Success'),
(3, 3, 5, 12000.00, 'Debit Card', 'Success');

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `roomID` int(11) NOT NULL,
  `hotelID` int(11) NOT NULL,
  `roomType` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `availability` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`roomID`, `hotelID`, `roomType`, `price`, `availability`) VALUES
(1, 1, 'Deluxe Room', 5000.00, 1),
(2, 1, 'Executive Suite', 8500.00, 1),
(3, 2, 'Standard Room', 4500.00, 1),
(4, 2, 'Luxury Suite', 9500.00, 1),
(5, 3, 'Superior Room', 4800.00, 1),
(6, 3, 'Club Suite', 7800.00, 1),
(7, 4, 'Deluxe King', 12000.00, 0),
(8, 4, 'Presidential Suite', 25000.00, 1),
(9, 5, 'Regency Suite', 14000.00, 0),
(10, 5, 'Standard Twin', 9000.00, 1),
(11, 6, 'Business Class Room', 10000.00, 1),
(12, 6, 'Skyline Suite', 19000.00, 1),
(13, 7, 'Ocean View Room', 15000.00, 1),
(14, 7, 'Penthouse Suite', 32000.00, 1),
(15, 8, 'Heritage Suite', 20000.00, 0),
(16, 8, 'Grand Presidential Suite', 45000.00, 1),
(17, 9, 'Classic Parisian Room', 18000.00, 1),
(18, 9, 'Eiffel Tower Suite', 35000.00, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `email`, `phone`, `password`, `status`) VALUES
(1, 'Aishwarya jadhav', 'aishu@gmail.com', '1234567890', '$2y$10$gpKILDUe7oAYZHTcl46uYuRDsFRjsRTQRTyge7wGQpudb7WgQPt.i', 'active'),
(2, 'shashank', 'shashank@gmail.com', '7249249282', '$2y$10$Dn.VdWLC3rqQzOhzk8ugZeFqSbhdRIOHUZHFVejNCUFFlJPG55Gv6', 'active'),
(5, 'aishwarya', 'aishu123@gmail.com', '1234567895', '$2y$10$eAVhOM5KbOyWnIZWpPqFROn/uKrJu1Or8udAv3AFfF8ySQlFwxfcW', 'active');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`adminID`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`bookingID`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `roomID` (`roomID`);

--
-- Indexes for table `hotels`
--
ALTER TABLE `hotels`
  ADD PRIMARY KEY (`hotelID`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`paymentID`),
  ADD KEY `bookingID` (`bookingID`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`roomID`),
  ADD KEY `hotelID` (`hotelID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `phone` (`phone`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `adminID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `bookingID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `hotels`
--
ALTER TABLE `hotels`
  MODIFY `hotelID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `paymentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `roomID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`roomID`) REFERENCES `rooms` (`roomID`) ON DELETE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`bookingID`) REFERENCES `bookings` (`bookingID`) ON DELETE CASCADE,
  ADD CONSTRAINT `payments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `rooms`
--
ALTER TABLE `rooms`
  ADD CONSTRAINT `rooms_ibfk_1` FOREIGN KEY (`hotelID`) REFERENCES `hotels` (`hotelID`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
