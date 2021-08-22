CREATE TABLE user(
    id_user int not null primary key auto_increment,
	name_user varchar(200),
    email_user varchar(50),
    password_user varchar(200),
    phone_user char(13),
    image_user varchar(200),
    token_user varchar(200),
    token_expired_user date,
	role_user enum('admin','user'),
    created_at_user timestamp not null default now(),
    updated_at_user timestamp not null default now() on update now()
);

INSERT INTO `user` (`id_user`, `name_user`, `email_user`, `password_user`, `phone_user`, `image_user`, `token_user`, `token_expired_user`, `role_user`, `created_at_user`, `updated_at_user`) VALUES (NULL, 'TInalah Admin', 'tinalah@mail.com', '$2b$10$j2jemiME/GY7nYhWX9xb1eVrxhrny7wNOH/fzCWCU8U7hmi5wlmBK', '081229844969', NULL, NULL, '2021-08-23', 'admin', current_timestamp(), current_timestamp()); 

CREATE TABLE gambar(
	id_gambar int not null primary key auto_increment,
	nama_gambar varchar(100),
	gambar varchar(200),
	kategori_gambar varchar(50),
	deskripsi_gambar varchar(200),
	gambar_url varchar(100),
	created_at_gambar timestamp not null default now(),
    updated_at_gambar timestamp not null default now() on update now()
);

CREATE TABLE tokengame(
	id_tokengame int not null primary key auto_increment,
	nama_tokengame varchar(200),
	catatan_tokengame varchar(200),
	token_game varchar(5),
    token_game_expired date,
	is_active_tokengame tinyint default 1,
	created_at_tokengame timestamp not null default now(),
    updated_at_tokengame timestamp not null default now() on update now()
);