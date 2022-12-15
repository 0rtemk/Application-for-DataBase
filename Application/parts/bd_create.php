<?php
#region createBD
//create BD
$bd_connect->query("
    CREATE DATABASE IF NOT EXISTS applicationbd
");
$bd_connect = new mysqli($host, $user_bd, $pass_bd, $name_bd);
//table Users
$bd_connect->query("
    CREATE TABLE IF NOT EXISTS users (
        user_id INT(5) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        email VARCHAR(100) UNIQUE not null,
        login VARCHAR(30) UNIQUE not null,
        password VARCHAR(50) not null,
        grade VARCHAR(30) default 'viewer'
    )
");
//table Contragents
$bd_connect->query("
    create table if not exists Contragents (
        Contr_id int(5) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        Contr_name varchar(30) not null,
        Adress varchar(150) not null,
        Phone varchar(30) not null,
        Comments varchar(150)
    )
");
//table Groups
$bd_connect->query("
    create table if not exists Groups(
        Group_id int(5) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        Gr_name varchar(50) not null,
        Comments varchar(150)
    )
");
//table Taxes
$bd_connect->query("
    create table if not exists Taxes(
        Tax_id int(5) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        Tax_name varchar(50) not null,
        Tax_value decimal(5,4) not null,
        Comments varchar(100)
    )
");
//table Managers
$bd_connect->query("
    create table if not exists Managers(
        Man_id int(5) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        Man_name varchar(30) not null,
        Persent decimal(5,4) not null,
        Hire_day date not null,
        Comments varchar(150),
        Parent_id int(5) UNSIGNED
    )
");
//table Products
$bd_connect->query("
    create table if not exists Products(
        Prod_id int(5) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        Group_id int(5) UNSIGNED,
        Prod_name varchar(50) not null,
        Descriptions varchar (150) not null,
        Expire_time int(4)
    )
");
//table Incoming
$bd_connect->query("
    create table if not exists Incoming(
        Inc_id int(5) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        Prod_id int(5) UNSIGNED,
        Tax_id int(5) UNSIGNED,
        Contr_id int(5) UNSIGNED,
        Man_id int(5) UNSIGNED,
        Inc_date date not null,
        Quantity int(7) not null,
        Cost decimal(7,2) not null
    )
");
//table Outgoing
$bd_connect->query("
    create table if not exists Outgoing(
        Out_id int(5) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        Prod_id int(5) UNSIGNED,
        Tax_id int(5) UNSIGNED,
        Contr_id int(5) UNSIGNED,
        Man_id int(5) UNSIGNED,
        Out_date date not null,
        Quantity int(7) not null,
        Cost decimal(7,2) not null
    )
");
//table Prices
$bd_connect->query("
    create table if not exists Prices(
        Prod_id int(5) UNSIGNED AUTO_INCREMENT,
        DayFrom date not null,
        DateTo date,
        P_value decimal(7,2) not null,
        constraint p_id_k primary key(Prod_id, DayFrom)
    )
");
#endregion

#region primary keys
//primary keys
$bd_connect->query("
    alter table Managers add constraint managers_k2 foreign key (Parent_id) references Managers(Man_id)
");
$bd_connect->query("
    alter table Products add constraint products_k1 foreign key (Group_id) references Groups(Group_id)
");
$bd_connect->query("
    alter table Prices add constraint prices_k1 foreign key (Prod_id) references Products(Prod_id)
");
$bd_connect->query("
    alter table Outgoing add constraint outgoing_k1 foreign key (Prod_id) references Products(Prod_id)
");
$bd_connect->query("
    alter table Outgoing add constraint outgoing_k2 foreign key (Tax_id) references Taxes(Tax_id)
");
$bd_connect->query("
    alter table Outgoing add constraint outgoing_k3 foreign key (Contr_id) references Contragents(Contr_id)
");
$bd_connect->query("
    alter table Outgoing add constraint outgoing_k4 foreign key (Man_id) references Managers(Man_id)
");
$bd_connect->query("
    alter table Incoming add constraint incoming_k1 foreign key (Prod_id) references Products(Prod_id)
");
$bd_connect->query("
    alter table Incoming add constraint incoming_k2 foreign key (Tax_id) references Taxes(Tax_id)
");
$bd_connect->query("
    alter table Incoming add constraint incoming_k3 foreign key (Contr_id) references Contragents(Contr_id)
");
$bd_connect->query("
    alter table Incoming add constraint incoming_k4 foreign key (Man_id) references Managers(Man_id)
");
#endregion

#region functions
//functions
//возвращает кол-во parentId у менеджеров
$bd_connect->query("
    create function ParentIdCount_func(P_id int)
    returns int
    begin
        declare ParentIdCount int default 0;
        select count(Parent_id) into ParentIdCount from Managers
        where Parent_id = P_id;
        return ParentIdCount;
    end;
");
//возвращает количество товара
$bd_connect->query("
    create function ProdSum_func(Pr_id int)
    returns int
    begin
        declare bought int; 
        declare sold int;
        select quantity into bought from incoming where prod_id = Pr_id;
        select quantity into sold from outgoing where prod_id = Pr_id;
        return bought - sold;
    end;

");
#endregion

#region triggers
//triggers
//Запретить удаление менеджера с parentId != null
$bd_connect->query("
    create trigger `manDelete`
    before delete on `Managers`
    for each row 
    begin
        if (OLD.Parent_id is not NULL) then
            signal sqlstate '45000' set message_text = 'manDeleteTrigger Error: Trying to delete manager with parent id';
        end if;
    end;
");
//Запредить добавлять/изменять менеджера, если у parentId > 2 подчиненных
$bd_connect->query("
    create trigger `manUpdate`
    before update on `Managers`
    for each row
    begin
        if (ParentIdCount_func(NEW.Parent_id) > 2) then
            signal sqlstate '45000' set message_text = 'manUpdateTrigger Error: Trying to update manager where parent has more than two employees';
        end if;
    end;  
");
$bd_connect->query("
    create trigger `manInsert`
    before insert on `Managers`
    for each row
    begin
        if (ParentIdCount_func(NEW.Parent_id) > 2) then
            signal sqlstate '45000' set message_text = 'manInsertTrigger Error: Trying to insert manager where parent has more than two employees';
        end if;
    end;
");
//Разрешает продавать только те товары, которые есть в наличии
$bd_connect->query("
    create trigger `outgoingInsert`
    before insert on `Outgoing`
    for each row
    begin
        declare bought int;
        select quantity into bought from incoming where Prod_id = new.Prod_id; 
        if (bought - new.quantity < 0) then 
            signal sqlstate '45000' set message_text = 'outgoingInsertTrigger Error: Trying to sell more products than what is available';
        end if;
    end;
");
$bd_connect->query("
    create trigger `outgoingUpdate`
    before update on `Outgoing`
    for each row
    begin
        declare bought int;
        select quantity into bought from incoming where Prod_id = new.Prod_id; 
        if (bought - new.quantity < 0) then 
            signal sqlstate '45000' set message_text = 'outgoingUpdateTrigger Error: Trying to sell more products than what is available';
        end if;
    end;
");
//Запредить удалять товар, который есть в наличии
$bd_connect->query("
    create trigger `productsDelete`
    before delete on `Products`
    for each row
    begin
        if (ProdSum_func(old.prod_id) > 0) then 
            signal sqlstate '45000' set message_text = 'productsDeleteTrigger Error: Trying to delete product that is available';
        else
            delete from prices where Prod_id = old.Prod_id;
            delete from outgoing where Prod_id = old.Prod_id;
            delete from incoming where Prod_id = old.Prod_id;
        end if;
    end;
");
//Запретить ставить DayFrom < DateTo в Prices
$bd_connect->query("
    create trigger `pricesInsert`
    before insert on `Prices`
    for each row
    begin
        if (new.DateTo is not null) then
            if (date_format(new.DateTo, '%Y%m%d') - date_format(new.DayFrom, '%Y%m%d') < 0) then
                signal sqlstate '45000' set message_text = 'pricesInsertTrigger Error: Trying to use DayFrom > DateTo';
            end if;
        end if;
    end;
");
$bd_connect->query("
    create trigger `pricesUpdate`
    before update on `Prices`
    for each row
    begin
        if (new.DateTo is not null) then
            if (date_format(new.DateTo, '%Y%m%d') - date_format(new.DayFrom, '%Y%m%d') < 0) then
                signal sqlstate '45000' set message_text = 'pricesUpdateTrigger Error: Trying to use DayFrom < DateTo';
            end if;
        end if;
    end;
");
#endregion

#region fillbd
//fill bd
$db = new PDO("mysql:host=$host;dbname=$name_bd", $user_bd, $pass_bd);
try{
    $dir = $url = __DIR__.'/fillbd.sql';
    $sql = file_get_contents($dir);
    $qr = $db->exec($sql);
} catch (Exception $e){
    echo "<script>console.log(\"{$e->getMessage()}\")</script>";
}  
$db = null;
#endregion
?>
