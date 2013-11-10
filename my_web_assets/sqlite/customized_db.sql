-- Updated sqlite database for events website
-- By Sveinn Floki Gudmundsson

DROP TABLE IF EXISTS 'events';
DROP TABLE IF EXISTS 'users';
DROP TABLE IF EXISTS 'registrations';

-- Table structure for table 'events'
CREATE TABLE 'events' (
  'event_id' integer NOT NULL,
  'title' text,
  'start' numeric,
  'end' numeric,
  'registration_start' numeric,
  'registration_end' numeric,
  'description' text,
  'location' text,
  'seats' numeric,
  PRIMARY KEY ('event_id')
);
-- insert a dummy event into table 'events'
INSERT INTO 'events' ('title','start','end','registration_start','registration_end','description','location','seats') VALUES ('Haustmisserispróf',1385971200,1387296000,1385971200,1387296000,'Haustmisserispróf fara fram dagana 2. - 17. desember.','Háskóli Íslands',0);

-- Table structure for table 'users'
CREATE TABLE 'users' (
  'user_id' integer NOT NULL,
  'name' text,
  'post' text,
  'pass' text,
  'privileges' numeric,
  PRIMARY KEY ('user_id')
);
-- insert one admin user into table 'users'
INSERT INTO 'users' ('name','post','pass','privileges') VALUES ('Sveinn Flóki Guðmundsson','sfg6','a130de8848ff390cdd516b226b0d130c',1);

-- Table structure for table 'registrations'
CREATE TABLE 'registrations' (
  'registration_id' integer NOT NULL,
  'user_id' integer,
  'event_id' integer,
  'timing' numeric,
  PRIMARY KEY ('registration_id')
);
-- register the admin user to the dummy event
INSERT INTO 'registrations' ('user_id','event_id','timing') VALUES (1,1,1382375768);


