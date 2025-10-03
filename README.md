<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# EcoRecolect 2025

EcoRecolect es un prototipo universitario desarrollado en Laravel V12.  
El sistema busca gestionar de manera eficiente la recolección de residuos, promoviendo la sostenibilidad y el cuidado del medio ambiente.

## Cómo correr el proyecto en Local

### Requisitos previos

Es importante descargar: 
- XAMPP (Apache + MySQL): https://www.apachefriends.org/es/index.html
- Composer: https://getcomposer.org/
- Node.js: https://nodejs.org/en
- Git: https://git-scm.com/
- PHP >= 8.1 : https://www.php.net/downloads.php

### Clonado del Repositorio
1. Primero crear la carpeta dónde se va a clonar el Repositorio.
2. Desde Git Bash acceder la carpeta que creaste para clonar el Repositorio.

```bash
cd /c/Users/TU_USUARIO/RUTA_CARPETA
```
3. Después clona el repositorio mediante Git Bash:

```bash
git clone https://github.com/JhoanRengi/EcoRecolect_2025.git
```
NOTA: Ya podrás ver los documentos clonados.

### Instalacón dependencias

Abre Visual Studio Code, luego una terminal.

1. Ejecuta la instalación de dependencias de php:

```bash
composer install
```
> [!NOTA:]
>  Si es la primera vez ejecutando composer, se debe habilitar _<ins>;extension=zip</ins>_ en el archivo de _<ins>C:\xampp\php\php.ini</ins>_ y elininal solamente el _<ins>;</ins>_.

2. Instala los paquetes de Node.js:

```bash
npm install
```
Luego ejecuta el escript

```bash
npm run build
```
> [!NOTA:]
> Aunque estén creadas las variables de entorno, y no permite ejecutar estos comandos. Se debe porque PowerShell bloquea la ejecución de scripts .ps1 por temas de seguridad. Como PowerShell tiene la política de ejecución en "Restricted", arroja ese error.
> Ejecutar PowerShell como Administrador y ejecutar el comando _<ins>Set-ExecutionPolicy RemoteSigned -Scope CurrentUser</ins>_ y luego confirma su ejecución (en Si o Yes). 

### Configurar .env.example

1. Configurar el .env para las Credenciales privadas.

### Genera la key

1. Desde la terminal ejecutar el comando:

```bash
php artisan key:generate
```
### Confiura la base de datos:

1. Crea la base de datos en phpMyAdmin

2. Correr las migraciones 

```bash
php artisan migrate
```

3. Finalmente levanta el servidor

```bash
php artisan serve
```

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
