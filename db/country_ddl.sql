DROP DATABASE IF EXISTS countries_db_pv225;
CREATE DATABASE countries_db_pv225;
-- переключение на данную БД
USE countries_db_pv225;
-- создание таблицы аэропортов
CREATE TABLE country_t (
	id INT NOT NULL AUTO_INCREMENT,
    shortName NVARCHAR(200) NOT NULL,
    fullName NVARCHAR(400) NULL
    isoAlpha2 CHAR(2) NOT NULL,
    isoAlpha3 CHAR(3) NOT NULL,
    isoNumeric CHAR(2) NOT NULL,
    population INT NOT NULL,
    square DECEMAL(10,2) NOT NULL,
    --
    PRIMARY KEY(id),
    UNIQUE(shortName)
);