--
-- Estructura de la base de datos simplificada y optimizada
--

-- Tabla principal de usuarios. Laravel usa 'users' por convención.
-- Incluye todos los roles en una sola tabla.
CREATE TABLE `users` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL,
    `email` VARCHAR(255) NOT NULL UNIQUE,
    `password` VARCHAR(255) NOT NULL,
    `address` VARCHAR(255) NULL,
    `phone_whatsapp` VARCHAR(20) NULL,
    `role` ENUM('admin', 'employee', 'company', 'client') NOT NULL DEFAULT 'client',
    `status` ENUM('active', 'suspended', 'canceled') NOT NULL DEFAULT 'active',
    `collection_preferences` JSON NULL,
    `remember_token` VARCHAR(100) NULL,
    `email_verified_at` TIMESTAMP NULL,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabla de empresas, ahora con una relación más clara con la tabla `users`
CREATE TABLE `companies` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `user_id` BIGINT UNSIGNED NULL,
    `name` VARCHAR(100) NOT NULL,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE SET NULL
);

-- Tabla de empleados recolectores.
CREATE TABLE `employees` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `user_id` BIGINT UNSIGNED NOT NULL UNIQUE,
    `locality_id` BIGINT UNSIGNED NULL,
    `assigned_waste_types` JSON NULL,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
);

-- Tabla para localidades
CREATE TABLE `localities` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(100) NOT NULL,
    `postal_code` VARCHAR(20) NULL,
    `collection_days` JSON NULL,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE (`name`, `postal_code`)
);

-- Tabla de tipos de residuos. `waste_types` es más descriptivo.
CREATE TABLE `waste_types` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(100) NOT NULL,
    `category` ENUM('organic', 'inorganic', 'hazardous') NOT NULL,
    `subcategory` VARCHAR(100) NULL,
    `points_per_kg` INT NOT NULL,
    `collection_frequency` ENUM('weekly', 'monthly') NOT NULL,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabla de inventario
CREATE TABLE `inventories` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `locality_id` BIGINT UNSIGNED NULL,
    `baldes_aserrin_available` INT NOT NULL,
    `minimum_stock` INT NOT NULL,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (`locality_id`) REFERENCES `localities`(`id`) ON DELETE SET NULL
);

-- Tabla de programación de recolección
CREATE TABLE `collection_schedules` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `locality_id` BIGINT UNSIGNED NULL,
    `waste_type_id` BIGINT UNSIGNED NULL,
    `day_of_week` VARCHAR(20) NULL,
    `frequency` ENUM('weekly', 'monthly') NOT NULL,
    `is_automatic` BOOLEAN NOT NULL DEFAULT TRUE,
    `is_active` BOOLEAN NOT NULL DEFAULT TRUE,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (`locality_id`) REFERENCES `localities`(`id`) ON DELETE SET NULL,
    FOREIGN KEY (`waste_type_id`) REFERENCES `waste_types`(`id`) ON DELETE SET NULL
);

-- Tabla de registro de recolección
CREATE TABLE `collection_logs` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `schedule_id` BIGINT UNSIGNED NULL,
    `employee_id` BIGINT UNSIGNED NULL,
    `waste_type_id` BIGINT UNSIGNED NOT NULL,
    `quantity_kg` FLOAT NOT NULL,
    `status` ENUM('scheduled', 'completed') NOT NULL DEFAULT 'scheduled',
    `collection_date` TIMESTAMP NOT NULL,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (`schedule_id`) REFERENCES `collection_schedules`(`id`) ON DELETE SET NULL,
    FOREIGN KEY (`employee_id`) REFERENCES `employees`(`id`) ON DELETE SET NULL,
    FOREIGN KEY (`waste_type_id`) REFERENCES `waste_types`(`id`) ON DELETE CASCADE
);

-- Tabla de solicitud de recolección
CREATE TABLE `collection_requests` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `user_id` BIGINT UNSIGNED NULL,
    `waste_type_id` BIGINT UNSIGNED NOT NULL,
    `estimated_quantity_kg` FLOAT NOT NULL,
    `status` ENUM('requested', 'scheduled', 'completed') NOT NULL DEFAULT 'requested',
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE SET NULL,
    FOREIGN KEY (`waste_type_id`) REFERENCES `waste_types`(`id`) ON DELETE CASCADE
);

-- Tabla para perfil de puntos
CREATE TABLE `point_profiles` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `user_id` BIGINT UNSIGNED NULL,
    `accumulated_points` INT NOT NULL DEFAULT 0,
    `available_points` INT NOT NULL DEFAULT 0,
    `transaction_history` JSON NULL,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
);

-- Tabla para canje de puntos
CREATE TABLE `point_exchanges` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `user_id` BIGINT UNSIGNED NULL,
    `points_redeemed` INT NOT NULL,
    `coupon_code` VARCHAR(50) NULL,
    `discount_applied` FLOAT NULL,
    `exchange_date` TIMESTAMP NOT NULL,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE SET NULL
);

-- Tabla para notificaciones
CREATE TABLE `notifications` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `user_id` BIGINT UNSIGNED NULL,
    `message` VARCHAR(255) NOT NULL,
    `type` ENUM('registration', 'day_before', 'collection_day', 'completed') NOT NULL,
    `channel` ENUM('whatsapp', 'email') NOT NULL DEFAULT 'whatsapp',
    `status` ENUM('sent', 'failed') NOT NULL DEFAULT 'sent',
    `time_to_send` INT NULL,
    `sent_at` TIMESTAMP NULL,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE SET NULL
);

-- Tabla para planta de procesamiento
CREATE TABLE `processing_plants` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(100) NOT NULL,
    `type` ENUM('composting', 'recycling', 'hazardous') NOT NULL,
    `location` VARCHAR(255) NULL,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabla para registro de procesamiento
CREATE TABLE `processing_logs` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `plant_id` BIGINT UNSIGNED NULL,
    `waste_type_id` BIGINT UNSIGNED NOT NULL,
    `quantity_kg` FLOAT NOT NULL,
    `entry_date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (`plant_id`) REFERENCES `processing_plants`(`id`) ON DELETE SET NULL,
    FOREIGN KEY (`waste_type_id`) REFERENCES `waste_types`(`id`) ON DELETE CASCADE
);

-- Tabla de relación muchos-a-muchos entre Empresa y TipoResiduo
CREATE TABLE `company_waste_type` (
    `company_id` BIGINT UNSIGNED NOT NULL,
    `waste_type_id` BIGINT UNSIGNED NOT NULL,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`company_id`, `waste_type_id`),
    FOREIGN KEY (`company_id`) REFERENCES `companies`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`waste_type_id`) REFERENCES `waste_types`(`id`) ON DELETE CASCADE
);
