# Pokretanje MongoDB baze
echo "Pokretanje MongoDB baze..."
sudo systemctl start mongod

# Pokretanje Neo4j baze
echo "Pokretanje Neo4j baze..."
sudo systemctl start neo4j.service

# Pokretanje lokalnog PHP servera
echo "Pokretanje lokalnog PHP servera..."
php -S localhost:8888

