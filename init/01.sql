CREATE TABLE transaction (
  id int(11) NOT NULL AUTO_INCREMENT,
  date date NOT NULL,
  type varchar(10) NOT NULL,
  value int(11) NOT NULL,
  PRIMARY KEY (id)
);