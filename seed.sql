insert into users( name, email, password, type, created_at, updated_at) values ('Veselina Customer', 'customer@abv.bg', '$2y$10$4N6jfcAfHl.3a5Q.1YYX0..WuGMEwsDe6.cffyh9iI.sfzv5z7uRu', 'CUSTOMER', now(), now());
insert into users( name, email, password, type, created_at, updated_at) values ('Veselina Dentist', 'dentist@abv.bg', '$2y$10$4N6jfcAfHl.3a5Q.1YYX0..WuGMEwsDe6.cffyh9iI.sfzv5z7uRu', 'DENTIST', now(), now());
insert into users( name, email, password, type, created_at, updated_at) values ('Veselina Surgeon', 'surgeon@abv.bg', '$2y$10$4N6jfcAfHl.3a5Q.1YYX0..WuGMEwsDe6.cffyh9iI.sfzv5z7uRu', 'SURGEON', now(), now());

insert into work_schedules(dentist_id, work_date, start_time, end_time) VALUES ((select id from users where email = 'dentist@abv.bg'), now(), '12:00', '22:00');
insert into work_schedules(dentist_id, work_date, start_time, end_time) VALUES ((select id from users where email = 'dentist@abv.bg'), now() + INTERVAL 1 DAY, '08:00', '17:00');
insert into work_schedules(dentist_id, work_date, start_time, end_time) VALUES ((select id from users where email = 'dentist@abv.bg'), now() + INTERVAL 3 DAY, '12:00', '22:00');
insert into work_schedules(dentist_id, work_date, start_time, end_time) VALUES ((select id from users where email = 'dentist@abv.bg'), now() + INTERVAL 6 DAY, '08:00', '17:00');
insert into work_schedules(dentist_id, work_date, start_time, end_time) VALUES ((select id from users where email = 'dentist@abv.bg'), now() + INTERVAL 7 DAY, '12:00', '22:00');


insert into appointments(customer_id, dentist_id, appointment_date, appointment_time, created_at, updated_at) values ((select id from users where email = 'customer@abv.bg'),(select id from users where email = 'dentist@abv.bg'), now() + INTERVAL 1 DAY,'13:30',now(),now());
insert into appointments(customer_id, dentist_id, appointment_date, appointment_time, created_at, updated_at) values ((select id from users where email = 'customer@abv.bg'),(select id from users where email = 'dentist@abv.bg'),now() + INTERVAL 1 DAY,'16:30',now(),now());