from nameko.extensions import DependencyProvider
import mysql.connector
from mysql.connector import Error
from mysql.connector import pooling
import json
from datetime import datetime, timedelta
import pytz
from cryptography.fernet import Fernet
import hashlib
import base64

class DateTimeEncoder(json.JSONEncoder):
    def default(self, obj):
        if isinstance(obj, datetime):
            return obj.isoformat()
        return json.JSONEncoder.default(self, obj)
    
class DatabaseWrapper:

    connection = None

    def __init__(self, connection):
        self.connection = connection
    
    def hash_value(self, value):
        return hashlib.sha256(value.encode()).hexdigest()

    def get_byNoTelp(self, noTelp):
        cursor = self.connection.cursor(dictionary=True)
        result = []
        sql = "SELECT * FROM bankbca WHERE no_telp = {}" .format((noTelp))
        cursor.execute(sql)
        for row in cursor.fetchall():
            result.append({
                'no_telp' : row['no_telp'],
            })
        cursor.close()
        if result:
            return result
        else:
            return None
        
    def createBankAcc(self, nama, no_rek, pin, saldo, no_telp):
        hash_pin = self.hash_value(pin)
        try:
            cursor = self.connection.cursor(dictionary=True)
            sql = " INSERT INTO bankbca (nama, no_rek, pin, no_telp, saldo) VALUES (%s, %s, %s, %s, %s)"
            cursor.execute(sql, (nama, no_rek, hash_pin, no_telp, saldo))
            self.connection.commit()
            cursor.close()
            return True
        except Exception as e:
            return {"error": str(e)}
        
    def CheckPin(self, no, pin):
        hash_pin = self.hash_value(pin)
        # if self.get_byNoTelp(no) : 
        cursor = self.connection.cursor(dictionary=True)
        result = []
        sql = "SELECT pin FROM bankbca WHERE no_telp = {}" .format((no))
        cursor.execute(sql)
        for row in cursor.fetchall():
            result.append({
                'pin' : row['pin'],
            })
        cursor.close()
        if row and result[pin] == hash_pin:
            # return {'status': 'Payment Success'}
            return True
        else:
            # return {'status': 'Wrong PIN'}
            return False
        # else:
        #     return {'status': 'Wrong VA'}


class Database(DependencyProvider):

    connection_pool = None

    def __init__(self):
        try:
            #database pool itu buka banyak koneksi.
            self.connection_pool = mysql.connector.pooling.MySQLConnectionPool(
                pool_name="database_pool",
                pool_size=10,
                pool_reset_session=True,
                host='localhost',
                database='soa',
                user='root',
                password=''
            )
        except Error as e :
            print ("Error while connecting to MySQL using Connection pool ", e)

    def get_dependency(self, worker_ctx):
        return DatabaseWrapper(self.connection_pool.get_connection())

    # def get_dependency(self, worker_ctx):
    #     # encryption_key = b'your-encryption-key'  # Ensure this is securely managed
    #     # from cryptography.fernet import Fernet
    #     encryption_key = Fernet.generate_key()
    #     print(encryption_key.decode())
    #     # return DatabaseWrapper(self.connection_pool.get_connection(), encryption_key)