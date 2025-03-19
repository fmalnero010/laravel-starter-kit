# 🚀 Laravel Starter Kit - Modular & Scalable API

![PHP](https://img.shields.io/badge/PHP-8.4-blue?style=flat&logo=php) ![Laravel](https://img.shields.io/badge/Laravel-12-red?style=flat&logo=laravel) ![MySQL](https://img.shields.io/badge/MySQL-8.0-blue?style=flat&logo=mysql) ![Redis](https://img.shields.io/badge/Redis-Enabled-orange?style=flat&logo=redis) ![Docker](https://img.shields.io/badge/Docker-Sail-blue?style=flat&logo=docker) ![Swagger](https://img.shields.io/badge/Swagger-Enabled-brightgreen?style=flat&logo=swagger) ![Pest](https://img.shields.io/badge/Testing-Pest-purple?style=flat&logo=php)

Un **Starter Kit** de Laravel **altamente optimizado y escalable**, diseñado para **APIs** con **arquitectura modular**, **Single Action Controllers**, **DTOs**, **caching con Redis**, y **documentación automatizada con Swagger**.

---

## 🛠️ **Stack Tecnológico**

- **Laravel 12** + **PHP 8.4**
- **MySQL 8**
- **Docker + Laravel Sail**
- **Redis** para caching
- **Swagger** para documentación API
- **Pest** para testing
- **Laravel Modules (DDD)** para estructura modular
- **Mailpit** para pruebas de emails en dev
- **Telescope** para debugging avanzado
- **Laravel Cloud** para despliegue en producción
- **CaptainHook** para hooks de Git automáticos

---

## 🚀 **Instalación y Configuración**

### 🔹 **1. Clonar el repositorio**
```bash
 git@github.com:fmalnero010/laravel-starter-kit.git && cd laravel-starter-kit
```

### 🔹 **2. Instalar dependencias con Composer**
```bash
docker run --rm -v $(pwd):/app -w /app laravelsail/php82-composer:latest composer install
```

### 🔹 **3. Iniciar Laravel Sail (Docker)**
```bash
alias sail='[ -f sail ] && bash sail || bash vendor/bin/sail' # Permite usar sail como comando en vez de ./vendor/bin/sail

sail up -d  # Levanta el entorno en background
```

### 🔹 **4. Configurar el entorno (.env)**
```bash
cp .env.example .env
sail artisan key:generate
```

### 🔹 **5. Ejecutar migraciones y seeders**
```bash
sail artisan migrate --seed
```

---

## 🧪 **Testing con Pest**
Para correr los tests:
```bash
sail test
```
O ejecutar solo un test específico:
```bash
sail test Modules/Users/tests/Feature/UsersIndexTest.php
```

---

## 🛠️ Herramientas Integradas

🔹 **CaptainHook** - **Hooks de Git Automáticos**

Este proyecto utiliza **CaptainHook** para ejecutar acciones automáticas durante el flujo de trabajo con Git, como la validación de mensajes de commit, el formateo de código y la ejecución de pruebas antes de hacer commit o push. Estas herramientas ayudan a mantener el código limpio y evitar errores comunes.

### **Configuración de CaptainHook**

1. **Instalación de dependencias**  
   Para instalar **CaptainHook**, solo necesitas ejecutar el siguiente comando, que ya estará incluido en el proceso de instalación cuando clonas el repositorio y corres `composer install`:

   ```bash
   sail composer install
   ```

2. **Instalación de los hooks de Git**  
   Los hooks de Git se instalarán automáticamente cuando corras el siguiente comando (esto debería hacerse después de cada `composer install`):

   ```bash
   vendor/bin/captainhook install --force
   ```

3. **Acciones de los hooks**  
   Los hooks configurados son:
    - **`pre-commit`**: Formatea el código con **ECS**.
    - **`pre-push`**: Ejecuta los tests con **Pest**, verifica que no haya errores con **PHPStan** y previene el push a las ramas `main` y `develop`.

4. **Uso de CaptainHook**  
   Si alguna de las validaciones falla, el commit o push será rechazado hasta que se solucionen los problemas. Por ejemplo:
    - **Pre-push fallido**: Si los tests o PHPStan fallan.

---

🔹 **Telescope - Debugging Avanzado**

Telescope es una herramienta poderosa para inspeccionar logs, requests, queries y excepciones en tiempo real. Para acceder a la interfaz de Telescope:

http://localhost/telescope

🔹 **Redis - Caching y Optimización**

Redis se usa para caching de consultas, sesiones y optimización de respuestas. Laravel ya está configurado para usar Redis como CACHE_DRIVER. Para conectarte a Redis dentro del contenedor:

http://localhost:5540

🔹 **Mailpit - Testing de Correos**

Mailpit es una herramienta que captura correos enviados en el entorno de desarrollo, permitiendo visualizar y depurar emails sin enviarlos realmente. Para acceder a la interfaz de Mailpit:

http://localhost:8025

---

## 📄 **Swagger - Documentación de API**
La documentación se genera automáticamente con **Swagger**.
Sin embargo, también puedes generarla con el siguiente comando:
```bash
sail artisan l5-swagger:generate
```
Accedé en: **[http://localhost/api/documentation](http://localhost/api/documentation)**

---

## 🎯 **Contribuciones**
¡Este Starter Kit está en constante mejora! Si querés colaborar:
1. Forkeá el repositorio 🍴
2. Creá una rama `feature/nueva-funcionalidad`
3. Hacé un Pull Request 📌

🚀 **Hecho con Laravel & ❤️ por [Facundo Malnero]** 🚀

---
