CREATE TABLE MEMBER(
    ID int(8) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    NAME varchar(64),
    KANA varchar(64),
    TEL varchar(16),
    MAIL varchar(32),
    YEAR int(4),
    SEX int(2),
    MAGAGINE int(1)
);

/*
CREATE TABLE members(
    id int(8) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    name varchar(64),
    kana varchar(64),
    tel varchar(16),
    mail varchar(255),
    year int(4),
    gender int(2),
    is_magazine int(1)
);
 */