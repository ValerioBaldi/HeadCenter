create table iscrizione (
    email varchar(40) not null, 
    nome varchar(40) not null,
    cognome varchar(40) not null,
    DataDiNascita date not null,
    telefono bigint not null,
    classe varchar(40) not null,
    primary key (email)
);

