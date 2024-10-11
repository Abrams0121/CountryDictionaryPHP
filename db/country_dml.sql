-- заполнение БД
USE countries_db_pv225;

-- удалить данные
TRUNCATE TABLE country_t;

-- добавить данные
INSERT INTO country_t (
    shortName, 
    fullName, 
    isoAlpha2, 
    isoAlpha3, 
    isoNumeric, 
    population, 
    square
) VALUES 
    ('RU', 'Российская Федерация', 'RU', 'RUS', '643', 146599183, 17098242.00),
    ('GB', 'Великобритания', 'GB', 'GBR', '826', 67886011, 243610.00),
    ('US', 'Соединённые Штаты Америки', 'US', 'USA', '840', 331002651, 9833517.00),
    ('CN', 'Китайская Народная Республика', 'CN', 'CHN', '156', 1439323776, 9596961.00),
    ('DE', 'Германия', 'DE', 'DEU', '276', 83240525, 357022.00);

-- получим данные
SELECT * FROM country_t;