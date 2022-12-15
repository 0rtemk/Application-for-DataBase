insert into applicationbd.Contragents (Contr_name, Adress, Phone, Comments) values 
('Александра Ивановна', 'Москва, ул. Московская', '89998887777', 'сотрудник месяца'),
('Мария Семёновна', 'Москва, ул. Речная', '89981234567', null),
('Пётр Васильевич', 'Дмитров, ул. Советская', '89977654321', null),
('Валерия Ивановна', 'Дубна, пр-кт Мира', '89960000000', 'постоянные опоздания'),
('Алексей Сергеевич', 'Воронеж, ул. Профессиональная', '88005553535', null);

insert into applicationbd.Groups (Gr_name, Comments) values 
('молочные', 'от коровы'),
('крупы', 'зерно'),
('сладкое', 'шоколадки'),
('булочки', 'из зерна');

insert into applicationbd.Taxes (Tax_name, Tax_value, Comments) values
('ндс', 0.1400, null),
('транспорт', 0.0500, null),
('роскошь', 0.0700, 'слишком дорогие');

insert into applicationbd.Managers (Man_name, Persent, Hire_day, Comments, Parent_id) values 
('Свелтана Артёмовна', 0.1500, '2001-01-01', null, null),
('Юлия Сергеевна', 0.1050, '2002-10-10', 'Выписать премию', null),
('Наталья Семёновна', 0.1200, '2005-04-05', null, 1),
('Варвара Петровна', 0.0500, '2012-12-10', 'Работник месяца', 3),
('Елизавета Макаровна', 0.0300, '2013-03-09', null, 1),
('Антон Сергеевич', 0.0400, '2014-04-06', 'Уволен', null);

insert into applicationbd.Products (Group_id, Prod_name, Descriptions, Expire_time) values 
(1, 'молоко', '2.5%', 12),
(1, 'молоко', '3.2%', 12),
(1, 'творожок', 'черника', 8),
(1, 'творожок', 'малина', 8),
(2, 'рис', 'круглозерный', 11),
(2, 'рис', 'длиннозерный', 11),
(2, 'гречка', 'ядрица', 11),
(3, 'шоколадка', 'аленка', 6),
(3, 'шоколадка', 'ритер спорт', 6),
(3, 'шоколадка', 'альпен голд', 6),
(3, 'шоколадка', 'милка', 6),
(3, 'батончик', 'сникерс', 7),
(3, 'батончик', 'пикник', 7),
(3, 'батончик', 'твикс', 7),
(3, 'батончик', 'баунти', 7),
(4, 'булочка', 'с сахаром', 0.5),
(4, 'булочка', 'с лимоном', 0.5),
(4, 'булочка', 'с сыром', 0.5),
(4, 'хлеб', 'белый', 0.5),
(4, 'хлеб', 'черный', 0.5);

insert into applicationbd.Prices (Prod_id, DayFrom, DateTo, P_value) values 
(1, '2022-01-01', '2022-03-03', 100),
(1, '2022-04-03', null, 110),
(2, '2022-01-01', '2022-03-03', 110),
(2, '2022-03-04', null, 120),
(3, '2022-03-03', '2022-04-04', 1),
(3, '2022-04-05', null, 1.1),
(4, '2022-03-03', '2022-04-03', 1),
(4, '2022-04-05', null, 1.1),
(5, '2022-03-03', '2022-04-03', 1),
(5, '2022-12-12', null, 1),
(6, '2022-03-03', '2022-04-03', 1.2),
(6, '2022-05-09', null, 1.2),
(7, '2022-03-03', null, 90),
(8, '2022-01-01', '2022-04-04', 60),
(8, '2022-04-05', null, 80),
(9, '2022-01-01', '2022-04-04', 80),
(9, '2022-04-05', null, 100),
(10, '2022-01-01', '2022-04-04', 50),
(10, '2022-04-05', null, 80),
(11, '2022-01-01', '2022-04-04', 1),
(11, '2022-04-05', null, 1.25),
(12, '2022-01-01', '2022-03-03', 40),
(12, '2022-03-04', null, 50),
(13, '2022-01-01', '2022-03-03', 40),
(13, '2022-03-04', null, 50),
(14, '2022-01-01', '2022-03-03', 40),
(14, '2022-03-04', null, 50),
(15, '2022-01-01', '2022-03-03', 40),
(15, '2022-03-04', null, 50),
(16, '2022-10-12', null, 30),
(17, '2022-10-12', null, 40),
(18, '2022-10-12', null, 50),
(19, '2022-10-12', null, 25),
(20, '2022-10-12', null, 34);

insert into applicationbd.Incoming (Prod_id, Tax_id, Contr_id, Man_id, Inc_date, Quantity, Cost) values 
(1, 1, 1, 1, '2022-02-02', 5, 10),
(3, 1, 1, 1, '2022-02-02', 100, 12),
(4, 1, 1, 2, '2022-02-02', 50, 23),
(5, 2, 3, 3, '2022-02-02', 60, 10),
(6, 2, 3, 3, '2022-02-02', 100, 40),
(7, 2, 3, 4, '2022-02-02', 30, 34),
(10, 1, 2, 5, '2022-03-03', 500, 90),
(11, 1, 2, 5, '2022-03-03', 500, 10),
(12, 1, 2, 5, '2022-04-12', 500, 56),
(13, 1, 2, 5, '2022-04-12', 500, 34),
(18, 1, 4, 6, '2022-03-05', 100, 53),
(19, 1, 4, 6, '2022-01-05', 70, 12),
(20, 1, 4, 6, '2022-01-05', 90, 43);

insert into applicationbd.Outgoing (Prod_id, Tax_id, Contr_id, Man_id, Out_date, Quantity, Cost) values 
(1, 1, 1, 1, '2022-02-02', 5, 10),
(3, 1, 1, 1, '2022-02-02', 100, 12),
(4, 1, 1, 2, '2022-02-02', 50, 23),
(5, 2, 3, 3, '2022-02-02', 60, 10),
(6, 2, 3, 3, '2022-02-02', 100, 40),
(7, 2, 3, 4, '2022-02-02', 30, 34),
(10, 1, 2, 5, '2022-03-03', 500, 90),
(11, 1, 2, 5, '2022-03-03', 500, 10),
(12, 1, 2, 5, '2022-04-12', 500, 56),
(13, 1, 2, 5, '2022-04-12', 500, 34),
(18, 1, 4, 6, '2022-03-05', 100, 53),
(19, 1, 4, 6, '2022-01-05', 70, 12),
(20, 1, 4, 6, '2022-01-05', 90, 43);

insert into applicationbd.users(email, login, password, grade) values 
('admin@applicationbd.com', 'Admin', 'admin', 'admin'),
('viewer@applicationbd.com', 'viewer', 'viewer', 'viewer');