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