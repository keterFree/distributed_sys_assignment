-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 22, 2024 at 09:30 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET NAMES utf8mb4;
SET time_zone = "+00:00";

-- Database: `ds_userdb`

-- --------------------------------------------------------

-- Table structure for table `reset`

CREATE TABLE `reset` (
  `rUID` varchar(20) NOT NULL PRIMARY KEY,
  `token` varchar(100) NOT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

-- Table structure for table `users`

CREATE TABLE `users` (
  `UID` varchar(20) NOT NULL PRIMARY KEY,
  `Username` varchar(10) NOT NULL UNIQUE,
  `email` varchar(30) NOT NULL,
  `password` varchar(100) NOT NULL,
  `Name` varchar(255) NOT NULL, -- Adjust length as needed
  `mobile` varchar(15) NOT NULL,
  `address` varchar(255) NOT NULL  -- Adjust length as needed
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

