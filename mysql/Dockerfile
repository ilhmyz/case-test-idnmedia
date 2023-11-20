FROM mysql:8.2

# initialize to create table adn insert sample data
ADD ./mysql/*-init-*.sql /docker-entrypoint-initdb.d/

EXPOSE 3306
