#!/bin/bash

# Stop and remove containers, volumes
docker-compose down -v

# Start containers
docker-compose up -d

# Wait for MySQL to be ready
echo "Waiting for MySQL to be ready..."
sleep 10

# Create schema
docker exec ht_php php bin/console doctrine:schema:create

# Create default user
docker exec ht_php php bin/console app:create-default-user

echo "Database reset complete. You can login with:"
echo "Email: alinivann@gmail.com"
echo "Password: gatorade" 