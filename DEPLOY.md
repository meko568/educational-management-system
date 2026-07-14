# Deployment Guide for PandaStack

This guide provides step-by-step instructions for deploying the Laravel application to PandaStack using Docker containers with a managed MySQL database.

## Prerequisites

- PandaStack account with access to create containers and managed databases
- Git repository containing this Laravel project
- Docker installed locally (for testing builds)

## Step 1: Set Up Managed Database in PandaStack

1. Log in to your PandaStack dashboard
2. Navigate to the **Databases** section
3. Create a new **MySQL** database instance
4. Note the following connection details from the database panel:
   - **DB_HOST**: The database hostname/IP
   - **DB_PORT**: The database port (typically 3306)
   - **DB_DATABASE**: The database name
   - **DB_USERNAME**: The database username
   - **DB_PASSWORD**: The database password

## Step 2: Configure Environment Variables

In the PandaStack container configuration panel, add the following environment variables:

### Required Application Variables
```
APP_ENV=production
APP_DEBUG=false
APP_KEY=your-generated-app-key-here
APP_URL=https://your-domain.com
```

**Note**: The application is configured to use port 8080 by default. PandaStack should automatically handle port mapping.

### Database Connection Variables
```
DB_CONNECTION=mysql
DB_HOST=your-db-host-from-pandastack
DB_PORT=3306
DB_DATABASE=your-db-name-from-pandastack
DB_USERNAME=your-db-username-from-pandastack
DB_PASSWORD=your-db-password-from-pandastack
```

**CRITICAL**: You MUST fill in all database variables with the actual值 from your PandaStack managed database. Leaving these empty will cause the application to fail.

### Optional Configuration Variables
```
LOG_CHANNEL=stack
LOG_LEVEL=warning
CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_CONNECTION=sync
```

**Important**: Generate a secure `APP_KEY` by running locally:
```bash
php artisan key:generate
```
Copy the generated key to the `APP_KEY` environment variable in PandaStack.

## Step 3: Deploy the Container

1. In PandaStack, create a new **Container** service
2. Connect your Git repository
3. Set the build context to the repository root
4. PandaStack will automatically build using the `Dockerfile` in the root
5. The container will expose port **80** for HTTP traffic

## Step 4: Run Database Migrations

After the container is deployed and running, you need to run the database migrations to set up the database schema.

### Option A: Via PandaStack Console/SSH
If PandaStack provides console access to the running container:

```bash
# Access the container console
php artisan migrate --force
```

### Option B: Via One-off Command
If PandaStack supports running one-off commands:

```bash
php artisan migrate --force
```

### Option C: Via Entry Point Script
If you prefer automated migrations, you can modify the Dockerfile to run migrations on startup (not recommended for production as it can cause issues if migrations fail).

## Step 5: Optimize Laravel for Production

Run the following optimization commands to improve performance:

```bash
# Cache configuration
php artisan config:cache

# Cache routes
php artisan route:cache

# Cache views
php artisan view:cache

# Optimize composer autoloader
composer dump-autoload --optimize
```

These commands should be run after deployment, either via:
- PandaStack console/SSH access
- One-off command execution
- Added to a deployment script

## Step 6: Verify Deployment

1. Access your application via the URL provided by PandaStack
2. Check that the application loads correctly
3. **Test database connection**: Visit `/db-check` endpoint (e.g., `https://your-app-url/db-check`)
4. **Check startup logs**: View container logs in PandaStack to see environment variable output
5. Verify database connectivity by testing features that use the database

### Debugging Database Issues

If you encounter 524 timeout or database connection errors:

1. **Check environment variables in logs**: Look for the "Environment check" output in container startup logs
2. **Test database endpoint**: Visit `/db-check` to see detailed connection error messages
3. **Verify database credentials**: Ensure all DB_* variables are set correctly in PandaStack
4. **Check database accessibility**: Ensure the managed database is reachable from the container

The `/db-check` endpoint will return:
- Connection status
- Database name if connected
- Error message if connection fails
- Current environment variable values (without passwords)

## Troubleshooting

### "Context Deadline Exceeded" Error
If you encounter this error during deployment:
- **Ensure PORT=8080 is set** in environment variables (PandaStack typically auto-injects this)
- Check that the healthcheck is passing: the container must respond to HTTP requests within 60 seconds
- Verify nginx is starting correctly by checking container logs
- Ensure the application doesn't have any blocking startup processes

### 524 Timeout Error
If you encounter a 524 timeout when accessing the live link:
- **FIXED**: The `/health` endpoint now bypasses all middleware including database-dependent sessions. Use this to verify the container is running even if the database is down.
- **Check Database Connectivity**: A 524 often means PHP is hanging while trying to connect to a database. Verify `DB_HOST`, `DB_USERNAME`, and `DB_PASSWORD` are correct.
- **Run Migrations**: If you haven't run `php artisan migrate --force`, the application might fail on some pages.
- **Check Container Logs**: Use the PandaStack console to view logs. Look for "Connection refused" or "Operation timed out".
- **Assets**: The `Dockerfile` has been updated to automatically run `npm run build` during deployment to ensure CSS/JS are present.

### Database Connection Issues
- Verify all database environment variables are correctly set
- Ensure the managed database is accessible from the container
- Check PandaStack network/firewall settings

### Permission Issues
- The Dockerfile sets proper permissions for storage and cache directories
- If you encounter permission errors, ensure the container runs with appropriate user permissions

### Build Failures
- Ensure all dependencies are in `composer.json`
- Check that the PHP version (8.2) matches the project requirements
- Verify the Alpine-based image can access all required packages

## Security Notes

- Never commit real credentials to `.env.example` or the repository
- Always use `APP_DEBUG=false` in production
- Use strong, unique passwords for the database
- Rotate `APP_KEY` if it was ever exposed
- Keep Laravel and dependencies updated regularly

## Maintenance

### Regular Tasks
- Monitor logs for errors
- Keep dependencies updated
- Run database migrations when deploying new versions
- Clear and rebuild caches after major updates

### Backup Strategy
- PandaStack's managed database should have automated backups
- Ensure backup retention policies meet your requirements
- Test restoration procedures periodically
