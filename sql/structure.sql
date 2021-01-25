CREATE TABLE IF NOT EXISTS user
(
    id            int unsigned auto_increment         primary key,
    username      varchar(100)                        not null,
    password      char(100)                           not null,
    date_created  timestamp default CURRENT_TIMESTAMP not null,
    date_modified timestamp default CURRENT_TIMESTAMP not null on update CURRENT_TIMESTAMP,
    first_name    varchar(50)                         null,
    last_name     varchar(80)                         null,
    email_address varchar(255)                        not null,
    token         varchar(255)                        not null
);
