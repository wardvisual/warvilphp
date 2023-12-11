#!/bin/bash

# chmod +x create_migration.sh


# Function to create a migration file with a template
create_migration() {
    if [ -z "$1" ]; then
        echo "Usage: create_migration <migration_name>"
        return 1
    fi

    # Specify the migrations directory
    migrations_dir="./app/backend/database/sql/"

    # Generate a timestamp for the migration file name
    timestamp=$(date +'%Y%m%d%H%M%S')

    # Create the migration file name using the timestamp and the provided name
    # migration_name="${timestamp}_$1.php"
    migration_name="$1.php"

    # Create the full path to the migration file
    migration_file="${migrations_dir}${migration_name}"

    # Check if the migrations directory exists, and create it if not
    if [ ! -d "$migrations_dir" ]; then
        mkdir -p "$migrations_dir"
    fi

    # Create the migration file with a template
    echo "<?php
    
namespace app\backend\database\sql;

/**
 * app\backend\database\sql\\$1;
 */

class $1 {
    public static function up(\PDO \$pdo) {
        \$sql = 'CREATE TABLE $1 (
            id INT AUTO_INCREMENT PRIMARY KEY,

            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP NULL DEFAULT NULL
        )';

        \$pdo->exec(\$sql);
    }

    public static function down(\PDO \$pdo) {
        \$sql = 'DROP TABLE IF EXISTS $1';
        \$pdo->exec(\$sql);
    }
}
" > "$migration_file"
    echo "Migration '$1' created: $migration_file"
}

# Call the create_migration function with the provided argument
create_migration "$1"
