create table if not exists employees (
    id int auto_increment primary key ,
    employee_id varchar(100) not null,
    fullname varchar(255) not null,
    email varchar(255) unique not null,
    age int,
    gender enum('Male', 'Female', 'Other') not null,
    dob date,
    phoneNo varchar(15),
    address text,
    department varchar(100),
    employee_type enum('Full-time', 'Part-time', 'Contract'),
    basic_salary decimal(10, 2),
    photo BLOB
);

insert into employees (employee_id, fullname, email, age, gender, dob, phoneNo, address, department, employee_type, basic_salary) 
values ('admin123', 'Admin Max', 'admin@gmail.com', 30, 'Male', '1994-04-06', 9876543210, 'New York', 'HR', 'Full-time', 2000000 );

alter table employees add column is_admin boolean default 0;

update employees set is_admin = 1 where employee_id = 'admin123'; 

create table if not exists tasks (
    id int auto_increment primary key,
    title varchar(255) not null,
    description text not null,
    assigned_to int not null,
    status enum('Pending', 'In progress', 'Completed') default 'Pending',
    constraint fk_task foreign key (assigned_to) references employees(id)
);

alter table tasks add column created_at timestamp default current_timestamp;

create table if not exists leaves (
    id int auto_increment primary key,
    employee_id int not null,
    start_date date not null,
    end_date date not null,
    reason text not null,
    status enum('Pending', 'Approved', 'Rejected') default 'Pending',
    foreign key (employee_id) references employees(id)
);





