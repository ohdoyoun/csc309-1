/* This table represents all the user accounts on the website. */
create table Accounts(
	aID int not null auto_increment,
	email varchar(50) not null,
	pass varchar(16) not null,
	admin boolean default 0,
	Primary Key (aID),
	Unique (email)
);

/* This table represents all the macro tags on the website. */
create table MacroTags(
	macroID int not null auto_increment,
	macroName varchar(50) not null,
	Primary Key (macroID),
	Unique (macroName)
);

/* This table represents all the micro tags on the website. */
create table MicroTags(
	microID int not null auto_increment,
	microName varchar(50) not null,
	Primary Key (microID),
	Unique (microName)
);

/* This table represents all the projects on the website. */
create table Projects(
	pID int not null auto_increment,
	pName varchar(50) not null,
	goal decimal(10, 2) not null,
	startDate Date not null,
	endDate Date not null,
	detailsURL varchar(75) not null,
	Primary Key (pID),
	Unique (pName),
	Constraint chkDates check (startDate < endDate)
);

/* This table represents all the user profiles on the website. */
create table Profiles(
	uName varchar(25) not null,
	aID int not null,
	fName varchar(50) not null,
	lName varchar(50) not null,
	age int,
	gender enum('male', 'female', 'other'),
	Primary Key (uName),
	Foreign Key (aID) References Accounts(aID)
);

/* This table represents users that are initiators of projects. */
create table Initiators(
	pID int not null,
	uName varchar(25) not null,
	Foreign Key (pID) References Projects(pID),
	Foreign Key (nName) References Profiles(uName),
	Primary Key (pID, uName)
);

/* This table represents macro tags that are linked to projects. */
create table MacroProjects(
	macroID int not null,
	pID int not null,
	Foreign Key (pID) References Projects(pID),
	Foreign Key (macroID) References MacroTags(macroID),
	Primary Key (macroID, pID)
);

/* This table represents micro tags that are linked to projects. */
create table MicroProjects(
	microID int not null,
	pID int not null,
	Foreign Key (pID) References Projects(pID),
	Foreign Key (microID) References MicroTags(microID),
	Primary Key (microID, pID)
);

/* This table represents macro tags that are linked to user profiles. */
create table MacroProfiles(
	macroID int not null,
	uName varchar(25) not null,
	Foreign Key (uName) References Profiles(uName),
	Foreign Key (macroID) References MacroTags(macroID),
	Primary Key (macroID, uName)
);

/* This table represents micro tags that are linked to user profiles. */
create table MicroProfiles(
	microID int not null,
	uName varchar(25) not null,
	Foreign Key (uName) References Profiles(uName),
	Foreign Key (microID) References MicroTags(microID),
	Primary Key (microID, uName)
);

/* This table represents micro tags that are children of macro tags. */
create table TagInheritance(
	macroID int not null,
	microID int not null,
	Foreign Key (macroID) References MacroTags(macroID),
	Foreign Key (microID) References MicroTags(microID),
	Primary key (macroID, microID)
);

/* This table represents transfers of website credit between users and projects.
Note: 	
	- funds can be a positive number or a negative number.
	- tDate and tTime are calculated using SQL date functions at time of
	  call to Insert function. http://www.w3schools.com/sql/sql_dates.asp
 */
create table Transfers(
	tDate date not null,
	tTime time not null,
	pID int not null,
	uName varchar(25) not null,
	funds decimal(10, 2) not null,
	Foreign Key (pID) References Projects(pID),
	Foreign Key (uName) References Profiles(uName),
	Primary Key (tDate, tTime, pID, uName)
	
);

/* This table represents transfers from actual money to website credit.
Note: 	
	- wFunds can be a positive number or a negative number.
	- wtDate and wtTime are calculated using SQL date functions at time 
	  of call to Insert function. http://www.w3schools.com/sql/sql_dates.asp
 */
create table WalletTransfers(
	wtDate date not null,
	wtTime time not null,
	uName varchar(25) not null,
	wFunds decimal(10, 2) not null,
	Foreign Key (uName) References Profiles(uName),
	Primary Key (wtDate, wtTime, uName)
	
);
