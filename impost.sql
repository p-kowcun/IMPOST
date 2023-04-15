-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 10 Kwi 2023, 21:15
-- Wersja serwera: 10.4.24-MariaDB
-- Wersja PHP: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `impost`
--

DELIMITER $$
--
-- Procedury
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `teleport` ()   BEGIN
    SET @parcel_id := 1;
    SET @max_parcel_id := (SELECT MAX(id) FROM parcels);
    
    WHILE @parcel_id <= @max_parcel_id DO
        SET @parcel_route := (SELECT parcels.route FROM parcels WHERE parcels.id = @parcel_id);
        SET @parcel_max_stops := (SELECT routes.stops FROM routes WHERE routes.id = @parcel_route);
        SET @parcel_current_stop := (SELECT parcels.current_stop FROM parcels WHERE parcels.id = @parcel_id);
        
        IF @parcel_current_stop < @parcel_max_stops THEN
            UPDATE parcels SET current_stop = current_stop + 1 WHERE id = @parcel_id;
            SET @parcel_current_stop := @parcel_current_stop + 1;
            PREPARE stmt FROM CONCAT('SELECT route_stops.stop_', @parcel_current_stop, ' INTO @stop_description FROM route_stops WHERE route_stops.id = ', @parcel_route);
            EXECUTE stmt;
            INSERT INTO parcel_history (parcel_code, action_time, description) VALUES ((SELECT code FROM parcels WHERE id = @parcel_id), CURRENT_TIMESTAMP(), @stop_description);
        END IF;
        
        IF (@parcel_current_stop = @parcel_max_stops) AND ((SELECT delivered_at FROM parcels WHERE id = @parcel_id) IS NULL)  THEN
            UPDATE parcels SET delivered_at = CURRENT_TIMESTAMP() WHERE id = @parcel_id;
        END IF;
        
        SET @parcel_id := @parcel_id + 1;
    END WHILE;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `login`
--

CREATE TABLE `login` (
  `login` varchar(255) NOT NULL,
  `password` char(255) NOT NULL,
  `registered_at` datetime NOT NULL,
  `last_seen` datetime NOT NULL,
  `privileges_level` int(2) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `login`
--

INSERT INTO `login` (`login`, `password`, `registered_at`, `last_seen`, `privileges_level`) VALUES
('admin', '$2y$10$APhpwKKKAKmJDLHvjKAO.OYhn1.JnBj/Y7/HLBshz3bfsE/.3Jx1S', '2023-02-13 00:00:00', '2023-04-10 21:08:29', 3);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `parcels`
--

CREATE TABLE `parcels` (
  `id` int(11) NOT NULL,
  `code` char(24) NOT NULL,
  `sent_at` datetime NOT NULL,
  `delivered_at` datetime DEFAULT NULL,
  `current_stop` int(11) NOT NULL,
  `route` int(11) NOT NULL,
  `ordered_by` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `parcel_history`
--

CREATE TABLE `parcel_history` (
  `id` int(11) NOT NULL,
  `parcel_code` char(24) NOT NULL,
  `action_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `routes`
--

CREATE TABLE `routes` (
  `id` int(11) NOT NULL,
  `stops` int(11) NOT NULL,
  `city_start` enum('Szczecin','Koszalin','Słupsk','Gdańsk','Elbląg','Olsztyn','Suwałki','Gorzów Wielkopolski','Piła','Bydgoszcz','Toruń','Ostrołęka','Łomża','Białystok','Włocławek','Ciechanów','Zielona Góra','Poznań','Konin','Skierniewice','Płock','Warszawa','Siedlce','Biała Podlaska','Leszno','Kalisz','Sieradz','Łódź','Radom','Lublin','Chełm','Jelenia Góra','Legnica','Wrocław','Wałbrzych','Opole','Częstochowa','Piotrków Trybunalski','Kielce','Zamość','Katowice','Kraków','Tarnobrzeg','Rzeszów','Tarnów','Bielsko-Biała','Nowy Sącz','Krosno','Przemyśl') NOT NULL,
  `city_end` enum('Szczecin','Koszalin','Słupsk','Gdańsk','Elbląg','Olsztyn','Suwałki','Gorzów Wielkopolski','Piła','Bydgoszcz','Toruń','Ostrołęka','Łomża','Białystok','Włocławek','Ciechanów','Zielona Góra','Poznań','Konin','Skierniewice','Płock','Warszawa','Siedlce','Biała Podlaska','Leszno','Kalisz','Sieradz','Łódź','Radom','Lublin','Chełm','Jelenia Góra','Legnica','Wrocław','Wałbrzych','Opole','Częstochowa','Piotrków Trybunalski','Kielce','Zamość','Katowice','Kraków','Tarnobrzeg','Rzeszów','Tarnów','Bielsko-Biała','Nowy Sącz','Krosno','Przemyśl') NOT NULL,
  `employee` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `route_stops`
--

CREATE TABLE `route_stops` (
  `id` int(11) NOT NULL,
  `stop_1` enum('Szczecin','Koszalin','Słupsk','Gdańsk','Elbląg','Olsztyn','Suwałki','Gorzów Wielkopolski','Piła','Bydgoszcz','Toruń','Ostrołęka','Łomża','Białystok','Włocławek','Ciechanów','Zielona Góra','Poznań','Konin','Skierniewice','Płock','Warszawa','Siedlce','Biała Podlaska','Leszno','Kalisz','Sieradz','Łódź','Radom','Lublin','Chełm','Jelenia Góra','Legnica','Wrocław','Wałbrzych','Opole','Częstochowa','Piotrków Trybunalski','Kielce','Zamość','Katowice','Kraków','Tarnobrzeg','Rzeszów','Tarnów','Bielsko-Biała','Nowy Sącz','Krosno','Przemyśl') DEFAULT NULL,
  `stop_2` enum('Szczecin','Koszalin','Słupsk','Gdańsk','Elbląg','Olsztyn','Suwałki','Gorzów Wielkopolski','Piła','Bydgoszcz','Toruń','Ostrołęka','Łomża','Białystok','Włocławek','Ciechanów','Zielona Góra','Poznań','Konin','Skierniewice','Płock','Warszawa','Siedlce','Biała Podlaska','Leszno','Kalisz','Sieradz','Łódź','Radom','Lublin','Chełm','Jelenia Góra','Legnica','Wrocław','Wałbrzych','Opole','Częstochowa','Piotrków Trybunalski','Kielce','Zamość','Katowice','Kraków','Tarnobrzeg','Rzeszów','Tarnów','Bielsko-Biała','Nowy Sącz','Krosno','Przemyśl') DEFAULT NULL,
  `stop_3` enum('Szczecin','Koszalin','Słupsk','Gdańsk','Elbląg','Olsztyn','Suwałki','Gorzów Wielkopolski','Piła','Bydgoszcz','Toruń','Ostrołęka','Łomża','Białystok','Włocławek','Ciechanów','Zielona Góra','Poznań','Konin','Skierniewice','Płock','Warszawa','Siedlce','Biała Podlaska','Leszno','Kalisz','Sieradz','Łódź','Radom','Lublin','Chełm','Jelenia Góra','Legnica','Wrocław','Wałbrzych','Opole','Częstochowa','Piotrków Trybunalski','Kielce','Zamość','Katowice','Kraków','Tarnobrzeg','Rzeszów','Tarnów','Bielsko-Biała','Nowy Sącz','Krosno','Przemyśl') DEFAULT NULL,
  `stop_4` enum('Szczecin','Koszalin','Słupsk','Gdańsk','Elbląg','Olsztyn','Suwałki','Gorzów Wielkopolski','Piła','Bydgoszcz','Toruń','Ostrołęka','Łomża','Białystok','Włocławek','Ciechanów','Zielona Góra','Poznań','Konin','Skierniewice','Płock','Warszawa','Siedlce','Biała Podlaska','Leszno','Kalisz','Sieradz','Łódź','Radom','Lublin','Chełm','Jelenia Góra','Legnica','Wrocław','Wałbrzych','Opole','Częstochowa','Piotrków Trybunalski','Kielce','Zamość','Katowice','Kraków','Tarnobrzeg','Rzeszów','Tarnów','Bielsko-Biała','Nowy Sącz','Krosno','Przemyśl') DEFAULT NULL,
  `stop_5` enum('Szczecin','Koszalin','Słupsk','Gdańsk','Elbląg','Olsztyn','Suwałki','Gorzów Wielkopolski','Piła','Bydgoszcz','Toruń','Ostrołęka','Łomża','Białystok','Włocławek','Ciechanów','Zielona Góra','Poznań','Konin','Skierniewice','Płock','Warszawa','Siedlce','Biała Podlaska','Leszno','Kalisz','Sieradz','Łódź','Radom','Lublin','Chełm','Jelenia Góra','Legnica','Wrocław','Wałbrzych','Opole','Częstochowa','Piotrków Trybunalski','Kielce','Zamość','Katowice','Kraków','Tarnobrzeg','Rzeszów','Tarnów','Bielsko-Biała','Nowy Sącz','Krosno','Przemyśl') DEFAULT NULL,
  `stop_6` enum('Szczecin','Koszalin','Słupsk','Gdańsk','Elbląg','Olsztyn','Suwałki','Gorzów Wielkopolski','Piła','Bydgoszcz','Toruń','Ostrołęka','Łomża','Białystok','Włocławek','Ciechanów','Zielona Góra','Poznań','Konin','Skierniewice','Płock','Warszawa','Siedlce','Biała Podlaska','Leszno','Kalisz','Sieradz','Łódź','Radom','Lublin','Chełm','Jelenia Góra','Legnica','Wrocław','Wałbrzych','Opole','Częstochowa','Piotrków Trybunalski','Kielce','Zamość','Katowice','Kraków','Tarnobrzeg','Rzeszów','Tarnów','Bielsko-Biała','Nowy Sącz','Krosno','Przemyśl') DEFAULT NULL,
  `stop_7` enum('Szczecin','Koszalin','Słupsk','Gdańsk','Elbląg','Olsztyn','Suwałki','Gorzów Wielkopolski','Piła','Bydgoszcz','Toruń','Ostrołęka','Łomża','Białystok','Włocławek','Ciechanów','Zielona Góra','Poznań','Konin','Skierniewice','Płock','Warszawa','Siedlce','Biała Podlaska','Leszno','Kalisz','Sieradz','Łódź','Radom','Lublin','Chełm','Jelenia Góra','Legnica','Wrocław','Wałbrzych','Opole','Częstochowa','Piotrków Trybunalski','Kielce','Zamość','Katowice','Kraków','Tarnobrzeg','Rzeszów','Tarnów','Bielsko-Biała','Nowy Sącz','Krosno','Przemyśl') DEFAULT NULL,
  `stop_8` enum('Szczecin','Koszalin','Słupsk','Gdańsk','Elbląg','Olsztyn','Suwałki','Gorzów Wielkopolski','Piła','Bydgoszcz','Toruń','Ostrołęka','Łomża','Białystok','Włocławek','Ciechanów','Zielona Góra','Poznań','Konin','Skierniewice','Płock','Warszawa','Siedlce','Biała Podlaska','Leszno','Kalisz','Sieradz','Łódź','Radom','Lublin','Chełm','Jelenia Góra','Legnica','Wrocław','Wałbrzych','Opole','Częstochowa','Piotrków Trybunalski','Kielce','Zamość','Katowice','Kraków','Tarnobrzeg','Rzeszów','Tarnów','Bielsko-Biała','Nowy Sącz','Krosno','Przemyśl') DEFAULT NULL,
  `stop_9` enum('Szczecin','Koszalin','Słupsk','Gdańsk','Elbląg','Olsztyn','Suwałki','Gorzów Wielkopolski','Piła','Bydgoszcz','Toruń','Ostrołęka','Łomża','Białystok','Włocławek','Ciechanów','Zielona Góra','Poznań','Konin','Skierniewice','Płock','Warszawa','Siedlce','Biała Podlaska','Leszno','Kalisz','Sieradz','Łódź','Radom','Lublin','Chełm','Jelenia Góra','Legnica','Wrocław','Wałbrzych','Opole','Częstochowa','Piotrków Trybunalski','Kielce','Zamość','Katowice','Kraków','Tarnobrzeg','Rzeszów','Tarnów','Bielsko-Biała','Nowy Sącz','Krosno','Przemyśl') DEFAULT NULL,
  `stop_10` enum('Szczecin','Koszalin','Słupsk','Gdańsk','Elbląg','Olsztyn','Suwałki','Gorzów Wielkopolski','Piła','Bydgoszcz','Toruń','Ostrołęka','Łomża','Białystok','Włocławek','Ciechanów','Zielona Góra','Poznań','Konin','Skierniewice','Płock','Warszawa','Siedlce','Biała Podlaska','Leszno','Kalisz','Sieradz','Łódź','Radom','Lublin','Chełm','Jelenia Góra','Legnica','Wrocław','Wałbrzych','Opole','Częstochowa','Piotrków Trybunalski','Kielce','Zamość','Katowice','Kraków','Tarnobrzeg','Rzeszów','Tarnów','Bielsko-Biała','Nowy Sącz','Krosno','Przemyśl') DEFAULT NULL,
  `stop_11` enum('Szczecin','Koszalin','Słupsk','Gdańsk','Elbląg','Olsztyn','Suwałki','Gorzów Wielkopolski','Piła','Bydgoszcz','Toruń','Ostrołęka','Łomża','Białystok','Włocławek','Ciechanów','Zielona Góra','Poznań','Konin','Skierniewice','Płock','Warszawa','Siedlce','Biała Podlaska','Leszno','Kalisz','Sieradz','Łódź','Radom','Lublin','Chełm','Jelenia Góra','Legnica','Wrocław','Wałbrzych','Opole','Częstochowa','Piotrków Trybunalski','Kielce','Zamość','Katowice','Kraków','Tarnobrzeg','Rzeszów','Tarnów','Bielsko-Biała','Nowy Sącz','Krosno','Przemyśl') DEFAULT NULL,
  `stop_12` enum('Szczecin','Koszalin','Słupsk','Gdańsk','Elbląg','Olsztyn','Suwałki','Gorzów Wielkopolski','Piła','Bydgoszcz','Toruń','Ostrołęka','Łomża','Białystok','Włocławek','Ciechanów','Zielona Góra','Poznań','Konin','Skierniewice','Płock','Warszawa','Siedlce','Biała Podlaska','Leszno','Kalisz','Sieradz','Łódź','Radom','Lublin','Chełm','Jelenia Góra','Legnica','Wrocław','Wałbrzych','Opole','Częstochowa','Piotrków Trybunalski','Kielce','Zamość','Katowice','Kraków','Tarnobrzeg','Rzeszów','Tarnów','Bielsko-Biała','Nowy Sącz','Krosno','Przemyśl') DEFAULT NULL,
  `stop_13` enum('Szczecin','Koszalin','Słupsk','Gdańsk','Elbląg','Olsztyn','Suwałki','Gorzów Wielkopolski','Piła','Bydgoszcz','Toruń','Ostrołęka','Łomża','Białystok','Włocławek','Ciechanów','Zielona Góra','Poznań','Konin','Skierniewice','Płock','Warszawa','Siedlce','Biała Podlaska','Leszno','Kalisz','Sieradz','Łódź','Radom','Lublin','Chełm','Jelenia Góra','Legnica','Wrocław','Wałbrzych','Opole','Częstochowa','Piotrków Trybunalski','Kielce','Zamość','Katowice','Kraków','Tarnobrzeg','Rzeszów','Tarnów','Bielsko-Biała','Nowy Sącz','Krosno','Przemyśl') DEFAULT NULL,
  `stop_14` enum('Szczecin','Koszalin','Słupsk','Gdańsk','Elbląg','Olsztyn','Suwałki','Gorzów Wielkopolski','Piła','Bydgoszcz','Toruń','Ostrołęka','Łomża','Białystok','Włocławek','Ciechanów','Zielona Góra','Poznań','Konin','Skierniewice','Płock','Warszawa','Siedlce','Biała Podlaska','Leszno','Kalisz','Sieradz','Łódź','Radom','Lublin','Chełm','Jelenia Góra','Legnica','Wrocław','Wałbrzych','Opole','Częstochowa','Piotrków Trybunalski','Kielce','Zamość','Katowice','Kraków','Tarnobrzeg','Rzeszów','Tarnów','Bielsko-Biała','Nowy Sącz','Krosno','Przemyśl') DEFAULT NULL,
  `stop_15` enum('Szczecin','Koszalin','Słupsk','Gdańsk','Elbląg','Olsztyn','Suwałki','Gorzów Wielkopolski','Piła','Bydgoszcz','Toruń','Ostrołęka','Łomża','Białystok','Włocławek','Ciechanów','Zielona Góra','Poznań','Konin','Skierniewice','Płock','Warszawa','Siedlce','Biała Podlaska','Leszno','Kalisz','Sieradz','Łódź','Radom','Lublin','Chełm','Jelenia Góra','Legnica','Wrocław','Wałbrzych','Opole','Częstochowa','Piotrków Trybunalski','Kielce','Zamość','Katowice','Kraków','Tarnobrzeg','Rzeszów','Tarnów','Bielsko-Biała','Nowy Sącz','Krosno','Przemyśl') DEFAULT NULL,
  `stop_16` enum('Szczecin','Koszalin','Słupsk','Gdańsk','Elbląg','Olsztyn','Suwałki','Gorzów Wielkopolski','Piła','Bydgoszcz','Toruń','Ostrołęka','Łomża','Białystok','Włocławek','Ciechanów','Zielona Góra','Poznań','Konin','Skierniewice','Płock','Warszawa','Siedlce','Biała Podlaska','Leszno','Kalisz','Sieradz','Łódź','Radom','Lublin','Chełm','Jelenia Góra','Legnica','Wrocław','Wałbrzych','Opole','Częstochowa','Piotrków Trybunalski','Kielce','Zamość','Katowice','Kraków','Tarnobrzeg','Rzeszów','Tarnów','Bielsko-Biała','Nowy Sącz','Krosno','Przemyśl') DEFAULT NULL,
  `stop_17` enum('Szczecin','Koszalin','Słupsk','Gdańsk','Elbląg','Olsztyn','Suwałki','Gorzów Wielkopolski','Piła','Bydgoszcz','Toruń','Ostrołęka','Łomża','Białystok','Włocławek','Ciechanów','Zielona Góra','Poznań','Konin','Skierniewice','Płock','Warszawa','Siedlce','Biała Podlaska','Leszno','Kalisz','Sieradz','Łódź','Radom','Lublin','Chełm','Jelenia Góra','Legnica','Wrocław','Wałbrzych','Opole','Częstochowa','Piotrków Trybunalski','Kielce','Zamość','Katowice','Kraków','Tarnobrzeg','Rzeszów','Tarnów','Bielsko-Biała','Nowy Sącz','Krosno','Przemyśl') DEFAULT NULL,
  `stop_18` enum('Szczecin','Koszalin','Słupsk','Gdańsk','Elbląg','Olsztyn','Suwałki','Gorzów Wielkopolski','Piła','Bydgoszcz','Toruń','Ostrołęka','Łomża','Białystok','Włocławek','Ciechanów','Zielona Góra','Poznań','Konin','Skierniewice','Płock','Warszawa','Siedlce','Biała Podlaska','Leszno','Kalisz','Sieradz','Łódź','Radom','Lublin','Chełm','Jelenia Góra','Legnica','Wrocław','Wałbrzych','Opole','Częstochowa','Piotrków Trybunalski','Kielce','Zamość','Katowice','Kraków','Tarnobrzeg','Rzeszów','Tarnów','Bielsko-Biała','Nowy Sącz','Krosno','Przemyśl') DEFAULT NULL,
  `stop_19` enum('Szczecin','Koszalin','Słupsk','Gdańsk','Elbląg','Olsztyn','Suwałki','Gorzów Wielkopolski','Piła','Bydgoszcz','Toruń','Ostrołęka','Łomża','Białystok','Włocławek','Ciechanów','Zielona Góra','Poznań','Konin','Skierniewice','Płock','Warszawa','Siedlce','Biała Podlaska','Leszno','Kalisz','Sieradz','Łódź','Radom','Lublin','Chełm','Jelenia Góra','Legnica','Wrocław','Wałbrzych','Opole','Częstochowa','Piotrków Trybunalski','Kielce','Zamość','Katowice','Kraków','Tarnobrzeg','Rzeszów','Tarnów','Bielsko-Biała','Nowy Sącz','Krosno','Przemyśl') DEFAULT NULL,
  `stop_20` enum('Szczecin','Koszalin','Słupsk','Gdańsk','Elbląg','Olsztyn','Suwałki','Gorzów Wielkopolski','Piła','Bydgoszcz','Toruń','Ostrołęka','Łomża','Białystok','Włocławek','Ciechanów','Zielona Góra','Poznań','Konin','Skierniewice','Płock','Warszawa','Siedlce','Biała Podlaska','Leszno','Kalisz','Sieradz','Łódź','Radom','Lublin','Chełm','Jelenia Góra','Legnica','Wrocław','Wałbrzych','Opole','Częstochowa','Piotrków Trybunalski','Kielce','Zamość','Katowice','Kraków','Tarnobrzeg','Rzeszów','Tarnów','Bielsko-Biała','Nowy Sącz','Krosno','Przemyśl') DEFAULT NULL,
  `stop_21` enum('Szczecin','Koszalin','Słupsk','Gdańsk','Elbląg','Olsztyn','Suwałki','Gorzów Wielkopolski','Piła','Bydgoszcz','Toruń','Ostrołęka','Łomża','Białystok','Włocławek','Ciechanów','Zielona Góra','Poznań','Konin','Skierniewice','Płock','Warszawa','Siedlce','Biała Podlaska','Leszno','Kalisz','Sieradz','Łódź','Radom','Lublin','Chełm','Jelenia Góra','Legnica','Wrocław','Wałbrzych','Opole','Częstochowa','Piotrków Trybunalski','Kielce','Zamość','Katowice','Kraków','Tarnobrzeg','Rzeszów','Tarnów','Bielsko-Biała','Nowy Sącz','Krosno','Przemyśl') DEFAULT NULL,
  `stop_22` enum('Szczecin','Koszalin','Słupsk','Gdańsk','Elbląg','Olsztyn','Suwałki','Gorzów Wielkopolski','Piła','Bydgoszcz','Toruń','Ostrołęka','Łomża','Białystok','Włocławek','Ciechanów','Zielona Góra','Poznań','Konin','Skierniewice','Płock','Warszawa','Siedlce','Biała Podlaska','Leszno','Kalisz','Sieradz','Łódź','Radom','Lublin','Chełm','Jelenia Góra','Legnica','Wrocław','Wałbrzych','Opole','Częstochowa','Piotrków Trybunalski','Kielce','Zamość','Katowice','Kraków','Tarnobrzeg','Rzeszów','Tarnów','Bielsko-Biała','Nowy Sącz','Krosno','Przemyśl') DEFAULT NULL,
  `stop_23` enum('Szczecin','Koszalin','Słupsk','Gdańsk','Elbląg','Olsztyn','Suwałki','Gorzów Wielkopolski','Piła','Bydgoszcz','Toruń','Ostrołęka','Łomża','Białystok','Włocławek','Ciechanów','Zielona Góra','Poznań','Konin','Skierniewice','Płock','Warszawa','Siedlce','Biała Podlaska','Leszno','Kalisz','Sieradz','Łódź','Radom','Lublin','Chełm','Jelenia Góra','Legnica','Wrocław','Wałbrzych','Opole','Częstochowa','Piotrków Trybunalski','Kielce','Zamość','Katowice','Kraków','Tarnobrzeg','Rzeszów','Tarnów','Bielsko-Biała','Nowy Sącz','Krosno','Przemyśl') DEFAULT NULL,
  `stop_24` enum('Szczecin','Koszalin','Słupsk','Gdańsk','Elbląg','Olsztyn','Suwałki','Gorzów Wielkopolski','Piła','Bydgoszcz','Toruń','Ostrołęka','Łomża','Białystok','Włocławek','Ciechanów','Zielona Góra','Poznań','Konin','Skierniewice','Płock','Warszawa','Siedlce','Biała Podlaska','Leszno','Kalisz','Sieradz','Łódź','Radom','Lublin','Chełm','Jelenia Góra','Legnica','Wrocław','Wałbrzych','Opole','Częstochowa','Piotrków Trybunalski','Kielce','Zamość','Katowice','Kraków','Tarnobrzeg','Rzeszów','Tarnów','Bielsko-Biała','Nowy Sącz','Krosno','Przemyśl') DEFAULT NULL,
  `stop_25` enum('Szczecin','Koszalin','Słupsk','Gdańsk','Elbląg','Olsztyn','Suwałki','Gorzów Wielkopolski','Piła','Bydgoszcz','Toruń','Ostrołęka','Łomża','Białystok','Włocławek','Ciechanów','Zielona Góra','Poznań','Konin','Skierniewice','Płock','Warszawa','Siedlce','Biała Podlaska','Leszno','Kalisz','Sieradz','Łódź','Radom','Lublin','Chełm','Jelenia Góra','Legnica','Wrocław','Wałbrzych','Opole','Częstochowa','Piotrków Trybunalski','Kielce','Zamość','Katowice','Kraków','Tarnobrzeg','Rzeszów','Tarnów','Bielsko-Biała','Nowy Sącz','Krosno','Przemyśl') DEFAULT NULL,
  `stop_26` enum('Szczecin','Koszalin','Słupsk','Gdańsk','Elbląg','Olsztyn','Suwałki','Gorzów Wielkopolski','Piła','Bydgoszcz','Toruń','Ostrołęka','Łomża','Białystok','Włocławek','Ciechanów','Zielona Góra','Poznań','Konin','Skierniewice','Płock','Warszawa','Siedlce','Biała Podlaska','Leszno','Kalisz','Sieradz','Łódź','Radom','Lublin','Chełm','Jelenia Góra','Legnica','Wrocław','Wałbrzych','Opole','Częstochowa','Piotrków Trybunalski','Kielce','Zamość','Katowice','Kraków','Tarnobrzeg','Rzeszów','Tarnów','Bielsko-Biała','Nowy Sącz','Krosno','Przemyśl') DEFAULT NULL,
  `stop_27` enum('Szczecin','Koszalin','Słupsk','Gdańsk','Elbląg','Olsztyn','Suwałki','Gorzów Wielkopolski','Piła','Bydgoszcz','Toruń','Ostrołęka','Łomża','Białystok','Włocławek','Ciechanów','Zielona Góra','Poznań','Konin','Skierniewice','Płock','Warszawa','Siedlce','Biała Podlaska','Leszno','Kalisz','Sieradz','Łódź','Radom','Lublin','Chełm','Jelenia Góra','Legnica','Wrocław','Wałbrzych','Opole','Częstochowa','Piotrków Trybunalski','Kielce','Zamość','Katowice','Kraków','Tarnobrzeg','Rzeszów','Tarnów','Bielsko-Biała','Nowy Sącz','Krosno','Przemyśl') DEFAULT NULL,
  `stop_28` enum('Szczecin','Koszalin','Słupsk','Gdańsk','Elbląg','Olsztyn','Suwałki','Gorzów Wielkopolski','Piła','Bydgoszcz','Toruń','Ostrołęka','Łomża','Białystok','Włocławek','Ciechanów','Zielona Góra','Poznań','Konin','Skierniewice','Płock','Warszawa','Siedlce','Biała Podlaska','Leszno','Kalisz','Sieradz','Łódź','Radom','Lublin','Chełm','Jelenia Góra','Legnica','Wrocław','Wałbrzych','Opole','Częstochowa','Piotrków Trybunalski','Kielce','Zamość','Katowice','Kraków','Tarnobrzeg','Rzeszów','Tarnów','Bielsko-Biała','Nowy Sącz','Krosno','Przemyśl') DEFAULT NULL,
  `stop_29` enum('Szczecin','Koszalin','Słupsk','Gdańsk','Elbląg','Olsztyn','Suwałki','Gorzów Wielkopolski','Piła','Bydgoszcz','Toruń','Ostrołęka','Łomża','Białystok','Włocławek','Ciechanów','Zielona Góra','Poznań','Konin','Skierniewice','Płock','Warszawa','Siedlce','Biała Podlaska','Leszno','Kalisz','Sieradz','Łódź','Radom','Lublin','Chełm','Jelenia Góra','Legnica','Wrocław','Wałbrzych','Opole','Częstochowa','Piotrków Trybunalski','Kielce','Zamość','Katowice','Kraków','Tarnobrzeg','Rzeszów','Tarnów','Bielsko-Biała','Nowy Sącz','Krosno','Przemyśl') DEFAULT NULL,
  `stop_30` enum('Szczecin','Koszalin','Słupsk','Gdańsk','Elbląg','Olsztyn','Suwałki','Gorzów Wielkopolski','Piła','Bydgoszcz','Toruń','Ostrołęka','Łomża','Białystok','Włocławek','Ciechanów','Zielona Góra','Poznań','Konin','Skierniewice','Płock','Warszawa','Siedlce','Biała Podlaska','Leszno','Kalisz','Sieradz','Łódź','Radom','Lublin','Chełm','Jelenia Góra','Legnica','Wrocław','Wałbrzych','Opole','Częstochowa','Piotrków Trybunalski','Kielce','Zamość','Katowice','Kraków','Tarnobrzeg','Rzeszów','Tarnów','Bielsko-Biała','Nowy Sącz','Krosno','Przemyśl') DEFAULT NULL,
  `stop_31` enum('Szczecin','Koszalin','Słupsk','Gdańsk','Elbląg','Olsztyn','Suwałki','Gorzów Wielkopolski','Piła','Bydgoszcz','Toruń','Ostrołęka','Łomża','Białystok','Włocławek','Ciechanów','Zielona Góra','Poznań','Konin','Skierniewice','Płock','Warszawa','Siedlce','Biała Podlaska','Leszno','Kalisz','Sieradz','Łódź','Radom','Lublin','Chełm','Jelenia Góra','Legnica','Wrocław','Wałbrzych','Opole','Częstochowa','Piotrków Trybunalski','Kielce','Zamość','Katowice','Kraków','Tarnobrzeg','Rzeszów','Tarnów','Bielsko-Biała','Nowy Sącz','Krosno','Przemyśl') DEFAULT NULL,
  `stop_32` enum('Szczecin','Koszalin','Słupsk','Gdańsk','Elbląg','Olsztyn','Suwałki','Gorzów Wielkopolski','Piła','Bydgoszcz','Toruń','Ostrołęka','Łomża','Białystok','Włocławek','Ciechanów','Zielona Góra','Poznań','Konin','Skierniewice','Płock','Warszawa','Siedlce','Biała Podlaska','Leszno','Kalisz','Sieradz','Łódź','Radom','Lublin','Chełm','Jelenia Góra','Legnica','Wrocław','Wałbrzych','Opole','Częstochowa','Piotrków Trybunalski','Kielce','Zamość','Katowice','Kraków','Tarnobrzeg','Rzeszów','Tarnów','Bielsko-Biała','Nowy Sącz','Krosno','Przemyśl') DEFAULT NULL,
  `stop_33` enum('Szczecin','Koszalin','Słupsk','Gdańsk','Elbląg','Olsztyn','Suwałki','Gorzów Wielkopolski','Piła','Bydgoszcz','Toruń','Ostrołęka','Łomża','Białystok','Włocławek','Ciechanów','Zielona Góra','Poznań','Konin','Skierniewice','Płock','Warszawa','Siedlce','Biała Podlaska','Leszno','Kalisz','Sieradz','Łódź','Radom','Lublin','Chełm','Jelenia Góra','Legnica','Wrocław','Wałbrzych','Opole','Częstochowa','Piotrków Trybunalski','Kielce','Zamość','Katowice','Kraków','Tarnobrzeg','Rzeszów','Tarnów','Bielsko-Biała','Nowy Sącz','Krosno','Przemyśl') DEFAULT NULL,
  `stop_34` enum('Szczecin','Koszalin','Słupsk','Gdańsk','Elbląg','Olsztyn','Suwałki','Gorzów Wielkopolski','Piła','Bydgoszcz','Toruń','Ostrołęka','Łomża','Białystok','Włocławek','Ciechanów','Zielona Góra','Poznań','Konin','Skierniewice','Płock','Warszawa','Siedlce','Biała Podlaska','Leszno','Kalisz','Sieradz','Łódź','Radom','Lublin','Chełm','Jelenia Góra','Legnica','Wrocław','Wałbrzych','Opole','Częstochowa','Piotrków Trybunalski','Kielce','Zamość','Katowice','Kraków','Tarnobrzeg','Rzeszów','Tarnów','Bielsko-Biała','Nowy Sącz','Krosno','Przemyśl') DEFAULT NULL,
  `stop_35` enum('Szczecin','Koszalin','Słupsk','Gdańsk','Elbląg','Olsztyn','Suwałki','Gorzów Wielkopolski','Piła','Bydgoszcz','Toruń','Ostrołęka','Łomża','Białystok','Włocławek','Ciechanów','Zielona Góra','Poznań','Konin','Skierniewice','Płock','Warszawa','Siedlce','Biała Podlaska','Leszno','Kalisz','Sieradz','Łódź','Radom','Lublin','Chełm','Jelenia Góra','Legnica','Wrocław','Wałbrzych','Opole','Częstochowa','Piotrków Trybunalski','Kielce','Zamość','Katowice','Kraków','Tarnobrzeg','Rzeszów','Tarnów','Bielsko-Biała','Nowy Sącz','Krosno','Przemyśl') DEFAULT NULL,
  `stop_36` enum('Szczecin','Koszalin','Słupsk','Gdańsk','Elbląg','Olsztyn','Suwałki','Gorzów Wielkopolski','Piła','Bydgoszcz','Toruń','Ostrołęka','Łomża','Białystok','Włocławek','Ciechanów','Zielona Góra','Poznań','Konin','Skierniewice','Płock','Warszawa','Siedlce','Biała Podlaska','Leszno','Kalisz','Sieradz','Łódź','Radom','Lublin','Chełm','Jelenia Góra','Legnica','Wrocław','Wałbrzych','Opole','Częstochowa','Piotrków Trybunalski','Kielce','Zamość','Katowice','Kraków','Tarnobrzeg','Rzeszów','Tarnów','Bielsko-Biała','Nowy Sącz','Krosno','Przemyśl') DEFAULT NULL,
  `stop_37` enum('Szczecin','Koszalin','Słupsk','Gdańsk','Elbląg','Olsztyn','Suwałki','Gorzów Wielkopolski','Piła','Bydgoszcz','Toruń','Ostrołęka','Łomża','Białystok','Włocławek','Ciechanów','Zielona Góra','Poznań','Konin','Skierniewice','Płock','Warszawa','Siedlce','Biała Podlaska','Leszno','Kalisz','Sieradz','Łódź','Radom','Lublin','Chełm','Jelenia Góra','Legnica','Wrocław','Wałbrzych','Opole','Częstochowa','Piotrków Trybunalski','Kielce','Zamość','Katowice','Kraków','Tarnobrzeg','Rzeszów','Tarnów','Bielsko-Biała','Nowy Sącz','Krosno','Przemyśl') DEFAULT NULL,
  `stop_38` enum('Szczecin','Koszalin','Słupsk','Gdańsk','Elbląg','Olsztyn','Suwałki','Gorzów Wielkopolski','Piła','Bydgoszcz','Toruń','Ostrołęka','Łomża','Białystok','Włocławek','Ciechanów','Zielona Góra','Poznań','Konin','Skierniewice','Płock','Warszawa','Siedlce','Biała Podlaska','Leszno','Kalisz','Sieradz','Łódź','Radom','Lublin','Chełm','Jelenia Góra','Legnica','Wrocław','Wałbrzych','Opole','Częstochowa','Piotrków Trybunalski','Kielce','Zamość','Katowice','Kraków','Tarnobrzeg','Rzeszów','Tarnów','Bielsko-Biała','Nowy Sącz','Krosno','Przemyśl') DEFAULT NULL,
  `stop_39` enum('Szczecin','Koszalin','Słupsk','Gdańsk','Elbląg','Olsztyn','Suwałki','Gorzów Wielkopolski','Piła','Bydgoszcz','Toruń','Ostrołęka','Łomża','Białystok','Włocławek','Ciechanów','Zielona Góra','Poznań','Konin','Skierniewice','Płock','Warszawa','Siedlce','Biała Podlaska','Leszno','Kalisz','Sieradz','Łódź','Radom','Lublin','Chełm','Jelenia Góra','Legnica','Wrocław','Wałbrzych','Opole','Częstochowa','Piotrków Trybunalski','Kielce','Zamość','Katowice','Kraków','Tarnobrzeg','Rzeszów','Tarnów','Bielsko-Biała','Nowy Sącz','Krosno','Przemyśl') DEFAULT NULL,
  `stop_40` enum('Szczecin','Koszalin','Słupsk','Gdańsk','Elbląg','Olsztyn','Suwałki','Gorzów Wielkopolski','Piła','Bydgoszcz','Toruń','Ostrołęka','Łomża','Białystok','Włocławek','Ciechanów','Zielona Góra','Poznań','Konin','Skierniewice','Płock','Warszawa','Siedlce','Biała Podlaska','Leszno','Kalisz','Sieradz','Łódź','Radom','Lublin','Chełm','Jelenia Góra','Legnica','Wrocław','Wałbrzych','Opole','Częstochowa','Piotrków Trybunalski','Kielce','Zamość','Katowice','Kraków','Tarnobrzeg','Rzeszów','Tarnów','Bielsko-Biała','Nowy Sącz','Krosno','Przemyśl') DEFAULT NULL,
  `stop_41` enum('Szczecin','Koszalin','Słupsk','Gdańsk','Elbląg','Olsztyn','Suwałki','Gorzów Wielkopolski','Piła','Bydgoszcz','Toruń','Ostrołęka','Łomża','Białystok','Włocławek','Ciechanów','Zielona Góra','Poznań','Konin','Skierniewice','Płock','Warszawa','Siedlce','Biała Podlaska','Leszno','Kalisz','Sieradz','Łódź','Radom','Lublin','Chełm','Jelenia Góra','Legnica','Wrocław','Wałbrzych','Opole','Częstochowa','Piotrków Trybunalski','Kielce','Zamość','Katowice','Kraków','Tarnobrzeg','Rzeszów','Tarnów','Bielsko-Biała','Nowy Sącz','Krosno','Przemyśl') DEFAULT NULL,
  `stop_42` enum('Szczecin','Koszalin','Słupsk','Gdańsk','Elbląg','Olsztyn','Suwałki','Gorzów Wielkopolski','Piła','Bydgoszcz','Toruń','Ostrołęka','Łomża','Białystok','Włocławek','Ciechanów','Zielona Góra','Poznań','Konin','Skierniewice','Płock','Warszawa','Siedlce','Biała Podlaska','Leszno','Kalisz','Sieradz','Łódź','Radom','Lublin','Chełm','Jelenia Góra','Legnica','Wrocław','Wałbrzych','Opole','Częstochowa','Piotrków Trybunalski','Kielce','Zamość','Katowice','Kraków','Tarnobrzeg','Rzeszów','Tarnów','Bielsko-Biała','Nowy Sącz','Krosno','Przemyśl') DEFAULT NULL,
  `stop_43` enum('Szczecin','Koszalin','Słupsk','Gdańsk','Elbląg','Olsztyn','Suwałki','Gorzów Wielkopolski','Piła','Bydgoszcz','Toruń','Ostrołęka','Łomża','Białystok','Włocławek','Ciechanów','Zielona Góra','Poznań','Konin','Skierniewice','Płock','Warszawa','Siedlce','Biała Podlaska','Leszno','Kalisz','Sieradz','Łódź','Radom','Lublin','Chełm','Jelenia Góra','Legnica','Wrocław','Wałbrzych','Opole','Częstochowa','Piotrków Trybunalski','Kielce','Zamość','Katowice','Kraków','Tarnobrzeg','Rzeszów','Tarnów','Bielsko-Biała','Nowy Sącz','Krosno','Przemyśl') DEFAULT NULL,
  `stop_44` enum('Szczecin','Koszalin','Słupsk','Gdańsk','Elbląg','Olsztyn','Suwałki','Gorzów Wielkopolski','Piła','Bydgoszcz','Toruń','Ostrołęka','Łomża','Białystok','Włocławek','Ciechanów','Zielona Góra','Poznań','Konin','Skierniewice','Płock','Warszawa','Siedlce','Biała Podlaska','Leszno','Kalisz','Sieradz','Łódź','Radom','Lublin','Chełm','Jelenia Góra','Legnica','Wrocław','Wałbrzych','Opole','Częstochowa','Piotrków Trybunalski','Kielce','Zamość','Katowice','Kraków','Tarnobrzeg','Rzeszów','Tarnów','Bielsko-Biała','Nowy Sącz','Krosno','Przemyśl') DEFAULT NULL,
  `stop_45` enum('Szczecin','Koszalin','Słupsk','Gdańsk','Elbląg','Olsztyn','Suwałki','Gorzów Wielkopolski','Piła','Bydgoszcz','Toruń','Ostrołęka','Łomża','Białystok','Włocławek','Ciechanów','Zielona Góra','Poznań','Konin','Skierniewice','Płock','Warszawa','Siedlce','Biała Podlaska','Leszno','Kalisz','Sieradz','Łódź','Radom','Lublin','Chełm','Jelenia Góra','Legnica','Wrocław','Wałbrzych','Opole','Częstochowa','Piotrków Trybunalski','Kielce','Zamość','Katowice','Kraków','Tarnobrzeg','Rzeszów','Tarnów','Bielsko-Biała','Nowy Sącz','Krosno','Przemyśl') DEFAULT NULL,
  `stop_46` enum('Szczecin','Koszalin','Słupsk','Gdańsk','Elbląg','Olsztyn','Suwałki','Gorzów Wielkopolski','Piła','Bydgoszcz','Toruń','Ostrołęka','Łomża','Białystok','Włocławek','Ciechanów','Zielona Góra','Poznań','Konin','Skierniewice','Płock','Warszawa','Siedlce','Biała Podlaska','Leszno','Kalisz','Sieradz','Łódź','Radom','Lublin','Chełm','Jelenia Góra','Legnica','Wrocław','Wałbrzych','Opole','Częstochowa','Piotrków Trybunalski','Kielce','Zamość','Katowice','Kraków','Tarnobrzeg','Rzeszów','Tarnów','Bielsko-Biała','Nowy Sącz','Krosno','Przemyśl') DEFAULT NULL,
  `stop_47` enum('Szczecin','Koszalin','Słupsk','Gdańsk','Elbląg','Olsztyn','Suwałki','Gorzów Wielkopolski','Piła','Bydgoszcz','Toruń','Ostrołęka','Łomża','Białystok','Włocławek','Ciechanów','Zielona Góra','Poznań','Konin','Skierniewice','Płock','Warszawa','Siedlce','Biała Podlaska','Leszno','Kalisz','Sieradz','Łódź','Radom','Lublin','Chełm','Jelenia Góra','Legnica','Wrocław','Wałbrzych','Opole','Częstochowa','Piotrków Trybunalski','Kielce','Zamość','Katowice','Kraków','Tarnobrzeg','Rzeszów','Tarnów','Bielsko-Biała','Nowy Sącz','Krosno','Przemyśl') DEFAULT NULL,
  `stop_48` enum('Szczecin','Koszalin','Słupsk','Gdańsk','Elbląg','Olsztyn','Suwałki','Gorzów Wielkopolski','Piła','Bydgoszcz','Toruń','Ostrołęka','Łomża','Białystok','Włocławek','Ciechanów','Zielona Góra','Poznań','Konin','Skierniewice','Płock','Warszawa','Siedlce','Biała Podlaska','Leszno','Kalisz','Sieradz','Łódź','Radom','Lublin','Chełm','Jelenia Góra','Legnica','Wrocław','Wałbrzych','Opole','Częstochowa','Piotrków Trybunalski','Kielce','Zamość','Katowice','Kraków','Tarnobrzeg','Rzeszów','Tarnów','Bielsko-Biała','Nowy Sącz','Krosno','Przemyśl') DEFAULT NULL,
  `stop_49` enum('Szczecin','Koszalin','Słupsk','Gdańsk','Elbląg','Olsztyn','Suwałki','Gorzów Wielkopolski','Piła','Bydgoszcz','Toruń','Ostrołęka','Łomża','Białystok','Włocławek','Ciechanów','Zielona Góra','Poznań','Konin','Skierniewice','Płock','Warszawa','Siedlce','Biała Podlaska','Leszno','Kalisz','Sieradz','Łódź','Radom','Lublin','Chełm','Jelenia Góra','Legnica','Wrocław','Wałbrzych','Opole','Częstochowa','Piotrków Trybunalski','Kielce','Zamość','Katowice','Kraków','Tarnobrzeg','Rzeszów','Tarnów','Bielsko-Biała','Nowy Sącz','Krosno','Przemyśl') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`login`);

--
-- Indeksy dla tabeli `parcels`
--
ALTER TABLE `parcels`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`),
  ADD KEY `ordered_by` (`ordered_by`);

--
-- Indeksy dla tabeli `parcel_history`
--
ALTER TABLE `parcel_history`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `routes`
--
ALTER TABLE `routes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee` (`employee`);

--
-- Indeksy dla tabeli `route_stops`
--
ALTER TABLE `route_stops`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT dla zrzuconych tabel
--

--
-- AUTO_INCREMENT dla tabeli `parcels`
--
ALTER TABLE `parcels`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT dla tabeli `parcel_history`
--
ALTER TABLE `parcel_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT dla tabeli `routes`
--
ALTER TABLE `routes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1681153759;

--
-- AUTO_INCREMENT dla tabeli `route_stops`
--
ALTER TABLE `route_stops`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1681153759;

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `parcels`
--
ALTER TABLE `parcels`
  ADD CONSTRAINT `parcels_ibfk_1` FOREIGN KEY (`ordered_by`) REFERENCES `login` (`login`);

--
-- Ograniczenia dla tabeli `routes`
--
ALTER TABLE `routes`
  ADD CONSTRAINT `routes_ibfk_1` FOREIGN KEY (`employee`) REFERENCES `login` (`login`);

DELIMITER $$
--
-- Zdarzenia
--
CREATE DEFINER=`root`@`localhost` EVENT `teleport` ON SCHEDULE EVERY 1 MINUTE STARTS '2023-03-12 21:14:19' ON COMPLETION NOT PRESERVE ENABLE DO call teleport()$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
