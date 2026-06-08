
# Mini Proyecto #1: Estructuras de Control y Clases en PHP

## 🏫 Información Institucional
* **Institución:** Universidad Tecnológica de Panamá (UTP)
* **Facultad:** Facultad de Ingeniería de Sistemas Computacionales (FISC)
* **Carrera:** Licenciatura en Ingeniería de Sistemas Computacionales
* **Curso:** Desarrollo Web VII
* **Instructor:** Ing. Irina Fong
* **Grupo:** [1GS131]
* **Estudiantes:**
  * Aaron Ortiz
  * Gustavo Domínguez
  * Orlando Valdes 
* **Fecha de Realización:** Mayo - 8 Junio de 2026

---

## 📝 Introducción
El desarrollo de aplicaciones web modernas exige no solo la resolución eficiente de problemas lógicos, sino también la adopción de arquitecturas limpias, modulares y seguras. Este proyecto tiene como objetivo consolidar el uso de sentencias de decisión (`if`, `switch`), operadores ternarios y estructuras repetitivas (`while`, `for`, `foreach`) en el lenguaje PHP 8.x, integrándolas dentro de componentes modulares bajo el paradigma de la Programación Orientada a Objetos (POO).

A través de una interfaz web unificada, dinámica y completamente responsiva, se aborda la resolución de diversos problemas algorítmicos. El sistema prioriza la seguridad en el ciclo de desarrollo del lado del servidor, implementando mecanismos avanzados de validación y sanitización de datos para mitigar vulnerabilidades críticas como la ejecución de scripts entre sitios (XSS), garantizando la integridad de la aplicación antes de procesar operaciones matemáticas o lógicas.

---

## 🛠️ Tecnologías Utilizadas
El proyecto ha sido construido utilizando tecnologías estándares de la industria para asegurar portabilidad, adaptabilidad y rendimiento:

* **Backend:** PHP 8.x (Programación Orientada a Objetos)
* **Frontend:** HTML / CSS (Diseño modular basado en CSS Grid y variables globales `:root`)
* **Entorno de Servidor Local:** XAMPP / Apache / WAMPP
* **Herramientas de Desarrollo:** Visual Studio Code, Git & GitHub

---

## 🏗️ Arquitectura y Programación Orientada a Objetos (POO)

El proyecto implementa los principios de **POO** y encapsulación mediante la separación de la lógica de presentación de la lógica de negocio. Se estructuraron clases para resolver las operaciones de los problemas planteados, consumiendo sus capacidades mediante componentes organizados.

### ⚡ Uso de Métodos Estáticos
Para optimizar el rendimiento y el uso de memoria en el servidor, se diseñó una **clase utilitaria** con métodos estáticos (`public static`). Esto evita la necesidad de instanciar objetos repetitivos, permitiendo invocar funciones globales directamente desde los controladores:

```php
// Ejemplo de invocación directa sin instanciación
$textoSanitizado = Validador::sanitizarTexto($_POST['entrada']);

```

---

## 🔐 Funciones de Validación y Sanitización

Con el fin de evitar inyecciones de código malicioso (**Cross-Site Scripting - XSS**) y asegurar la estabilidad de las operaciones, se documentan las siguientes funciones clave del sistema:

### 1. Sanitización de Texto

Se implementó un método que elimina espacios huérfanos y transforma caracteres HTML en entidades seguras para evitar la ejecución de scripts en el navegador:

```php
public static function sanitizarTexto($texto)
{
    return htmlspecialchars(trim($texto));
}

```

### 2. Validación Numérica

Garantiza que el valor recibido sea estrictamente un número de punto flotante o entero válido, interceptando strings vacíos o caracteres alfabéticos antes de que causen un error crítico en el procesador matemático:

```php
public static function validarNumero($numero)
{
    return filter_var($numero, FILTER_VALIDATE_FLOAT);
}

```

---

## 🧮 Documentación de Funciones Matemáticas

Para resolver las fórmulas algorítmicas de los casos de estudio (tales como cálculos estadísticos, promedios y conversiones matemáticas), se utilizaron las siguientes funciones nativas de PHP:

* **`sqrt($valor)`**: Calcula la raíz cuadrada de un número flotante o entero. Fundamental para resolver ecuaciones o cálculos de desviaciones geométricas.
* **`pow($base, $exponente)`**: Eleva la base a la potencia del exponente especificado.
* **`round($valor, $decimales)`**: Redondea un número de punto flotante al número especificado de dígitos decimales, garantizando salidas visuales limpias para el usuario.
* **`min()` y `max()**`: Evalúan conjuntos de datos o arreglos numéricos para identificar de forma inmediata los valores límites (mínimos y máximos) en los módulos estadísticos.

---

## 📸 Capturas de Pantalla (Interfaz de Usuario)

### Menú Principal Moderno

> Interfaz adaptativa con diseño de cuadrícula simétrica, botones redondeados y efectos dinámicos flotantes al pasar el cursor.
<img width="1337" height="645" alt="image" src="https://github.com/user-attachments/assets/b6551932-bbd0-4edd-ac6e-3e2b7d92416d" />


### Módulo de Resultados

> Despliegue de respuestas formateadas con alertas de error e integración responsiva.
> <img width="678" height="633" alt="image" src="https://github.com/user-attachments/assets/fb2c9cad-76ac-48e3-89b0-fd3d4afd43cb" />
