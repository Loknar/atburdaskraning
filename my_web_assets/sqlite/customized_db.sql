-- Updated sqlite database for events website
-- By Sveinn Floki Gudmundsson

DROP TABLE IF EXISTS 'users';
DROP TABLE IF EXISTS 'news';
DROP TABLE IF EXISTS 'events';
DROP TABLE IF EXISTS 'registrations';

-- Table structure for table 'users'
CREATE TABLE 'users' (
  'user_id' integer NOT NULL,
  'name' text,
  'post' text NOT NULL UNIQUE,
  'pass' text,
  'privileges' integer,
  'phone_nr' text,
  PRIMARY KEY ('user_id')
);
-- insert admin user into table 'users'
INSERT INTO 'users' ('name','post','pass','privileges') VALUES ('Administrator','admin','fe9aa4b6a65c09610db921d85af5eb4466779359c2a744985b1e3e8e9a1c32d1',2);

-- Table structure for table 'news'
CREATE TABLE 'news' (
  'news_id' integer NOT NULL,
  'title' text,
  'description' text,
  'date_created' integer,
  'date_edited' integer,
  'creator' integer,
  'last_editor' integer,
  PRIMARY KEY ('news_id')
);
-- insert a dummy event into table 'news'
INSERT INTO 'news' ('title','description','date_created','date_edited','creator','last_editor') VALUES ('Dummy frétt','Lýsing fréttar eitthvað awesome, admin gerði þessa frétt :D',1385971200,1387296000,1,1);

-- Table structure for table 'events'
CREATE TABLE 'events' (
  'event_id' integer NOT NULL,
  'title' text,
  'start' integer,
  'end' integer,
  'registration_start' integer,
  'registration_end' integer,
  'description' text,
  'location' text,
  'seats' integer,
  'date_created' integer,
  'date_edited' integer,
  'creator' integer,
  'last_editor' integer,
  'open_mod_registration' integer,
  PRIMARY KEY ('event_id')
);
-- insert a dummy event into table 'events'
INSERT INTO 'events' ('title','start','end','registration_start','registration_end','description','location','seats','date_created','date_edited','creator','last_editor') VALUES ('Haustmisserispróf',1385971200,1387296000,1385971200,1387296000,'Haustmisserispróf fara fram dagana 2. - 17. desember.','Háskóli Íslands',0,1385971200,1387296000,1,1);

-- Table structure for table 'registrations'
CREATE TABLE 'registrations' (
  'registration_id' integer NOT NULL,
  'user_id' integer,
  'event_id' integer,
  'timing' integer,
  PRIMARY KEY ('registration_id')
);
-- register the admin user to the dummy event
INSERT INTO 'registrations' ('user_id','event_id','timing') VALUES (1,1,1382375768);


