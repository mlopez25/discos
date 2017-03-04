create database dbdiscos default character set utf8 collate utf8_unicode_ci;

create user usuariodisco@localhost identified by 'clavedisco';

grant all on dbdiscos.* to usuariodisco@localhost;

flush privileges;

use dbdiscos;

create table usuario(
    login varchar(150) not null primary key,
    password varchar(256) not null
) engine=innodb default charset=utf8 collate=utf8_unicode_ci;

create table disco(
    idDisco int auto_increment not null primary key,
    title varchar(150) not null
) engine=innodb default charset=utf8 collate=utf8_unicode_ci;

create table autor(
    idAutor int auto_increment not null primary key,
    autor varchar(150) not null
) engine=innodb default charset=utf8 collate=utf8_unicode_ci;

create table discosAutor(
    idDisco int not null,
    idAutor int not null,
    primary key (idDisco, idAutor),
    foreign key(idDisco) references disco(idDisco) on delete cascade on update cascade,
    foreign key(idAutor) references autor(idAutor) on delete cascade on update cascade
) engine=innodb default charset=utf8 collate=utf8_unicode_ci;