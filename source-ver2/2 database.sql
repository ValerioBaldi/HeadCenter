create table digital (
    report_id int NOT NULL PRIMARY KEY,
    report_by int NOT NULL,
    digital_date date,
    digital_usage_from timestamp NOT NULL,
    digital_usage_to timestamp NOT NULL,
    symptoms varchar(200),
    devices_type varchar(100) NOT NULL,
    usage_for varchar(50) NOT NULL
);

create table sleep (
    report_id int NOT NULL PRIMARY KEY,
    report_by int NOT NULL,
    sleep_date date,
    sleeping_time_from timestamp NOT NULL,
    sleeping_time_to timestamp NOT NULL,
    coffee_cups varchar(50) NOT NULL,
    sleeping_rate int NOT NULL,
    awaken_during_sleep boolean NOT NULL
);

create table headache (
    report_id int NOT NULL PRIMARY KEY,
    report_by int NOT NULL,
    headache_date date,
    starting_time timestamp NOT NULL,
    ending_time timestamp,
    still_going boolean,
    ache_position varchar (200),
    ache_intensity varchar(15),
    ache_type varchar(200),
    painkillers varchar(500),
    repercussions varchar(200),
    symptoms varchar(200),
    notes varchar(200)
);

create table users (
    id int NOT NULL PRIMARY KEY,
    username varchar(50) NOT NULL unique,
    pass varchar(20) NOT NULL, 
    first_name varchar(50) NOT NULL,
    surname varchar(50) NOT NULL,
    age int NOT NULL
);

insert into users (id, username, pass, first_name, surname, age)
values (1,'Utente_Prova', '12Pass34', 'Mario', 'Rossi', 20);

insert into headache (report_id, report_by, starting_time)
values (1, 1, '2024-06-29 10:00:00')