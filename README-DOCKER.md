# Docker Configuration for Legacy PHP Application

This document describes the Docker configuration for running a legacy PHP application behind a Traefik SSL proxy.

## Project Structure

- `Dockerfile` - PHP 7.2 with Apache image configuration
- `docker-compose.yml` - Service configuration (PHP application and MySQL database)
- `docker/` - Directory with additional configuration files
  - `000-default.conf` - Apache virtual host configuration
  - `php.ini` - PHP settings
  - `traefik_https.php` - Script for handling Traefik headers
  - `docker-entrypoint.sh` - Container initialization script

## Configuration Features

### Traefik SSL Proxy Support

The application is configured to work behind Traefik as an SSL-terminating proxy:

1. Internal HTTPS redirects from `.htaccess` have been removed to prevent redirect loops
2. Added `traefik_https.php` script that automatically handles `X-Forwarded-Proto` headers from Traefik
3. Configured `auto_prepend_file` in PHP for automatic header handler inclusion

### Database Configuration

The database is configured through environment variables in `docker-compose.yml`:

- `DBhostname` - Database host (service name in Docker Compose)
- `DBusername` - Database username
- `DBpassword` - Database user password
- `DBdatabase` - Database name

The `docker-entrypoint.sh` script automatically replaces hardcoded constants in `library.php` with values from environment variables.

### PHP Session Support

A directory for storing PHP session files has been configured:

- Created directory `/var/lib/php/sessions` with 1733 permissions
- Added `session.save_path` setting in `php.ini`

## Running the Application

### Local Development

```bash
# Build and start containers
sudo docker-compose up -d

# Check logs
sudo docker logs propdispapp_web

# Stop containers
sudo docker-compose down
```

The application will be available at: http://localhost:8085

## Troubleshooting

### 500 Internal Server Error

If you see a 500 error, check:

1. Container logs: `sudo docker logs propdispapp_web`
2. Session directory permissions: `sudo docker exec propdispapp_web ls -la /var/lib/php/sessions`
3. Database connection: check environment variables and values in `library.php`

### Session Issues

If you encounter session problems:

```bash
# Check session directory permissions
sudo docker exec propdispapp_web ls -la /var/lib/php/sessions

# Check PHP session settings
sudo docker exec propdispapp_web php -i | grep session
```

### Database Issues

To check database connectivity:

```bash
# Check MySQL availability
sudo docker exec propdispapp_web ping -c 3 db

# Check MySQL connection
sudo docker exec propdispapp_web mysql -h db -u dbo763817850 -piamtheadmin -e "SHOW DATABASES;"
```

## Changing the Port

If you want to change the port on which the application is available, edit `docker-compose.yml`:

```yaml
ports:
  - "new_port:80"
```

For example, to use port 80:

```yaml
ports:
  - "80:80"
```

Note that using ports below 1024 may require running with root privileges.
