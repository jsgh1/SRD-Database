# SRD · Database

> Esquemas, migraciones y aprovisionamiento de MySQL para **SRD — Sistema de Registro Digital**. Fuente de verdad de la **evolución estructural de las bases de datos** de los microservicios.

[Backend](https://github.com/jsgh1/SRD-Backend/tree/dev) · [Frontend](https://github.com/jsgh1/SRD-Frontend/tree/dev) · [Docker Infra](https://github.com/jsgh1/SRD-Docker-Infra/tree/dev) · [Docs](https://github.com/jsgh1/SRD-Docs/tree/dev)

## 1. Responsabilidad de este repositorio

El código de negocio está en Backend; **las migraciones Laravel están aquí**. La separación evita duplicar definiciones de tablas en cada repositorio y permite revisar cambios estructurales independientemente.

En el snapshot migrado a los cinco repositorios existen **72 archivos de migración PHP**, repartidos entre los dominios de aplicación. El directorio `database/` aporta además el script de creación de usuarios, privilegios de MySQL y un índice documental de changelog.

**Motor de datos utilizado por la aplicación:** MySQL 8.4. Cada microservicio utiliza una base con usuario propio, mientras distintas juntas conviven dentro de las tablas de cada dominio separadas por `organization_id` cuando corresponde.

## 2. Estructura

```text
SRD-Database/
├── database/
│   ├── 03_dcl/
│   │   └── 01_grants/
│   │       └── initialize-services.sh  # Creación de bases, cuentas y permisos
│   └── changelog/
│       └── changelog-master.yaml       # Índice DOCUMENTAL, no Liquibase
├── services/
│   ├── audit/database/migrations/
│   ├── calendar/database/migrations/
│   ├── chat/database/migrations/
│   ├── configuration/database/migrations/
│   ├── files/database/migrations/
│   ├── identity/database/migrations/
│   ├── inventory/database/migrations/
│   ├── notifications/database/migrations/
│   ├── records/database/migrations/
│   └── treasury/database/migrations/
└── .github/workflows/
    └── migration-migrations-lint.yml  # Sintaxis de las 72 migraciones
```

El servicio **Gateway** tiene su propia base y configuración de conexión, pero no hay que inventar migraciones específicas de Gateway donde el árbol no las incluye.

## 3. Modelo de aislamiento de datos

```text
                          Instancia MySQL
                                │
         ┌──────────────────────┼──────────────────────┐
         ▼                      ▼                      ▼
    srd_identity           srd_records             srd_files
    usuario propio         usuario propio           usuario propio
         │                      │                      │
         └──────────── 8 bases más ────────────────────┘
```

En `database/03_dcl/01_grants/initialize-services.sh` se crean las bases `srd_<servicio>` y las cuentas del mismo nombre, otorgando permisos sobre **su propia base**. Son once dominios de conexión: `gateway`, `identity`, `configuration`, `records`, `audit`, `files`, `calendar`, `notifications`, `treasury`, `inventory` y `chat`.

Las contraseñas de cada servicio proceden de variables `DB_PASSWORD_*` creadas localmente en el ensamblaje; **no se almacenan** en este repositorio.

Hay dos niveles diferentes de seguridad:

1. **Aislamiento por microservicio:** el usuario MySQL `srd_records` no debe poder consultar `srd_identity` ni las demás bases.
2. **Aislamiento por junta (tenant):** aun dentro de `srd_records`, el Backend debe restringir todas las operaciones a la organización autorizada. El aislamiento de credenciales MySQL **no demuestra por sí solo** el aislamiento por junta.

En la prueba aislada del SENA (23/10/2026), el script de Infra confirmó **11/11 conexiones propias correctas**, **110/110 consultas cruzadas denegadas** y cero fallos.

## 4. Estrategia de migraciones

El sistema usa **migraciones nativas de Laravel**. Los archivos se encuentran en:

```text
services/<microservicio>/database/migrations/*.php
```

El archivo `database/changelog/changelog-master.yaml` tiene `format: srd-laravel-migrations-v1` y contiene expresamente la advertencia: **«Índice documental. No ejecutarlo con Liquibase»**. No se debe recomendar `liquibase update` para este proyecto.

Como el código Laravel vive en SRD-Backend, durante el armado temporal se superponen los subdirectorios `services/*/database/migrations` de este repositorio a los correspondientes de Backend. **Solo después** se construyen imágenes y se ejecuta `php artisan migrate --force`.

```text
SRD-Backend/services/records/  +  SRD-Database/services/records/database/migrations/
                                  │
                                  ▼
                     workspace/services/records/
                                  │
                                  ▼
                   Laravel artisan migrate --force
                                  │
                                  ▼
                          MySQL srd_records
```

No aplicar las migraciones de todos los dominios sobre una sola base compartida. La configuración de conexión de cada Laravel determina su esquema.

## 5. Cómo ejecutar SRD con esta base de datos

> Consulta la [guía completa de ensamblaje](https://github.com/jsgh1/SRD-Docker-Infra/blob/dev/README.md) antes de ejecutar comandos en un equipo compartido.

1. Clona Backend, Frontend, Database y Docker Infra desde la misma etapa de integración (`dev` o conjunto de commits fijados).
2. Ensambla el código en un `workspace/` aislado, incluyendo este repositorio **después** de Backend para agregar las migraciones.
3. Selecciona un nombre de proyecto Compose que no choque con otras aplicaciones, por ejemplo `$env:COMPOSE_PROJECT_NAME = 'srd-mi-entorno'`.
4. Ejecuta `./scripts/Up.ps1` desde `workspace/`. Ese script llama a la inicialización local y configura MySQL por servicio antes de aplicar migraciones.

### Inspeccionar estado sin modificar datos

```powershell
# En el workspace ensamblado, con COMPOSE_PROJECT_NAME establecido
docker compose ps mysql
docker compose exec -T records php artisan migrate:status
docker compose exec -T identity php artisan migrate:status
```

### Aplicar migraciones de forma controlada

```powershell
# Solo en ambiente autorizado y después de un respaldo verificable:
docker compose exec -T records php artisan migrate --force
```

En producción, aplicar migraciones únicamente mediante el procedimiento de liberación aprobado, revisión de compatibilidad, respaldo y comprobación de restauración. **No ejecutar `migrate:fresh`, `db:wipe` ni `docker compose down -v` sobre datos que se deseen conservar.**

## 6. Política de modificaciones de esquema

Para introducir un cambio:

1. Identifica el dueño del dato y agrega **una nueva migración** en `services/<servicio>/database/migrations/`.
2. Evita editar migraciones históricas ya aplicadas: crea una sucesora compatible con datos previos.
3. Coordina cambios de columnas o restricciones con **SRD-Backend** (controladores, validadores, contratos) y **SRD-Frontend** cuando afecten el API.
4. Revisa el impacto sobre `organization_id`, índices, unicidad, claves y lectura histórica.
5. Prueba en una base desechable MySQL 8.4, verifica `migrate:status` y la lógica de reversión si está disponible.
6. Abre PR a `dev`, espera CI y revisión; promueve por `qa` antes de `main`.

Las operaciones con datos reales deben tratarse con especial cuidado: **rollback no siempre significa recuperación de datos eliminados**.

## 7. Validaciones automáticas

La CI [migration-migrations-lint.yml](.github/workflows/migration-migrations-lint.yml) cuenta los **72 archivos de migración del snapshot** y ejecuta `php -l` sobre todos. Esa comprobación pasó durante la validación del 23/10/2026 ([run de GitHub Actions](https://github.com/jsgh1/SRD-Database/actions/runs/39979177188)).

El conteo rígido de 72 en esa CI representa el **baseline histórico**. Cuando se incorpore una nueva migración legítima, hay que **actualizar el control de cantidad en el workflow** al mismo tiempo; no eliminar la migración para satisfacer la aserción.

Para pruebas funcionales que incluyan MySQL y permisos de datos se usa [`tools/check-mysql-isolation.php`](https://github.com/jsgh1/SRD-Docker-Infra/blob/dev/tools/check-mysql-isolation.php), junto con las pruebas de Laravel/Playwright de los demás repositorios.

## 8. Relación con el resto del proyecto

| Repositorio | Relación |
| --- | --- |
| [SRD-Backend](https://github.com/jsgh1/SRD-Backend/tree/dev) | Modelos, servicios de aplicación y migraciones ejecutadas desde Artisan |
| [SRD-Frontend](https://github.com/jsgh1/SRD-Frontend/tree/dev) | Formularios y consultas que dependen de los contratos y datos del Backend |
| [SRD-Docker-Infra](https://github.com/jsgh1/SRD-Docker-Infra/tree/dev) | Inicialización MySQL, ensamblaje, Compose, backups, smoke tests |
| [SRD-Docs](https://github.com/jsgh1/SRD-Docs/tree/dev) | Entregables PDF/Word, requisitos y material académico consolidado |

## 9. Solución de problemas

| Síntoma | Posible causa |
| --- | --- |
| `Base table or view not found` | Migraciones no superpuestas o no ejecutadas en ese servicio |
| `Access denied for user srd_...` | Contraseña/usuario del servicio o esquema incorrectos; revisar `.env` del entorno sin publicarlo |
| Un servicio lee otra base | Privilegios excesivos: comprobar script DCL y aislamiento por usuario |
| Migración duplicada | Distintas fuentes copiadas al mismo lugar o migración ya registrada |
| Cambios en `dev` no aparecen en Docker | Imagen compilada desde un workspace o ref desactualizado |

---

**Autoridad para evolución de esquemas:** [jsgh1/SRD-Database](https://github.com/jsgh1/SRD-Database). **Orquestación y pruebas integradas:** [SRD-Docker-Infra](https://github.com/jsgh1/SRD-Docker-Infra/tree/dev).
