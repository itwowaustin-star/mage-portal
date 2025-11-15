# MySQL MCP Server

MCP Server for connecting to MySQL 8.0.44 database.

## Connection Details

- **Host**: asus.cvkj.net
- **Port**: 52673
- **User**: root
- **Database**: (dynamic)

## Installation

```bash
# Install dependencies
npm install

# Or use the package-mcp.json
npm install --prefix . --package-lock-only -f
npm install @modelcontextprotocol/sdk mysql2
```

## Usage

### Running the Server

```bash
# Make executable
chmod +x mcp-mysql-server.js

# Run directly
node mcp-mysql-server.js

# Or use npm
npm start
```

### Configure in Claude Desktop

Add to your Claude Desktop config (`~/Library/Application Support/Claude/claude_desktop_config.json` on macOS):

```json
{
  "mcpServers": {
    "mysql": {
      "command": "node",
      "args": ["/Users/dandelion/PhpstormProjects/mag-laravel/mcp-mysql-server.js"]
    }
  }
}
```

## Available Tools

### 1. `execute_query`
Execute any SQL query (SELECT, SHOW, DESCRIBE, etc.)

**Parameters:**
- `query` (required): The SQL query to execute
- `database` (optional): Database name to use

**Example:**
```json
{
  "query": "SELECT * FROM users LIMIT 10",
  "database": "my_database"
}
```

### 2. `list_databases`
List all databases on the MySQL server

**Example:**
```json
{}
```

### 3. `list_tables`
List all tables in a specific database

**Parameters:**
- `database` (required): The database name

**Example:**
```json
{
  "database": "my_database"
}
```

### 4. `describe_table`
Get the structure of a specific table

**Parameters:**
- `database` (required): The database name
- `table` (required): The table name

**Example:**
```json
{
  "database": "my_database",
  "table": "users"
}
```

### 5. `get_table_indexes`
Get all indexes for a specific table

**Parameters:**
- `database` (required): The database name
- `table` (required): The table name

**Example:**
```json
{
  "database": "my_database",
  "table": "users"
}
```

## Security Notes

⚠️ **Important**: This configuration contains sensitive credentials. 

**Best Practices:**
1. Consider using environment variables for credentials
2. Restrict network access to the MySQL server
3. Use read-only users when possible
4. Don't commit this file to public repositories

## Environment Variables Version (Recommended)

To use environment variables instead of hardcoded credentials, modify the connection config:

```javascript
const DB_CONFIG = {
  host: process.env.MYSQL_HOST || 'asus.cvkj.net',
  port: parseInt(process.env.MYSQL_PORT || '52673'),
  user: process.env.MYSQL_USER || 'root',
  password: process.env.MYSQL_PASSWORD,
  // ...
};
```

Then create a `.env` file:
```bash
MYSQL_HOST=asus.cvkj.net
MYSQL_PORT=52673
MYSQL_USER=root
MYSQL_PASSWORD=pk6@ntQrk5yfA
```

## Troubleshooting

### Connection Refused
- Check if the MySQL server is accessible from your network
- Verify the port is correct
- Check firewall rules

### Authentication Failed
- Verify username and password
- Check MySQL user permissions
- Ensure the user has remote access enabled

### SSL/TLS Issues
If you need SSL, add to DB_CONFIG:
```javascript
ssl: {
  rejectUnauthorized: false
}
```

## Testing

Test the connection manually:
```bash
mysql -h asus.cvkj.net -P 52673 -u root -p
```

## License

MIT
