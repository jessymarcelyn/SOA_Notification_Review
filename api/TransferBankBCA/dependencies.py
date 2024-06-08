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
    # def __init__(self, connection, encryption_key):
    #     self.connection = connection
    #     self.cipher_suite = Fernet(encryption_key)

    @staticmethod
    def generate_key():
        return Fernet.generate_key()

    def encrypt_value(self, value):
        return self.cipher_suite.encrypt(value.encode()).decode()

    def decrypt_value(self, encrypted_value):
        return self.cipher_suite.decrypt(encrypted_value.encode()).decode()

    def hash_value(self, value):
        return hashlib.sha256(value.encode()).hexdigest()
    
    #GET berdasarkan id_transaksi
    def get_byIDTrans(self, idTrans):
        cursor = self.connection.cursor(dictionary=True)
        result = []
        sql = "SELECT * FROM transbca WHERE id = {}" .format((idTrans))
        cursor.execute(sql)
        for row in cursor.fetchall():
            result.append({
                'id' : row['id'],
                'timestamp_trans' : row['timestamp_trans'],
                'no_rek' : row['no_rek'],
                'nominal' : row['nominal'],
                'status' : row['status'],
                'va' : row['va']
            })
        cursor.close()
        if result:
            return result
        else:
            return None
        
    #GET status berdasarkan id_transaksi
    def get_status_byIDTrans(self, idTrans):
        cursor = self.connection.cursor(dictionary=True)
        result = []
        sql = "SELECT status FROM transbca WHERE id = {}" .format((idTrans))
        cursor.execute(sql)
        for row in cursor.fetchall():
            result.append({
                'status' : row['status']
            })
        cursor.close()
        # return result
        if result:
            return result # Asumsikan hanya ada satu notifikasi dengan ID tertentu
        else:
            return None
        
    #GET untuk cek timestamp > 2 menit berdasarkan id_trans
    def get_timestamp_byIDTrans(self, idTrans):
        cursor = self.connection.cursor(dictionary=True)
        sql = "SELECT timestamp_trans, status FROM transbca WHERE id = {}" .format((idTrans))
        cursor.execute(sql)
        row = cursor.fetchone()
        cursor.close()

        if row:
            status_db = row['status']
            timestamp_db = row['timestamp_trans']
            local_timezone = pytz.timezone("Asia/Jakarta")
            current_time = datetime.now(local_timezone)
            timestamp_local = local_timezone.localize(timestamp_db)
            if status_db == 'success':
                return {'status': 'Payment Success'}
            else:   
                if current_time - timestamp_local > timedelta(minutes=2):
                    cursor2 = self.connection.cursor(dictionary=True)
                    sql = "UPDATE transbca SET status = 'failed' WHERE id = {}" .format((idTrans))
                    cursor2.execute(sql)
                    row2 = cursor2.fetchone()
                    cursor2.close()
                    return {'status': 'failed'}
                else:
                    return {'status': 'Still Waiting For Payment'}

    # Add Transaksi into tabel transaksi transfer bank
    def create_trans(self, no_rek, nominal, va):
        hashed_noRek = self.hash_value(no_rek)
        # hashed_va = self.hash_value(va)
        status = 'ongoing'
        try:
            cursor = self.connection.cursor(dictionary=True)
            sql = """
            INSERT INTO transbca (
                no_rek, nominal, va, status, timestamp_trans
            ) VALUES (%s, %s, %s, %s, NOW())
            """
            cursor.execute(sql, (hashed_noRek, nominal, va, status))
            self.connection.commit()
            cursor.close()
            return True
        except Exception as e:
            return {"error": str(e)}

    # Pay transaksi and set status to success
    def create_trans(self, idTrans):
        cursor = self.connection.cursor(dictionary=True)
        sql = "UPDATE transbca SET status = 'success' WHERE id = {}" .format((idTrans))
        cursor.execute(sql)
        cursor.close()
        return {"Status updated to success. Payment is already paid."}

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