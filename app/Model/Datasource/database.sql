/* This table represents all the user accounts on the website. */
create table users(
	id int not null auto_increment,
	username varchar(25) not null,
	password varchar(255) not null,
	email varchar(50) not null,
	role varchar(20) default 'User',
	Primary Key (id),
	Unique (username),
	Unique (email)
);


/* This table represents all the user profiles on the website. */
create table profiles(
   	id int not null auto_increment,
   	user_id int not null,
	first_name varchar(50) not null,
	last_name varchar(50) not null,
	dob date,
	gender varchar(15),
   	country varchar(50),
   	province varchar(50),
   	city varchar(100),
   	address varchar(100),
   	postal_code varchar(20),
   	phone_number varchar(10),
   	bio varchar(2000),
	Primary Key (id),
	Foreign Key (user_id) References users(id)
); 

/* This table represents all the statuses a project can have. */
create table status_tags(
	id int not null auto_increment,
	name varchar(20),
	Primary Key (id)
);

/* The entries into the status_tags table.*/
insert into status_tags (name) values ('Active');
insert into status_tags (name) values ('Completed');  	
insert into status_tags (name) values ('Uncompleted');
insert into status_tags (name) values ('Paused');
insert into status_tags (name) values ('Cancelled');

/* This table represents all the projects on the website. 
Note:	details is a file name that can be parsed and displayed.
*/
create table projects(
	id int not null auto_increment,
	project_name varchar(50) not null,
	goal decimal(10, 2) not null,
	start_date timestamp default CURRENT_TIMESTAMP,
	end_date timestamp not null,
	status_tag_id int default 1,
	details varchar(75) not null,
	Primary Key (id),
	Unique(project_name),
	Foreign Key (status_tag_id) References status_tags(id),
	CHECK (start_date < end_date)
);

/* This table represents users that are initiators of projects. */
create table initiators(
	id int not null auto_increment,
	project_id int not null,
	user_id int not null,
	Foreign Key (project_id) References projects(id),
	Foreign Key (user_id) References users(id),
	Primary Key (id)
);

/* This table represents all the macro tags on the website. */
create table macro_tags(
	id int not null auto_increment,
	name varchar(50) not null,
	Primary Key (id),
	Unique (name)
);

/* The etnries into the macro_tags table. */
insert into macro_tags (name) values ('Technology');
insert into macro_tags (name) values ('Business');
insert into macro_tags (name) values ('Nature');
insert into macro_tags (name) values ('Non-Profit');
insert into macro_tags (name) values ('Health');
insert into macro_tags (name) values ('Education');
insert into macro_tags (name) values ('Finance');
insert into macro_tags (name) values ('Travel');
insert into macro_tags (name) values ('Personal');
insert into macro_tags (name) values ('Fitness');
insert into macro_tags (name) values ('Politics');
insert into macro_tags (name) values ('Art');
insert into macro_tags (name) values ('Comics');
insert into macro_tags (name) values ('Crafts');
insert into macro_tags (name) values ('Dance');
insert into macro_tags (name) values ('Design');
insert into macro_tags (name) values ('Fashion');
insert into macro_tags (name) values ('Film & Video');
insert into macro_tags (name) values ('Food');
insert into macro_tags (name) values ('Games');
insert into macro_tags (name) values ('Music');
insert into macro_tags (name) values ('Journalism');
insert into macro_tags (name) values ('Photography');
insert into macro_tags (name) values ('Publishing');
insert into macro_tags (name) values ('Theater');


/* This table represents all the micro tags on the website. */
create table micro_tags(
	id int not null auto_increment,
	name varchar(50) not null,
	Primary Key (id),
	Unique (name)
);

/* This table represents macro tags that are linked to projects. */
create table project_macro_tags(
	id int not null auto_increment,
	macro_tag_id int not null,
	project_id int not null,
	Foreign Key (project_id) References projects(id),
	Foreign Key (macro_tag_id) References macro_tags(id),
	Primary Key (id)
);

/* This table represents micro tags that are linked to projects. */
create table project_micro_tags(
	id int not null auto_increment,
	micro_tag_id int not null,
	project_id int not null,
	Foreign Key (project_id) References projects(id),
	Foreign Key (micro_tag_id) References micro_tags(id),
	Primary Key (id)
);

/* This table represents macro tags that are linked to user profiles. */
create table profile_macro_tags(
	id int not null auto_increment,
	macro_tag_id int not null,
	profile_id int not null,
	Foreign Key (profile_id) References projects(id),
	Foreign Key (macro_tag_id) References macro_tags(id),
	Primary Key (id)
);

/* This table represents micro tags that are linked to user profiles. */
create table profile_micro_tags(
	id int not null auto_increment,
	micro_tag_id int not null,
	profile_id int not null,
	Foreign Key (profile_id) References profiles(id),
	Foreign Key (micro_tag_id) References micro_tags(id),
	Primary Key (id)
);

/* This table represents transfers of website credit between users and projects.
Note: 	
	- funds can be a positive number or a negative number.
	- tDate and tTime are calculated using SQL date functions at time of
	  call to Insert function. http://www.w3schools.com/sql/sql_dates.asp
 */
create table transactions(
	id int not null auto_increment,
	update_date timestamp default CURRENT_TIMESTAMP,
	project_id int not null,
	user_id int not null,
	funds decimal(10, 2) not null,
	Foreign Key (project_id) References projects(id),
	Foreign Key (user_id) References users(id),
	Primary Key (id)
	
);

/* This table represents the possible payment methods. */
create table payment_methods(
	id int not null auto_increment,
	name varchar(25),
	Primary Key (id)
);

/* This table represents the wallets of users. */
create table wallets(
	id int not null auto_increment,
	user_id int not null,
	payment_method_id int,
	account_number varchar(50),
	Primary Key (id),
	Foreign Key (user_id) References users(id),
	Foreign Key (payment_method_id) References payment_methods(id)
	
);

/* This table represents transfers from actual money to website credit.
 */
create table wallet_transactions(
	id int not null auto_increment,
	update_date timestamp default CURRENT_TIMESTAMP,
	wallet_id int not null,
	funds decimal(10, 2) not null,
	Foreign Key (wallet_id) References wallets(id),
	Primary Key (id)
	
);

/*This table represents the relations between the macro tags and micro tags. 
Note: 	This allows for the creation of the communities and for searching.*/
create table communities(
	id int not null auto_increment,
	macro_tag_id int not null,
	micro_tag_id int not null,
	Foreign Key (macro_tag_id) References macro_tags(id),
	Foreign Key (micro_tag_id) References micro_tags(id),
	Primary key (id)
);

/*Reputation system table for users*/
create table likes(
    id int not null auto_increment,
    onUser int not null,
    fromUser int not null,
    choice int not null,
    Foreign Key (fromUser) References users(id),
    Foreign Key (onUser) References users(id),
    Primary Key (id)
);

/*Testimonials table for projects from users*/
create table testimonials(
	id int not null auto_increment,
	project_id int not null,
	user_id int not null,
	testimony varchar(1000) not null,
	Foreign Key (project_id) References projects(id),
	Foreign Key (user_id) References users(id),
	Primary Key (id)
);

/* Posts for the Community Walls. */
create table posts(
	id int not null auto_increment,
	community_id int not null,
	user_id int not null,
	details varchar(1000) not null,
	created timestamp default CURRENT_TIMESTAMP,
	Primary Key(id),
	Foreign Key (community_id) References communities(id),
	Foreign Key (user_id) References users(id)
);

/* Table to save users notification preferences */
create table notifications(
	user_id int not null,
	newCommentsBacked tinyint not null default 0,
	newUpdatesBacked tinyint not null default 0,
	newPledgesStarted tinyint not null default 0,
	newCommentsStarted tinyint not null default 0,
	newProjects tinyint not null default 0,
	Foreign Key (user_id) References users(id),
	Primary Key(user_id)
);
