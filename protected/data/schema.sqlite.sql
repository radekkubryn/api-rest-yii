CREATE TABLE tbl_cities
(
	id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
	country VARCHAR(128) NOT NULL,
	city VARCHAR(128) NOT NULL,
	accentcity VARCHAR(128) NOT NULL,
	region VARCHAR(128) NOT NULL,
	population INTEGER NOT NULL,
	latitude VARCHAR(128) NOT NULL,
	longitude VARCHAR(128) NOT NULL
);
