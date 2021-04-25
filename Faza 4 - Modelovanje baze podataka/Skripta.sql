
DROP TABLE [Administrator]
go

DROP TABLE [Monolog]
go

DROP TABLE [Pesma]
go

DROP TABLE [Sadrzaj]
go

DROP TABLE [Komentar]
go

DROP TABLE [Tema]
go

DROP TABLE [Prijava]
go

DROP TABLE [Kasting]
go

DROP TABLE [Reditelj]
go

DROP TABLE [RegistrovaniKorisnik]
go

DROP TABLE [Korisnik]
go

CREATE TABLE [Administrator]
( 
	[KorisnickoIme]      varchar(50)  NOT NULL 
)
go

CREATE TABLE [Kasting]
( 
	[KorisnickoIme]      varchar(50)  NOT NULL ,
	[IdKasting]          integer  IDENTITY  NOT NULL ,
	[Naziv]              varchar(120)  NOT NULL ,
	[Opis]               text  NOT NULL ,
	[BrojGlumaca]        integer  NOT NULL ,
	[BrojStatista]       integer  NOT NULL ,
	[Slika]              image  NOT NULL ,
	[Kategorija]         varchar(20)  NOT NULL ,
	[Status]             varchar(20)  NOT NULL 
	CONSTRAINT [NaCekanju_300903520]
		 DEFAULT  Na cekanju
)
go

CREATE TABLE [Komentar]
( 
	[IdKom]              integer  IDENTITY  NOT NULL ,
	[IdTema]             integer  NOT NULL ,
	[KorisnickoIme]      varchar(50)  NOT NULL ,
	[Tekst]              text  NOT NULL ,
	[Datum]              datetime  NOT NULL 
)
go

CREATE TABLE [Korisnik]
( 
	[KorisnickoIme]      varchar(50)  NOT NULL ,
	[Lozinka]            varchar(50)  NOT NULL ,
	[Slika]              image  NOT NULL ,
	[DatumRodjenja]      datetime  NOT NULL ,
	[Ime]                varchar(100)  NOT NULL ,
	[Prezime]            varchar(100)  NOT NULL ,
	[Email]              varchar(200)  NOT NULL 
)
go

CREATE TABLE [Monolog]
( 
	[IdSadrzaj]          integer  NOT NULL ,
	[Autor]              varchar(100)  NOT NULL ,
	[Delo]               varchar(100)  NOT NULL ,
	[Vrsta]              varchar(20)  NOT NULL 
)
go

CREATE TABLE [Pesma]
( 
	[Naziv]              varchar(100)  NOT NULL ,
	[Autor]              varchar(100)  NOT NULL ,
	[IdSadrzaj]          integer  NOT NULL ,
	[Vrsta]              varchar(20)  NOT NULL 
)
go

CREATE TABLE [Prijava]
( 
	[KorisnickoIme]      varchar(50)  NOT NULL ,
	[IdKasting]          integer  NOT NULL ,
	[CV]                 text  NOT NULL ,
	[Video]              varbinary  NOT NULL ,
	[Status]             varchar(20)  NOT NULL 
)
go

CREATE TABLE [Reditelj]
( 
	[KorisnickoIme]      varchar(50)  NOT NULL ,
	[Status]             varchar(20)  NOT NULL 
)
go

CREATE TABLE [RegistrovaniKorisnik]
( 
	[KorisnickoIme]      varchar(50)  NOT NULL 
)
go

CREATE TABLE [Sadrzaj]
( 
	[IdSadrzaj]          integer  IDENTITY  NOT NULL ,
	[Video]              varbinary  NOT NULL ,
	[KorisnickoIme]      varchar(50)  NOT NULL 
)
go

CREATE TABLE [Tema]
( 
	[IdTema]             integer  IDENTITY  NOT NULL ,
	[Naslov]             varchar(120)  NOT NULL ,
	[KorisnickoIme]      varchar(50)  NOT NULL ,
	[KratakOpis]         varchar(120)  NOT NULL ,
	[Tekst]              text  NOT NULL ,
	[Datum]              datetime  NOT NULL 
)
go

ALTER TABLE [Administrator]
	ADD CONSTRAINT [XPKAdministrator] PRIMARY KEY  CLUSTERED ([KorisnickoIme] ASC)
go

ALTER TABLE [Kasting]
	ADD CONSTRAINT [XPKKasting] PRIMARY KEY  CLUSTERED ([IdKasting] ASC)
go

ALTER TABLE [Komentar]
	ADD CONSTRAINT [XPKKomentar] PRIMARY KEY  CLUSTERED ([IdKom] ASC,[IdTema] ASC,[KorisnickoIme] ASC)
go

ALTER TABLE [Korisnik]
	ADD CONSTRAINT [XPKKorisnik] PRIMARY KEY  CLUSTERED ([KorisnickoIme] ASC)
go

ALTER TABLE [Monolog]
	ADD CONSTRAINT [XPKMonolog] PRIMARY KEY  CLUSTERED ([IdSadrzaj] ASC)
go

ALTER TABLE [Pesma]
	ADD CONSTRAINT [XPKPesma] PRIMARY KEY  CLUSTERED ([IdSadrzaj] ASC)
go

ALTER TABLE [Prijava]
	ADD CONSTRAINT [XPKPrijava] PRIMARY KEY  CLUSTERED ([KorisnickoIme] ASC,[IdKasting] ASC)
go

ALTER TABLE [Reditelj]
	ADD CONSTRAINT [XPKReditelj] PRIMARY KEY  CLUSTERED ([KorisnickoIme] ASC)
go

ALTER TABLE [RegistrovaniKorisnik]
	ADD CONSTRAINT [XPKRegistrovaniKorisnik] PRIMARY KEY  CLUSTERED ([KorisnickoIme] ASC)
go

ALTER TABLE [Sadrzaj]
	ADD CONSTRAINT [XPKSadrzaj] PRIMARY KEY  CLUSTERED ([IdSadrzaj] ASC)
go

ALTER TABLE [Tema]
	ADD CONSTRAINT [XPKTema] PRIMARY KEY  CLUSTERED ([IdTema] ASC)
go


ALTER TABLE [Administrator]
	ADD CONSTRAINT [R_1] FOREIGN KEY ([KorisnickoIme]) REFERENCES [Korisnik]([KorisnickoIme])
		ON DELETE CASCADE
		ON UPDATE CASCADE
go


ALTER TABLE [Kasting]
	ADD CONSTRAINT [R_18] FOREIGN KEY ([KorisnickoIme]) REFERENCES [Reditelj]([KorisnickoIme])
		ON DELETE CASCADE
		ON UPDATE CASCADE
go


ALTER TABLE [Komentar]
	ADD CONSTRAINT [R_16] FOREIGN KEY ([IdTema]) REFERENCES [Tema]([IdTema])
		ON DELETE CASCADE
		ON UPDATE CASCADE
go

ALTER TABLE [Komentar]
	ADD CONSTRAINT [R_17] FOREIGN KEY ([KorisnickoIme]) REFERENCES [Korisnik]([KorisnickoIme])
		ON DELETE CASCADE
		ON UPDATE CASCADE
go


ALTER TABLE [Monolog]
	ADD CONSTRAINT [R_4] FOREIGN KEY ([IdSadrzaj]) REFERENCES [Sadrzaj]([IdSadrzaj])
		ON DELETE CASCADE
		ON UPDATE CASCADE
go


ALTER TABLE [Pesma]
	ADD CONSTRAINT [R_5] FOREIGN KEY ([IdSadrzaj]) REFERENCES [Sadrzaj]([IdSadrzaj])
		ON DELETE CASCADE
		ON UPDATE CASCADE
go


ALTER TABLE [Prijava]
	ADD CONSTRAINT [R_19] FOREIGN KEY ([KorisnickoIme]) REFERENCES [RegistrovaniKorisnik]([KorisnickoIme])
		ON DELETE CASCADE
		ON UPDATE CASCADE
go

ALTER TABLE [Prijava]
	ADD CONSTRAINT [R_20] FOREIGN KEY ([IdKasting]) REFERENCES [Kasting]([IdKasting])
		ON DELETE CASCADE
		ON UPDATE CASCADE
go


ALTER TABLE [Reditelj]
	ADD CONSTRAINT [R_3] FOREIGN KEY ([KorisnickoIme]) REFERENCES [Korisnik]([KorisnickoIme])
		ON DELETE CASCADE
		ON UPDATE CASCADE
go


ALTER TABLE [RegistrovaniKorisnik]
	ADD CONSTRAINT [R_2] FOREIGN KEY ([KorisnickoIme]) REFERENCES [Korisnik]([KorisnickoIme])
		ON DELETE CASCADE
		ON UPDATE CASCADE
go


ALTER TABLE [Sadrzaj]
	ADD CONSTRAINT [R_11] FOREIGN KEY ([KorisnickoIme]) REFERENCES [RegistrovaniKorisnik]([KorisnickoIme])
		ON DELETE CASCADE
		ON UPDATE CASCADE
go


ALTER TABLE [Tema]
	ADD CONSTRAINT [R_15] FOREIGN KEY ([KorisnickoIme]) REFERENCES [Korisnik]([KorisnickoIme])
		ON DELETE CASCADE
		ON UPDATE CASCADE
go
