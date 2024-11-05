--EJERCICIO 2: Implementación de Permisos Granulares.

--1.Creación de una Base de Datos y una Tabla:

CREATE DATABASE company_db;

-- Conectarse a la base de datos
\c company_db

CREATE TABLE employees (
    id SERIAL PRIMARY KEY,
    nombre VARCHAR(10),
    apellido VARCHAR(10),
    departamento VARCHAR(30)
);

--EJERCICIO 1: Creación de Roles Básicos y Privilegios.

--1. Crear dos roles de usuario en PostgreSQL:

-- Crear el rol admin_user con privilegios de superusuario
CREATE ROLE admin_user WITH SUPERUSER LOGIN PASSWORD 'admin';

-- Crear el rol read_user con permisos limitados
CREATE ROLE read_user WITH LOGIN PASSWORD '123';

--2. Asignación de Privilegios:

-- Conceder permisos de crear bases de datos, iniciar sesión y crear roles al rol admin_user
ALTER ROLE admin_user CREATEDB CREATEROLE;

-- Conceder privilegios de lectura al rol read_user
GRANT CONNECT ON DATABASE company_db TO read_user;

--3.Comprobar privilegios usando SQL:


--EJERCICIO 2: Implementación de Permisos Granulares.

--2.Definir Permisos Específicos en la Tabla:
GRANT SELECT ON TABLE employees TO read_user;

REVOKE INSERT, UPDATE, DELETE ON TABLE employees FROM read_user;

--EJERCICIO 3: Administración de Esquemas y Gestión de Roles.

--1. Crear y Organizar Esquemas:

-- Crear esquemas
CREATE SCHEMA hr;
CREATE SCHEMA sales;

-- Crear tabla employee_info en el esquema hr
CREATE TABLE hr.employee_info (
    id SERIAL PRIMARY KEY,
    nombre VARCHAR(10),
    apellido VARCHAR(10),
    puesto VARCHAR(20)
);

-- Crear tabla sales_data en el esquema sales
CREATE TABLE sales.sales_data (
    id SERIAL PRIMARY KEY,
    producto VARCHAR(25),
    cantidad INT,
    precio DECIMAL(5, 2)
);

--2. Configurar Acceso de Esquema por Rol:

-- Asignar permisos al rol admin_user
GRANT ALL PRIVILEGES ON SCHEMA hr TO admin_user;
GRANT ALL PRIVILEGES ON SCHEMA sales TO admin_user;

-- Asignar permisos de solo lectura al rol read_user en el esquema hr
GRANT USAGE ON SCHEMA hr TO read_user;
GRANT SELECT ON ALL TABLES IN SCHEMA hr TO read_user;

-- Asegurarse de que read_user no tenga acceso al esquema sales
REVOKE ALL PRIVILEGES ON SCHEMA sales FROM read_user;


--EJERCICIO 3: Creación de Roles en Grupo y Permisos Derivados.

--1. Definir Roles en Grupos:

CREATE ROLE manager_role;
GRANT SELECT, UPDATE ON hr.employee_info TO manager_role;

CREATE ROLE manager1 LOGIN PASSWORD '123'; 
CREATE ROLE manager2 LOGIN PASSWORD '123'; 

-- Otorgar permisos en el esquema hr al rol manager_role
GRANT USAGE ON SCHEMA hr TO manager_role;
GRANT SELECT, UPDATE ON ALL TABLES IN SCHEMA hr TO manager_role;

-- Asignar el rol manager_role a manager1 y manager2
GRANT manager_role TO manager1;
GRANT manager_role TO manager2;

-- Opcional: Otorgar permisos sobre las nuevas tablas que se creen en el futuro
ALTER DEFAULT PRIVILEGES IN SCHEMA hr GRANT SELECT, UPDATE ON TABLES TO manager_role;




