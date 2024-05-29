from nameko.extensions import DependencyProvider

import mysql.connector
from mysql.connector import Error
from mysql.connector import pooling

class DatabaseWrapper:

    connection = None

    def __init__(self, connection):
        self.connection = connection

    def get_all_room(self):
        cursor = self.connection.cursor(dictionary=True)
        result = []
        sql = "SELECT * FROM nama_db"
        cursor.execute(sql)
        for row in cursor.fetchall():
            result.append({
                
            })
        cursor.close()
        return result