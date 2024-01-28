# CAMAS
Camas (Catat kas Masjid) merupakan aplikasi pencatatan kas berbasis web yang dikembangkan untuk mencatat pemasukan dan pengeluaran kas masjid.

<p align="center">
<div style="display:flex;column-gap:30px;justify-content:space-between;align-items:center;width:100px;text-align:center;">
<img src="https://res.cloudinary.com/dlqjd3d1x/image/upload/v1705624195/Camas/ga659cgm0wg2erqvnqlb.png" width="300" />

<img src="https://res.cloudinary.com/dlqjd3d1x/image/upload/v1705624194/Camas/cvcce0kmhvkqtnlwvrye.png" width="300" />
</div>
</p>

## Prequesite
- php version >= 7
- mysql >= 8

## How To Run
- Download and install XAMPP
- Start Apache and MySql
- Create database with name `camas`
- Run this DDL Query
```
CREATE TABLE IF NOT EXISTS jabatan (
    id INT AUTO_INCREMENT,
    nama_jabatan VARCHAR(10),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS pengguna (
    id INT AUTO_INCREMENT,
    nama VARCHAR(50),
    password TEXT,
    id_jabatan INT,
    id_dkm INT,
    alamat VARCHAR(100),
    no_hp VARCHAR(15),
    nama_masjid VARCHAR(50),
    alamat_masjid VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    FOREIGN KEY (id_jabatan) REFERENCES jabatan(id),
    FOREIGN KEY (id_dkm) REFERENCES pengguna(id)
);

CREATE TABLE IF NOT EXISTS kas (
    id INT AUTO_INCREMENT,
    tipe ENUM('1', '2'),
    dibuat_oleh_id_pengguna INT,
    diubah_oleh_id_pengguna INT,
    uraian VARCHAR(255),
    nominal INT,
    tanggal DATETIME,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    FOREIGN KEY (dibuat_oleh_id_pengguna) REFERENCES pengguna(id),
    FOREIGN KEY (diubah_oleh_id_pengguna) REFERENCES pengguna(id)
);
```
- Clone this repository
`git clone git@github.com:falihnaufal17/camas.git`
- Move camas folder into XAMPP/htdocs
- Type `localhost/camas/index.php`

## Contributors
1. Falih Naufal (Fullstack Developer | Entry Level System Analyst)
