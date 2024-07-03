create table digital (
    report_id int NOT NULL PRIMARY KEY,
    report_by int NOT NULL,
    digital_date date,
    digital_usage_from timestamp NOT NULL,
    digital_usage_to timestamp NOT NULL,
    symptoms char(100),
    devices_type char(40) NOT NULL,
    usage_for char(30) NOT NULL
);

create table sleep (
    report_id int NOT NULL PRIMARY KEY,
    report_by int NOT NULL,
    sleeping_time_from timestamp NOT NULL,
    sleeping_time_to timestamp NOT NULL,
    coffee_cups int NOT NULL,
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
    ache_position char(20),
    ache_intensity char(10),
    ache_type char(20),
    painkillers char(100),
    repercussions char(100),
    symptoms char(100),
    notes char(200)
);

create table users (
    id int NOT NULL PRIMARY KEY,
    first_name char(50) NOT NULL,
    surname char(50) NOT NULL,
    age int NOT NULL
);

insert into users (id, first name, surname, age)
values (1, 'Mario', 'Rossi', 20);

insert into headache (report_id, report_by, starting_time)
values (1, 1, '2024-06-29 10:00:00')