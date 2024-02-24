<?php
        //create database serialsDB

         $tableItem="create table Item
        (
            id int not null AUTO_INCREMENT primary key,
            name varchar(60) UNIQUE not null,
            price double not null,
            imagepath varchar(255) not null unique,
            description varchar(100)
        );";

        $tableClient="create table Client
        (
            id int not null AUTO_INCREMENT primary key,
            login varchar(30) not null unique,    
            password varchar(128) not null,
            imagepath varchar(255),
            roleid int,
                foreign key(roleid) references Roles(id) on delete cascade, 
            email varchar(30) not null unique
        );";

        // $table2="create table Client
        // (
        //     id int not null AUTO_INCREMENT primary key,
        //     login varchar(30) not null unique,    
        //     password varchar(128) not null,
        //     imagepath varchar(255),
        //     roleid int not null,
        //     email varchar(30) not null unique
        // );";

        //*-*
        $tableCart="create table Cart(
            id int not null AUTO_INCREMENT primary key,  
            fk_item int,
                foreign key(fk_item) references Item(id) on delete cascade, 
            fk_client int,
                foreign key(fk_client) references Client(id) on delete cascade
        );";

        $tableRoles="create table Roles(
            id int not null AUTO_INCREMENT primary key,  
            name varchar(60) UNIQUE not null
        );";

        include_once("pages/classes.php");
        $con=Tools::connect();

        $con->exec($tableItem);
        $con->exec($tableRoles);
        $con->exec($tableClient);
        $con->exec($tableCart);

// INSERT INTO `item`(`name`, `price`, `imagepath`, `description`) 
// VALUES 
// ('Зачарованные',12,'images/charmed.png','Три сестры и магия...'),
// ('Игра престолов',200,'images/gameoftrones.jpg','Фентези'),
// ('Дом дракона',150,'images/houseofdragon.jpg','Вторая часть'),
// ('Властелин колец',999,'images/lordoftherings.jpg','Фродо и его друзья...'),
// ('Метод',63,'images/method.jpg','Только безумцы способны...'),
// ('Наруто',54,'images/naruto.jpg','Нашумевшое Аниме...'),
// ('Видеть',28,'images/see.jpg','Что если люди лишаться зрения...'),
// ('Шерлок',33,'images/sherlock-bbc-poster.jpg','Дедукция - наше всё...'),
// ('Ходячие мертвецы',62,'images/walkingdead.jpg','Они восстали из мёртвых...'),
// ('Ведьмак',78,'images/witcher.jpeg','Снято по легендарной игре...')

// INSERT INTO `roles`(`id`, `name`) 
// VALUES 
// ('1','radmin'),
// ('2','ruser')
?>