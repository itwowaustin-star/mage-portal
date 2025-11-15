#!/usr/bin/env node

/**
 * MCP Server for MySQL 8.0.44
 * Connects to: asus.cvkj.net:52673
 */

import { Server } from '@modelcontextprotocol/sdk/server/index.js';
import { StdioServerTransport } from '@modelcontextprotocol/sdk/server/stdio.js';
import {
  CallToolRequestSchema,
  ListToolsRequestSchema,
} from '@modelcontextprotocol/sdk/types.js';
import mysql from 'mysql2/promise';

// MySQL 连接配置
const DB_CONFIG = {
  host: 'asus.cvkj.net',
  port: 52673,
  user: 'root',
  password: 'pk6@ntQrk5yfA',
  database: '', // 默认不指定数据库，可以动态切换
  waitForConnections: true,
  connectionLimit: 10,
  queueLimit: 0,
  enableKeepAlive: true,
  keepAliveInitialDelay: 0,
};

// 创建连接池
let pool = null;

async function getConnection() {
  if (!pool) {
    pool = mysql.createPool(DB_CONFIG);
  }
  return pool.getConnection();
}

// 创建 MCP Server
const server = new Server(
  {
    name: 'mysql-mcp-server',
    version: '1.0.0',
  },
  {
    capabilities: {
      tools: {},
    },
  }
);

// 列出可用的工具
server.setRequestHandler(ListToolsRequestSchema, async () => {
  return {
    tools: [
      {
        name: 'execute_query',
        description: 'Execute a SQL query (SELECT, SHOW, DESCRIBE, etc.) and return results',
        inputSchema: {
          type: 'object',
          properties: {
            query: {
              type: 'string',
              description: 'The SQL query to execute',
            },
            database: {
              type: 'string',
              description: 'Optional: Database name to use',
            },
          },
          required: ['query'],
        },
      },
      {
        name: 'list_databases',
        description: 'List all databases on the MySQL server',
        inputSchema: {
          type: 'object',
          properties: {},
        },
      },
      {
        name: 'list_tables',
        description: 'List all tables in a specific database',
        inputSchema: {
          type: 'object',
          properties: {
            database: {
              type: 'string',
              description: 'The database name',
            },
          },
          required: ['database'],
        },
      },
      {
        name: 'describe_table',
        description: 'Get the structure of a specific table',
        inputSchema: {
          type: 'object',
          properties: {
            database: {
              type: 'string',
              description: 'The database name',
            },
            table: {
              type: 'string',
              description: 'The table name',
            },
          },
          required: ['database', 'table'],
        },
      },
      {
        name: 'get_table_indexes',
        description: 'Get all indexes for a specific table',
        inputSchema: {
          type: 'object',
          properties: {
            database: {
              type: 'string',
              description: 'The database name',
            },
            table: {
              type: 'string',
              description: 'The table name',
            },
          },
          required: ['database', 'table'],
        },
      },
    ],
  };
});

// 处理工具调用
server.setRequestHandler(CallToolRequestSchema, async (request) => {
  const { name, arguments: args } = request.params;

  try {
    const connection = await getConnection();

    try {
      switch (name) {
        case 'execute_query': {
          const { query, database } = args;
          
          if (database) {
            await connection.query(`USE \`${database}\``);
          }

          const [rows] = await connection.query(query);
          
          return {
            content: [
              {
                type: 'text',
                text: JSON.stringify(rows, null, 2),
              },
            ],
          };
        }

        case 'list_databases': {
          const [rows] = await connection.query('SHOW DATABASES');
          
          return {
            content: [
              {
                type: 'text',
                text: JSON.stringify(rows, null, 2),
              },
            ],
          };
        }

        case 'list_tables': {
          const { database } = args;
          await connection.query(`USE \`${database}\``);
          const [rows] = await connection.query('SHOW TABLES');
          
          return {
            content: [
              {
                type: 'text',
                text: JSON.stringify(rows, null, 2),
              },
            ],
          };
        }

        case 'describe_table': {
          const { database, table } = args;
          await connection.query(`USE \`${database}\``);
          const [rows] = await connection.query(`DESCRIBE \`${table}\``);
          
          return {
            content: [
              {
                type: 'text',
                text: JSON.stringify(rows, null, 2),
              },
            ],
          };
        }

        case 'get_table_indexes': {
          const { database, table } = args;
          await connection.query(`USE \`${database}\``);
          const [rows] = await connection.query(`SHOW INDEX FROM \`${table}\``);
          
          return {
            content: [
              {
                type: 'text',
                text: JSON.stringify(rows, null, 2),
              },
            ],
          };
        }

        default:
          throw new Error(`Unknown tool: ${name}`);
      }
    } finally {
      connection.release();
    }
  } catch (error) {
    return {
      content: [
        {
          type: 'text',
          text: `Error: ${error.message}\n\nStack: ${error.stack}`,
        },
      ],
      isError: true,
    };
  }
});

// 启动服务器
async function main() {
  const transport = new StdioServerTransport();
  await server.connect(transport);
  
  console.error('MySQL MCP Server running on stdio');
  console.error('Connected to: asus.cvkj.net:52673');
}

main().catch((error) => {
  console.error('Fatal error:', error);
  process.exit(1);
});
