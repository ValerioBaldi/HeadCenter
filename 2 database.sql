create table iscrizione (
    email varchar(40) not null, 
    nome varchar(40) not null,
    cognome varchar(40) not null,
    DataDiNascita date not null,
    telefono bigint not null,
    classe varchar(40) not null,
    messaggio varchar(600),
    primary key (email)
);

create table help (
    email varchar(40) not null, 
    problema varchar(600) not null

);

create table collabora (
    cognome varchar(40),
    nome varchar(40),
    email varchar(40) not null,
    descrizione varchar(40) not null

)